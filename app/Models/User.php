<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'paid',
        'user_type',
        'name',
        'username',
        'email',
        'password',
        'logo',
        'phoneOne',
        'phoneTwo',
        'company_type',
        'facebooklink',
        'twitterlink',
        'youtubelink',
        'status'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function vendorChats()
    {
        return $this->hasMany(Chat::class, 'vendor_id');
    }
}
