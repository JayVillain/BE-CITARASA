<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'price_old',       // harga lama (kalau ada diskon)
        'tag',             // contoh: 'popular', 'vegan', 'pedas'
        'menu_category_id'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }
}
