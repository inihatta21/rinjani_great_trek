<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showAdminForgotPasswordForm()
    {
        return view('auth.forgot-password-admin');
    }

    public function adminAccountEdit(Request $request)
    {
        $adminId = $request->session()->get('admin_user.id');
        $adminUser = User::find($adminId);

        if (! $adminUser) {
            $request->session()->forget(['admin_token', 'admin_user']);

            return redirect()->route('admin.login');
        }

        return view('admin.account-edit', [
            'adminUser' => $adminUser,
        ]);
    }

    public function adminAccountUpdate(Request $request): JsonResponse|RedirectResponse
    {
        $adminUser = null;

        if ($request->expectsJson() || $request->is('api/*')) {
            $token = $request->bearerToken();

            if (! $token) {
                return response()->json([
                    'message' => 'Token tidak ditemukan.',
                ], 401);
            }

            $adminUser = User::where('token', hash('sha256', $token))->first();

            if (! $adminUser) {
                return response()->json([
                    'message' => 'Token tidak valid.',
                ], 401);
            }
        } else {
            $adminId = $request->session()->get('admin_user.id');
            $adminUser = User::find($adminId);
        }

        if (! $adminUser) {
            $request->session()->forget(['admin_token', 'admin_user']);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'User admin tidak ditemukan.',
                ], 404);
            }

            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($adminUser->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'no_wa' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9]{8,20}$/'],
        ]);

        $adminUser->username = $validated['username'];
        $adminUser->no_wa = $validated['no_wa'] ?? null;

        if (! empty($validated['password'])) {
            $adminUser->password = $validated['password'];
        }

        $adminUser->save();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Data akun berhasil diperbarui.',
                'user' => [
                    'id' => $adminUser->id,
                    'username' => $adminUser->username,
                    'no_wa' => $adminUser->no_wa,
                ],
            ]);
        }

        $request->session()->put('admin_user', [
            'id' => $adminUser->id,
            'username' => $adminUser->username,
            'no_wa' => $adminUser->no_wa,
        ]);

        return back()->with('success', 'Data akun berhasil diperbarui.');
    }

    public function adminLogin(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (! $user || ! $this->isValidPassword($validated['password'], $user)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Username atau password salah.',
                ], 401);
            }

            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->withInput($request->only('username'));
        }

        $token = (string) Str::uuid();
        $tokenExpiresAt = now()->addDay();
        $user->token = hash('sha256', $token);
        $user->token_expires_at = $tokenExpiresAt;
        $user->save();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Login berhasil.',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'no_wa' => $user->no_wa,
                ],
                'expires_at' => $tokenExpiresAt->toDateTimeString(),
            ]);
        }

        $request->session()->put('admin_token', $token);
        $request->session()->put('admin_user', [
            'id' => $user->id,
            'username' => $user->username,
            'no_wa' => $user->no_wa,
        ]);
        $request->session()->regenerate();

        return redirect('/admin-dashboard');
    }

    public function adminForgotPassword(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (! $user) {
            $genericMessage = 'Jika username terdaftar, link reset akan dikirim ke WhatsApp admin.';

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => $genericMessage,
                ]);
            }

            return back()->with('success', $genericMessage);
        }

        $rawToken = Str::random(64);
        $tokenHash = Hash::make($rawToken);
        $expiresAt = now()->addMinutes(30);

        DB::table('admin_password_resets')->updateOrInsert(
            ['username' => $user->username],
            [
                'token' => $tokenHash,
                'expires_at' => $expiresAt,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $waNumberSource = $user->no_wa
            ?: User::whereNotNull('no_wa')->orderBy('id')->value('no_wa')
            ?: env('WHATSAPP_SELLER_NUMBER', '6281234567890');

        $waNumber = preg_replace('/\D+/', '', (string) $waNumberSource);
        $resetUrl = route('admin.password.reset', ['token' => $rawToken, 'username' => $user->username]);
        $message = "Permintaan reset password admin diterima.\nUsername: {$user->username}\nLink reset (berlaku 30 menit): {$resetUrl}";
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode($message);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Jika username terdaftar, link reset akan dikirim ke WhatsApp admin.',
                'wa_url' => $waUrl,
            ]);
        }

        return redirect()->away($waUrl);
    }

    public function showAdminResetPasswordForm(Request $request, string $token): RedirectResponse|\Illuminate\Contracts\View\View
    {
        $username = (string) $request->query('username', '');
        $resetData = DB::table('admin_password_resets')
            ->where('username', $username)
            ->first();

        if (! $resetData) {
            return redirect()
                ->route('admin.password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        if (Carbon::parse($resetData->expires_at)->isPast()) {
            DB::table('admin_password_resets')->where('username', $username)->delete();

            return redirect()
                ->route('admin.password.request')
                ->with('error', 'Link reset password sudah kedaluwarsa.');
        }

        if (! Hash::check($token, $resetData->token)) {
            return redirect()
                ->route('admin.password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        return view('auth.reset-password-admin', [
            'token' => $token,
            'username' => $username,
        ]);
    }

    public function resetAdminPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $resetData = DB::table('admin_password_resets')
            ->where('username', $validated['username'])
            ->first();

        if (! $resetData) {
            return redirect()
                ->route('admin.password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        if (Carbon::parse($resetData->expires_at)->isPast()) {
            DB::table('admin_password_resets')->where('username', $validated['username'])->delete();

            return redirect()
                ->route('admin.password.request')
                ->with('error', 'Link reset password sudah kedaluwarsa.');
        }

        if (! Hash::check($validated['token'], $resetData->token)) {
            return redirect()
                ->route('admin.password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        $user = User::where('username', $validated['username'])->first();
        if (! $user) {
            return redirect()
                ->route('admin.password.request')
                ->with('error', 'User admin tidak ditemukan.');
        }

        $user->password = $validated['password'];
        $user->token = null;
        $user->token_expires_at = null;
        $user->save();

        DB::table('admin_password_resets')->where('username', $validated['username'])->delete();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    public function adminLogout(Request $request): JsonResponse|RedirectResponse
    {
        $token = $request->bearerToken()
            ?? $request->session()->get('admin_token');

        if (! $token) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Token tidak ditemukan.',
                ], 401);
            }

            $request->session()->forget(['admin_token', 'admin_user']);

            return redirect()->route('admin.login');
        }

        $user = User::where('token', hash('sha256', $token))->first();

        if (! $user) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Token tidak valid.',
                ], 401);
            }

            $request->session()->forget(['admin_token', 'admin_user']);

            return redirect()->route('admin.login');
        }

        $user->token = null;
        $user->token_expires_at = null;
        $user->save();

        $request->session()->forget(['admin_token', 'admin_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()->route('admin.login');
        }

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }

    private function isValidPassword(string $rawPassword, User $user): bool
    {
        if (Hash::check($rawPassword, $user->password)) {
            return true;
        }

        // Backward compatibility: migrate legacy plain-text password to hash on successful login.
        if (hash_equals((string) $user->password, $rawPassword)) {
            $user->password = $rawPassword;
            $user->save();

            return true;
        }

        return false;
    }
}
