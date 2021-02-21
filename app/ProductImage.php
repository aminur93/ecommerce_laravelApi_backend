<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductImage extends Model
{
    protected $guarded = [];

    public static function getProductImage($product_id)
    {
        $product_image = DB::table('product_images')
            ->select(
                'product_images.*',
                'products.name as name'
            )
            ->join('products','product_images.product_id','=','products.id')
            ->where('product_images.product_id', $product_id)
            ->get();
        return $product_image;
    }
}
