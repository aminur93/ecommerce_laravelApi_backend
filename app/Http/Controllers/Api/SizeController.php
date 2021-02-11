<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Size;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->get();

        return response()->json([
            'sizes' => $sizes,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function store(SizeRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //create sizes
                $size = new Size();

                $size->size_name = $request->size_name;
                $size->size_code = $request->size_code;

                $size->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Sizes Added Successful',
                    'status_code' => 200
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);

        return \response()->json([
            'size' => $size,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function update(SizeRequest $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //update size

                $size = Size::findOrFail($id);

                $size->size_name = $request->size_name;
                $size->size_code = $request->size_code;

                $size->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Size Updated Successful',
                    'status_code' => 200
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return \response()->json([
            'message' => 'Size Destroy Successful',
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
