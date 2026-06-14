<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name'];

    // Map custom timestamp columns
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
