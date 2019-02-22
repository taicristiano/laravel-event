<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static function getCart()
    {
        return self::select('products.id', 'carts.id as cart_id', 'products.name', 'products.price', 'cart_details.quantity', 'products.inStock')
                    ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                    ->join('products', 'products.id', '=', 'cart_details.product_id')
                    ->where('carts.user_id', \Auth::id())
                    ->where('carts.is_current', 1)
                    ->get();
    }
}
