<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class CategoryController extends Controller
{
    public function index()
    {
        //all category come in my table
        $category = Category::latest()->get();

        return response()->json([
            'categories' => $category,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function store(CategoryRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                // Step 1 : Create Category

                $category = new Category();
                $category->cat_name = $request->cat_name;
                $category->cat_slug = strtolower($request->cat_name);

                $category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Category Added Successfully'
                ],200);

            }catch(\Illuminate\Database\QueryException $e){
                DB::rollback();
                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],500);
            }
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return \response()->json([
            'edit_category' => $category,
            'status_code' => 200
        ],Response::HTTP_OK);
    }

    public function update(CategoryRequest $request,$id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                // Step 1 : Create Category

                $category = Category::findOrFail($id);

                $category->cat_name = $request->cat_name;
                $category->cat_slug = strtolower($request->cat_name);

                $category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Category Updated Successfully'
                ],200);

            }catch(\Illuminate\Database\QueryException $e){
                DB::rollback();
                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrfail($id);
        $category->delete();

        return \response()->json([
            'message' => 'category Deleted Successfully',
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
