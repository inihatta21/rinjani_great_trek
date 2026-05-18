<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function managePage(): View
    {
        $kategoriList = Kategori::withCount('paketList')
            ->orderBy('nama_kategori')
            ->get();

        return view('admin.kategori-index', [
            'kategoriList' => $kategoriList,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategori,nama_kategori'],
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function editPage(int $id): RedirectResponse|View
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        return view('admin.kategori-edit', [
            'kategori' => $kategori,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategori,nama_kategori,'.$kategori->id],
        ]);

        $kategori->update($validated);

        // Keep backward compatibility with paket.kategori text column.
        $kategori->paketList()->update(['kategori' => $validated['nama_kategori']]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        if ($kategori->paketList()->exists()) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai paket.');
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
