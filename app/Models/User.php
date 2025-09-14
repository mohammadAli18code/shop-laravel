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


    public function scopeActive($query){
        return $query->where('is_active' , true);
    }

    public function scopeInactive($query){
        return $query->where('is_active' , false);
    }


    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function image(){
        return $this->morphOne('App\Models\Image' , 'imageable')->oldest();
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function favorites(){
        return $this->belongsToMany('App\Models\Product' , 'favorites');
    }


    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }

    public function cart(){
        return $this->hasOne('App\Models\Cart')->where('status', 'active');;
    }

    public function addresses(){
        return $this->hasMany('App\Models\Address');
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'gender',
        'country',
        'city',
        'password',
        'additional_info',
        'image',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
