<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'category_id', // Menambahkan category_id agar terdeteksi relasinya di database
        'price',
        'image',
        'description',
    ];

    /**
     * Mengambil daftar kategori dari Model Category.
     */
    public static function getAvailableCategories()
    {
        Category::getList(); // Trigger sync
        return Category::all(); // Mengembalikan koleksi model Category (ID & Nama)
    }

    // RELASI
    public function category_info()
    {
        // Relasi formal ke tabel categories menggunakan ID
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // RATING
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }
}
