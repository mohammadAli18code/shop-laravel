<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id'];


    public function scopeApproved($query){
        return $query->where('status' , 'approved');
    }

    public function scopePending($query){
        return $query->where('status' , 'pending');
    }

    public function scopeUnseen($query){
        return $query->where('status' , 'unseen');
    }

    public function favorites(){
        return $this->belongsToMany('App\Models\Product' , 'favorites', 'product_id', 'user_id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function comments(){
        return $this->morphMany('App\Models\Comment' , 'commentable');
    }

    public function images(){
        return $this->morphMany('App\Models\Image' , 'imageable')->select(['path']);
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Models\Image' , 'imageable')->oldest(); 
        // oldest() یعنی اولین عکس رو میاره
    }


    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    public function discounts(){
        return $this->belongsToMany('App\Models\Discount');
    } 

    // public function timeDiscountProducts()
    // {
    //     return $this->belongsToMany('App\Models\Discount')
    //                 ->where('start_date', isNotNull())->where('end_date', isNotNull());
    // }

    public function colors(){
        return $this->belongsToMany('App\Models\Color'  , 'product_colors');
    }

    public function cartForCurrentUser()
    {
            return $this->hasManyThrough(
                CartItem::class,   // مدل هدف
                Cart::class,       // مدل میانی
                'user_id',         // FK جدول میانی به جدول users
                'product_id',      // FK جدول target به جدول products
                'id',              // PK جدول users
                'id'               // PK جدول cart_items
            )->where('carts.status', 'active'); // فقط سبد فعال
    }

    public function carts(){
        return $this->hasMany('App\Models\Cart');
    }

    public function attributeValues()
    {
        return $this->belongsToMany('App\Models\AttributeValue', 'product_attribute_values');
    }

    // public function getActiveDiscountAttribute()
    // {

    //     $ $this->discounts()->where('user_id', auth()->id());
    // }

    public function getActiveDiscountAttribute()
    {
        // آخرین تخفیف ثبت‌شده (میتونی به جای latest، شرط active هم بزاری)
        return $this->discounts()->latest()->first();
    }

    public function getDiscountAmountAttribute()
    {
        $discount = $this->active_discount;

        // if (!$this->$discount) {
        //     return '';
        // }
        if($discount){
            if ($discount->type === 'percent') {
                return $this->price * ($discount->value / 100);
            }

            if ($discount->type === 'fixed') {
                return $discount->value;
            }
        }
        return 0;
    }

    public function getDiscountPercentageAttribute()
    {
        $discount = $this->active_discount;

        if($discount){
            if ($discount->type === 'fixed') {
                return ($this->$discount->value / $this->price) * 100;

            }elseif ($discount->type === 'percent'){
                return $discount->value;
        }
        }else{
            return 0;
        }
    }

    public function getFinalPriceAttribute()
    {
        $discount = $this->active_discount;

        if (!$discount) {
            return $this->price;
        }

        if ($discount->type === 'percent') {
            return $this->price - ($this->price * $discount->value / 100);
        }

        if ($discount->type === 'fixed') {
            return $this->price - $discount->value;
        }

        return $this->price;
    }
}
