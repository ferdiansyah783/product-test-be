<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_id',
        'tier',
        'price',
    ];

    const TIERS = [
        'Non Member',
        'Basic',
        'Premium',
    ];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public static function validateTier($tier)
    {
        return in_array($tier, self::TIERS);
    }
}
