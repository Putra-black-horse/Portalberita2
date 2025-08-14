<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Author;

class SearchController extends Controller
{
  public function search(Request $request)
    {
        $query = trim($request->q);

        // 1. Cek kategori berita berdasarkan kolom `title`
        $kategori = NewsCategory::where('title', 'like', "%$query%")->first();
        if ($kategori) {
            return redirect()->route('news.category', ['slug' => $kategori->slug]);
        }

        // 2. Cek judul berita (perbaiki: gunakan kolom `title`)
        $berita = News::where('title', 'like', "%$query%")->first();
        if ($berita) {
            return redirect()->route('news.show', ['slug' => $berita->slug]);
        }

        // 3. Cek nama author
        $author = Author::where('nama', 'like', "%$query%")->first();
        if ($author) {
            return redirect()->route('author.show', ['username' => $author->username]);
        }

        // 4. Tidak ditemukan
        return redirect()->route('landing')->with('message', 'Hasil pencarian tidak ditemukan.');
    }

}
