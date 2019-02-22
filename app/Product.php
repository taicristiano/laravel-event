<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'price', 'inStock', 'image'];

    public static function getProducts()
    {
        return self::select(['id', 'name', 'description', 'price', 'inStock', 'image'])->get();
    }
}
