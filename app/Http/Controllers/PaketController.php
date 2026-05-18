<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Kategori;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaketController extends Controller
{
    public function publicByKategori(int $id): View|RedirectResponse
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return redirect('/')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();
        $kategoriPaketList = Paket::where('kategori_id', $kategori->id)
            ->orderByDesc('id_paket')
            ->get();
        $galleryList = Gallery::orderByDesc('id_foto')->get();

        return view('paket-kategori', [
            'kategori' => $kategori,
            'paketList' => $paketList,
            'kategoriPaketList' => $kategoriPaketList,
            'galleryList' => $galleryList,
        ]);
    }

    public function publicDetail(int $id_paket): View|RedirectResponse
    {
        $paket = Paket::find($id_paket);
        $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();
        $recommendedPaketList = Paket::where('id_paket', '!=', $id_paket)
            ->inRandomOrder()
            ->take(3)
            ->get();
        $heroFoto = Gallery::inRandomOrder()->first();
        $galleryList = Gallery::orderByDesc('id_foto')->get();

        if (! $paket) {
            return redirect('/')
                ->with('error', 'Paket tidak ditemukan.');
        }

        return view('paket-detail', [
            'paket' => $paket,
            'paketList' => $paketList,
            'recommendedPaketList' => $recommendedPaketList,
            'heroFoto' => $heroFoto,
            'galleryList' => $galleryList,
        ]);
    }

    public function managePage()
    {
        $paketList = Paket::orderBy('kategori')->orderBy('id_paket')->get();

        return view('admin.paket-index', [
            'paketList' => $paketList,
        ]);
    }

    public function createPage()
    {
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        return view('admin.paket-create', [
            'kategoriList' => $kategoriList,
        ]);
    }

    public function editPage(int $id_paket): RedirectResponse|\Illuminate\Contracts\View\View
    {
        $paket = Paket::find($id_paket);

        if (! $paket) {
            return redirect()
                ->route('admin.paket.index')
                ->with('error', 'Data paket tidak ditemukan.');
        }

        return view('admin.paket-edit', [
            'paket' => $paket,
            'kategoriList' => Kategori::orderBy('nama_kategori')->get(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $data = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();

        return response()->json([
            'message' => 'Data paket berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $validated = $this->validatePaketData($request);

        $paket = Paket::create($validated);

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.paket.index')
                ->with('success', 'Data paket berhasil ditambahkan.');
        }

        return response()->json([
            'message' => 'Data paket berhasil ditambahkan.',
            'data' => $paket,
        ], 201);
    }

    public function show(Request $request, int $id_paket): JsonResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $paket = Paket::find($id_paket);

        if (! $paket) {
            return response()->json([
                'message' => 'Data paket tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail paket berhasil diambil.',
            'data' => $paket,
        ]);
    }

    public function update(Request $request, int $id_paket): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $paket = Paket::find($id_paket);

        if (! $paket) {
            return response()->json([
                'message' => 'Data paket tidak ditemukan.',
            ], 404);
        }

        $validated = $this->validatePaketData($request);

        $paket->update($validated);

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.paket.index')
                ->with('success', 'Data paket berhasil diperbarui.');
        }

        return response()->json([
            'message' => 'Data paket berhasil diperbarui.',
            'data' => $paket,
        ]);
    }

    public function destroy(Request $request, int $id_paket): JsonResponse|RedirectResponse
    {
        $authResponse = $this->authorizeAdmin($request);
        if ($authResponse) {
            return $authResponse;
        }

        $paket = Paket::find($id_paket);

        if (! $paket) {
            return response()->json([
                'message' => 'Data paket tidak ditemukan.',
            ], 404);
        }

        $paket->delete();

        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()
                ->route('admin.paket.index')
                ->with('success', 'Data paket berhasil dihapus.');
        }

        return response()->json([
            'message' => 'Data paket berhasil dihapus.',
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

    private function validatePaketData(Request $request): array
    {
        $validated = $request->validate([
            'nama_paket' => ['required', 'string', 'max:50'],
            'nama_paket_en' => ['nullable', 'string', 'max:100'],
            'kategori_id' => ['required', 'integer', 'exists:kategori,id'],
            'harga' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['required', 'string'],
            'deskripsi_en' => ['nullable', 'string'],
            'itinerary' => ['required', 'string'],
            'itinerary_en' => ['nullable', 'string'],
        ]);

        $kategori = Kategori::find($validated['kategori_id']);
        $validated['kategori'] = $kategori?->nama_kategori ?? 'Umum';

        return $validated;
    }
}
