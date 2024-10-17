<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_category',
        'description',
    ];

    const CATEGORIES = [
        'Rokok',
        'Obat',
        'Lainnya',
    ];

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public static function validateCategory($category)
    {
        return in_array($category, self::CATEGORIES);
    }
}
