<?php

namespace App\Http\Controllers\Api;

use App\Color;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();

        return response()->json([
            'colors' => $colors,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function store(ColorRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create color
                $color = new Color();

                $color->color_name = $request->color_name;
                $color->color_code =$request->color_code;

                $color->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Color Added Successful',
                    'status_code' => 200
                ], Response::HTTP_OK);
            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_OK);
            }
        }
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return \response()->json([
            'color' => $color,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function update(ColorRequest $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //update color

                $color = Color::findOrFail($id);

                $color->color_name = $request->color_name;
                $color->color_code = $request->color_code;

                $color->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Color Updated Successful',
                    'status_code' => 200
                ], Response::HTTP_OK);
            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return \response()->json([
            'message' => 'Color Deleted Successful',
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
