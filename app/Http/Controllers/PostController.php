<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\models\Post;
use App\models\User;

class PostController extends Controller
{

    // menampilkan daftar semua postingan
    public function index()
    {

        // mengambil semua postingan terbaru
        $posts = Post::latest();

        // menginisialisasi variabel judul
        $title = '';

        // memeriksa apakah ada parameter 'category' dalam permintaan
        if (request('category')) {
            // mencari kategori berdasarkan slug yang diberikan
            $category = Category::firstWhere('slug', request('category'));
            // mengganti judul dengan kategori yang di pilih
            $title =  ' in ' . $category->name;
        }

        // memeriksa apakah ada parameter 'author' dalam permintaan
        if (request('author')) {
            // mencari user berdasarkan username yang diberikan dalam permintaan
            $author = User::firstWhere('username', request('author'));
            // mengganti judul dengan nama penulis yang di pilih 
            $title = ' by ' . $author->name;
        }
        // Mengembalikan tampilan "posts" dengan data yang sesuai
        return view('posts', [
            "title" => "All Posts" . $title,
            "active" => "posts",
            // memfilter dan mempaginate daftar postingan berdasarkan permintaan
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()
        ]);
    }

    // Mengembalikan tampilan "posts" dengan data yang sesuai
    public function show(Post $post)
    {
        // mengembalikan tampilan "post" dengan data postingan yang di pilih
        return view('post', [
            "title" => "Single Post",
            "active" => "po1sts",
            "post" => $post
        ]);
    }
}
