<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function publicIndex(): View
    {
        $galleryList = Gallery::orderByDesc('id_foto')->get();
        $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();

        return view('gallery-index', [
            'galleryList' => $galleryList,
            'paketList' => $paketList,
        ]);
    }

    public function managePage(): View
    {
        $galleryList = Gallery::orderBy('id_foto')->get();

        return view('admin.gallery-index', [
            'galleryList' => $galleryList,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $data = Gallery::orderByDesc('id_foto')->get();

        return response()->json([
            'message' => 'Data gallery berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $validated = $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:4096'],
        ]);

        $path = $this->storeImageInPublicStorageGallery($validated['foto']);
        $namaFoto = basename($path);

        $gallery = Gallery::create([
            'nama_foto' => $namaFoto,
            'path' => $path,
        ]);

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.gallery.index')
                ->with('success', 'Foto gallery berhasil ditambahkan.');
        }

        return response()->json([
            'message' => 'Foto gallery berhasil ditambahkan.',
            'data' => $gallery,
        ], 201);
    }

    public function destroy(Request $request, int $id_foto): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $gallery = Gallery::find($id_foto);

        if (! $gallery) {
            return response()->json([
                'message' => 'Foto gallery tidak ditemukan.',
            ], 404);
        }

        $this->deleteImageFromGalleryStorage($gallery->path);

        $gallery->delete();

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.gallery.index')
                ->with('success', 'Foto gallery berhasil dihapus.');
        }

        return response()->json([
            'message' => 'Foto gallery berhasil dihapus.',
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

    private function storeImageInPublicStorageGallery(UploadedFile $file): string
    {
        $targetDirectory = public_path('storage/uploads/gallery');
        File::ensureDirectoryExists($targetDirectory);
        $fileName = $file->hashName();
        $file->move($targetDirectory, $fileName);

        return 'storage/uploads/gallery/'.$fileName;
    }

    private function deleteImageFromGalleryStorage(?string $path): void
    {
        if (! filled($path)) {
            return;
        }

        $fileName = basename(str_replace('\\', '/', trim($path)));
        if ($fileName === '' || $fileName === '.' || $fileName === '..') {
            return;
        }

        $strictPublicFile = public_path('storage/uploads/gallery/'.$fileName);
        if (is_file($strictPublicFile)) {
            @unlink($strictPublicFile);
        }
    }
}
