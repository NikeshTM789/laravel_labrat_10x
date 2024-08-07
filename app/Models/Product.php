<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia, MediaCollections\Models\Media};
use Spatie\Image\Enums\CropPosition;
use App\Models\{Like,Comment,SubComment};

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    const MEDIA = ['gallery' => 'gallery','featured' => 'featured'];

    protected $appends = ['discount_price'];

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'discount',
        'featured',
        'details'
    ];

    public function likes(){
        return $this->morphOne(Like::class,'likes');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getDiscountPriceAttribute()
    {
        return $this->price - $this->discount;
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function comment(){
        return $this->hasOne(Comment::class)->latestOfMany();
    }

    public function subcomments(){
        return $this->hasManyThrough(SubComment::class,Comment::class,'product_id','comment_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
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
                    ->width(200)
                    ->height(200);
            });
    }
}
