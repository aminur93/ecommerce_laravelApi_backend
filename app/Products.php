<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    protected $guarded = [];

    public static function getProducts()
    {
        $products = DB::table('products')
                    ->select(
                        'products.*',
                        'categories.cat_name as cat_name',
                        'sub_categories.sub_cat_name as sub_cat_name',
                        'brands.brand_name as brand_name',
                        'origins.origin_name as origin_name'
                    )
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('sub_categories','products.sub_cat_id','=','sub_categories.id')
                    ->join('brands','products.brand_id','=','brands.id')
                    ->join('origins','products.origin_id','=','origins.id')
                    ->orderBy('products.id','desc')
                    ->get();

        return $products;
    }
}
