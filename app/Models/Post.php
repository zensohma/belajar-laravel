<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    // kolom 'id' akan dijaga (guarded) dari mass assignment
    protected $guarded = ['id'];

    // load relasi 'category' dan 'author' secara otomatis ketika mengambil data post
    protected $with = ['category', 'author'];

    // metode scopeFilter digunakan untuk menerapkan filter pada query
    public function scopeFilter($query, array $filters)
    {

        // menerapkan filter pencarian berdasarkan judul atau isi postingan
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')->orWhere('body', 'like', '%' . $search . '%');
            });
        });

        // Menerapkan filter berdasarkan kategori
        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

             // Menerapkan filter berdasarkan penulis (author)
        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

    // definisi relasi category antara Post dan Category
    public function category()
    {   
        // satu post hanya mempunyai satu category (many to one relationship)
        return $this->BelongsTo(Category::class);
    }

    // definisi relasi 'author' antara Post dan User
    public function author()
    {
        // satu post hanya mempunyai satu user 
        return $this->belongsTo(User::class, 'user_id');
    }

    // menentukan kolom yang digunakan sebagai route key (slug)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Metode sluggable untuk menghasilkan slug berdasarkan kolom 'title'
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}

