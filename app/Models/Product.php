<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'discount',
        'featured',
        'details'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->uuid = \Str::uuid(); 
            $product->slug = substr(md5(uniqid(rand(), true)), 0, 10);
            $product->added_by = auth()->id();
        });
    }
}
