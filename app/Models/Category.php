<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name'];

    public $timestamps = false;

    /**
     * PUSAT KENDALI KATEGORI (Kodingan)
     */
    public static function getList()
    {
        $categories = [
            'Makanan Berat',
            'Camilan',
            'Minuman',
        ];

        // Jalankan sinkronisasi ke database otomatis
        self::syncFromCode($categories);

        return $categories;
    }

    /**
     * Fitur Auto-Sync: Memastikan kategori di atas selalu ada di tabel database.
     */
    protected static function syncFromCode($codeCategories)
    {
        foreach ($codeCategories as $name) {
            self::firstOrCreate(['category_name' => $name]);
        }
    }

    /**
     * RELASI: Satu kategori memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
