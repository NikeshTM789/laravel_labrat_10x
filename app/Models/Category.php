<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $item->uuid = \Str::uuid();
        });
    }

    public function name(): Attribute{
        return new Attribute(
            get: fn(String $value) => ucwords($value),
            set: fn(String $value) => $value
        );
    }
}
