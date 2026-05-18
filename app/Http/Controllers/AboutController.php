<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();
        $aboutParagraphs = trans('site.about.paragraphs');

        return view('about', [
            'paketList' => $paketList,
            'aboutParagraphs' => $aboutParagraphs,
        ]);
    }
}
