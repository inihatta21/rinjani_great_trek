<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function publicIndex(): View
    {
        $artikelList = Artikel::orderByDesc('id_artikel')->get();
        $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();

        return view('artikel-index', [
            'artikelList' => $artikelList,
            'paketList' => $paketList,
        ]);
    }

    public function publicDetail(int $id_artikel): View|RedirectResponse
    {
        $artikel = Artikel::find($id_artikel);
        $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();

        if (! $artikel) {
            return redirect('/')
                ->with('error', 'Artikel tidak ditemukan.');
        }

        $rekomendasiArtikel = Artikel::where('id_artikel', '!=', $artikel->id_artikel)
            ->orderByDesc('id_artikel')
            ->take(3)
            ->get();

        return view('artikel-detail', [
            'artikel' => $artikel,
            'paketList' => $paketList,
            'rekomendasiArtikel' => $rekomendasiArtikel,
        ]);
    }

    public function managePage(): View
    {
        $artikelList = Artikel::orderBy('id_artikel')->get();

        return view('admin.artikel-index', [
            'artikelList' => $artikelList,
        ]);
    }

    public function createPage(): View
    {
        return view('admin.artikel-create');
    }

    public function editPage(int $id_artikel): RedirectResponse|View
    {
        $artikel = Artikel::find($id_artikel);

        if (! $artikel) {
            return redirect()
                ->route('admin.artikel.index')
                ->with('error', 'Data artikel tidak ditemukan.');
        }

        return view('admin.artikel-edit', [
            'artikel' => $artikel,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $data = Artikel::orderByDesc('id_artikel')->get();

        return response()->json([
            'message' => 'Data artikel berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $validated = $this->validateArtikelStoreData($request);
        $gambarPath = $this->storeImageInPublicDirectory($request->file('gambar'), 'uploads/artikel');

        $artikel = Artikel::create([
            'judul_artikel' => $validated['judul_artikel'],
            'judul_artikel_en' => $validated['judul_artikel_en'] ?? null,
            'deskripsi' => $validated['deskripsi'],
            'deskripsi_en' => $validated['deskripsi_en'] ?? null,
            'gambar_path' => $gambarPath,
        ]);

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.artikel.index')
                ->with('success', 'Data artikel berhasil ditambahkan.');
        }

        return response()->json([
            'message' => 'Data artikel berhasil ditambahkan.',
            'data' => $artikel,
        ], 201);
    }

    public function show(Request $request, int $id_artikel): JsonResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $artikel = Artikel::find($id_artikel);

        if (! $artikel) {
            return response()->json([
                'message' => 'Data artikel tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail artikel berhasil diambil.',
            'data' => $artikel,
        ]);
    }

    public function update(Request $request, int $id_artikel): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $artikel = Artikel::find($id_artikel);

        if (! $artikel) {
            return response()->json([
                'message' => 'Data artikel tidak ditemukan.',
            ], 404);
        }

        $validated = $this->validateArtikelUpdateData($request);

        $payload = [
            'judul_artikel' => $validated['judul_artikel'],
            'judul_artikel_en' => $validated['judul_artikel_en'] ?? null,
            'deskripsi' => $validated['deskripsi'],
            'deskripsi_en' => $validated['deskripsi_en'] ?? null,
        ];

        if ($request->hasFile('gambar')) {
            $this->deleteImageFromKnownLocations($artikel->gambar_path);

            $payload['gambar_path'] = $this->storeImageInPublicDirectory($request->file('gambar'), 'uploads/artikel');
        }

        $artikel->update($payload);

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.artikel.index')
                ->with('success', 'Data artikel berhasil diperbarui.');
        }

        return response()->json([
            'message' => 'Data artikel berhasil diperbarui.',
            'data' => $artikel,
        ]);
    }

    public function destroy(Request $request, int $id_artikel): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $artikel = Artikel::find($id_artikel);

        if (! $artikel) {
            return response()->json([
                'message' => 'Data artikel tidak ditemukan.',
            ], 404);
        }

        $this->deleteImageFromKnownLocations($artikel->gambar_path);

        $artikel->delete();

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.artikel.index')
                ->with('success', 'Data artikel berhasil dihapus.');
        }

        return response()->json([
            'message' => 'Data artikel berhasil dihapus.',
        ]);
    }

    private function authorizeAdmin(Request $request): ?JsonResponse
    {
        $token = $request->bearerToken()
            ?? $request->session()->get('admin_token');

        if (! $token) {
            return response()->json([
                'message' => 'Token tidak ditemukan.',
            ], 401);
        }

        $user = User::where('token', hash('sha256', $token))->first();

        if (! $user) {
            return response()->json([
                'message' => 'Token tidak valid.',
            ], 401);
        }

        if (! $user->token_expires_at || Carbon::parse($user->token_expires_at)->isPast()) {
            $user->token = null;
            $user->token_expires_at = null;
            $user->save();

            return response()->json([
                'message' => 'Token sudah kedaluwarsa. Silakan login kembali.',
            ], 401);
        }

        return null;
    }

    private function validateArtikelStoreData(Request $request): array
    {
        return $request->validate([
            'judul_artikel' => ['required', 'string', 'max:255'],
            'judul_artikel_en' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'deskripsi_en' => ['nullable', 'string'],
            'gambar' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:4096'],
        ]);
    }

    private function validateArtikelUpdateData(Request $request): array
    {
        return $request->validate([
            'judul_artikel' => ['required', 'string', 'max:255'],
            'judul_artikel_en' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'deskripsi_en' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:4096'],
        ]);
    }

    private function storeImageInPublicDirectory(\Illuminate\Http\UploadedFile $file, string $directory): string
    {
        $cleanDirectory = trim($directory, '/');
        $filename = $file->hashName();

        File::ensureDirectoryExists(public_path($cleanDirectory));
        $file->move(public_path($cleanDirectory), $filename);

        return $cleanDirectory.'/'.$filename;
    }

    private function deleteImageFromKnownLocations(?string $path): void
    {
        if (! filled($path)) {
            return;
        }

        $cleanPath = ltrim($path, '/');
        $publicFile = public_path($cleanPath);

        if (is_file($publicFile)) {
            @unlink($publicFile);
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
        }
    }
}
