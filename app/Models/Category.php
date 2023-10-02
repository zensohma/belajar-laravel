<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // kolom 'id' akan dijaga (guarded) dari mass assignment
    protected $guarded = ['id'];

    // definisi relasi 'posts' antara Category dan Post
    public function posts()
    {   
        // satu kategori bisa mempunyai banyak post (one to many relationship )
        return $this->hasMany(Post::class);
    }
}

