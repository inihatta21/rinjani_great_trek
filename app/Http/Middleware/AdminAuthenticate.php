<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionToken = $request->session()->get('admin_token');
        $adminId = $request->session()->get('admin_user.id');

        if (! $sessionToken || ! $adminId) {
            return redirect()->route('admin.login');
        }

        $user = User::find($adminId);

        if (! $user || ! $user->token || ! hash_equals((string) $user->token, hash('sha256', $sessionToken))) {
            $request->session()->forget(['admin_token', 'admin_user']);

            return redirect()->route('admin.login');
        }

        if (! $user->token_expires_at || Carbon::parse($user->token_expires_at)->isPast()) {
            $user->token = null;
            $user->token_expires_at = null;
            $user->save();

            $request->session()->forget(['admin_token', 'admin_user']);

            return redirect()
                ->route('admin.login')
                ->with('error', 'Sesi login sudah kedaluwarsa. Silakan login kembali.');
        }

        return $next($request);
    }
}
