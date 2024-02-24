<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'code',
        'price',
        'discount',
        'smallDescription',
        'description',
        'paid',
        'facebooklink',
        'twitterlink',
        'youtubelink',
        'instagramlink'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function scopeWithFilters($query)
    {
        return $query->when(count(request()->input('categories', [])), function ($query) {
            $query->whereIn('category.id', request()->input('categories'));
        });
    }
}
