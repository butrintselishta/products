<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'price',
        'description',
        'category_id',
        'image',
    ];

    public function rating() {
        return $this->hasOne(Rating::class);
    }
}
