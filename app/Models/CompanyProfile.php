<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    // WAJIB: Daftarkan semua kolom agar bisa disimpan
    protected $fillable = [
        'hero_title', 
        'history_text', 
        'vision', 
        'mission', 
        'map_embed'
    ];
}