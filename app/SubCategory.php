<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubCategory extends Model
{
    protected $guarded = [];

    public static function getSubCategory(){
        $sub_categories = DB::table('sub_categories')
                            ->select(
                                'sub_categories.id as id',
                                'sub_categories.category_id as category_id',
                                'sub_categories.sub_cat_name as sub_cat_name',
                                'categories.cat_name as cat_name'
                            )
                            ->join('categories','sub_categories.category_id','=','categories.id')
                            ->orderBy('sub_categories.id','desc')
                            ->get()
                            ->toArray();

        return $sub_categories;
    }

    public static function getSubCat($category_id)
    {
        $subCat = DB::table('sub_categories')
            ->select(
                'sub_categories.id as id',
                'sub_categories.sub_cat_name as sub_cat_name'
            )
            ->join('categories','sub_categories.category_id','=','categories.id')
            ->where('sub_categories.category_id', $category_id)
            ->get();

        return $subCat;
    }
}
