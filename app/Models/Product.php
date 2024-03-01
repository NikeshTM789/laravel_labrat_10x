<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia, MediaCollections\Models\Media};
use Spatie\Image\Enums\CropPosition;
class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    const MEDIA = ['gallery' => 'gallery','featured' => 'featured'];

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'discount',
        'featured',
        'details'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->uuid = \Str::uuid();
            $product->slug = substr(md5(uniqid(rand(), true)), 0, 10);
        });
    }

    public function registerMediaCollections(): void
    {
        $this->commonMediaProps($this->addMediaCollection(self::MEDIA['featured'])->singleFile());
        $this->commonMediaProps($this->addMediaCollection(self::MEDIA['gallery']));
    }

    private function commonMediaProps($media){
        $media->useDisk('media')
            ->acceptsMimeTypes(['image/jpeg','image/png'])
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('dropzone')->crop(120, 120);
                $this->addMediaConversion('thumbnail')
                    ->width(500)
                    ->height(500);
            });;
    }
}
