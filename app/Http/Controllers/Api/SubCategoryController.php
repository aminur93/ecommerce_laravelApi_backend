<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::getSubCategory();

        return response()->json([
            'sub_categories' => $subCategories,
            'status_code' => 200
        ],200);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                // create sub category

                $sub_catgeory = new SubCategory();

                $sub_catgeory->category_id = $request->category_id;
                $sub_catgeory->sub_cat_name = $request->sub_cat_name;
                $sub_catgeory->sub_cat_slug = Str::slug($request->sub_cat_name);

                $sub_catgeory->save();

                DB::commit();

                return response()->json([
                    'message' => 'Sub category Added Successfully',
                    'status_code' => 200
                ],200);
            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],500);
            }
        }
    }

    public function edit($id)
    {
        $sub_category = SubCategory::findOrFail($id);

        return response()->json([
            'sub_category' => $sub_category,
            'status_code' => 200
        ],200);
    }

    public function update(Request $request,$id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update sub category

                $sub_category = SubCategory::findOrFail($id);

                $sub_category->category_id = $request->category_id;
                $sub_category->sub_cat_name = $request->sub_cat_name;
                $sub_category->sub_cat_slug = Str::slug($request->sub_cat_name);

                $sub_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Sub category Added Successfully',
                    'status_code' => 200
                ],200);
            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $sub_category->delete();

        return response()->json([
            'message' => 'Sub category Deleted Successfully',
            'status_code' => 200
        ],200);
    }
}
