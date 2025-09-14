<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'product_id', 'quantity', 'options'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // public function items(){
    //     $user = auth()->user();
    //     return Cart::with('product.discounts')
    //                 ->where('user_id', $user->id)
    //                 ->get();
    // }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function getTotalPriceAttribute(){
        $cartItems = $this->items()->with('product')->get();
        $total_price = $cartItems->sum(function($item){
            return  $item->product ? $item->product->price * $item->quantity : 0;
        });
        return $total_price;
    }

    public function getFinalPriceAttribute(){
        $cartItems = $this->items()->with('product')->get();
        $final = $cartItems->sum(function($item) {
            if (!$item->product) {
                return 0; // محصول حذف شده، قیمت 0
            }
            if ($item->product->final_price) {
                return $item->product->final_price * $item->quantity;
            }
            return $item->product->price * $item->quantity;
        });
        return $final;
    }

    public function getTotalDiscountAttribute(){
        $total_discount = $this->getTotalPriceAttribute() - $this->getFinalPriceAttribute();
        return $total_discount;
    }

}
