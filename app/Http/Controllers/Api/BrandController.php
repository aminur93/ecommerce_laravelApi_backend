<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();

        return response()->json([
            'brands' => $brands,
            'status_code' => 200
        ],200);
    }

    public function store(BrandRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //create brand

                $brand = new Brand();

                $brand->brand_name = $request->brand_name;
                $brand->brand_slug = Str::slug($request->brand_name);

                $brand->save();

                DB::commit();

                return response()->json([
                    'message' => 'Brand Added Successfully',
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
        $brand = Brand::findOrFail($id);

        return response()->json([
            'brand' => $brand,
            'status_code' => 200
        ],200);
    }

    public function update(Request $request,$id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update brand

                $brand = Brand::findOrFail($id);

                $brand->brand_name = $request->brand_name;
                $brand->brand_slug = Str::slug($request->brand_name);

                $brand->save();

                DB::commit();

                return response()->json([
                    'message' => 'Brand Updated Successfully',
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
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json([
            'message' => 'Brand Deleted Successfully',
        ]);
    }
}
