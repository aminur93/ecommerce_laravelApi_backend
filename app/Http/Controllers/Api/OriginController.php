<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OriginRequest;
use App\Origin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OriginController extends Controller
{
    public function index()
    {
        $origins = Origin::latest()->get();

        return response()->json([
            'origins' => $origins,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function store(OriginRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //create origin

                $origin = new Origin();

                $origin->origin_name = $request->origin_name;

                $origin->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Origin Added Successfully',
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
        $origin = Origin::findOrFail($id);

        return \response()->json([
            'origin' => $origin,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function update(OriginRequest $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //update origin

                $origin = Origin::findOrFail($id);

                $origin->origin_name = $request->origin_name;

                $origin->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Origin Updated Successful',
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
        $origin = Origin::findOrFail($id);
        $origin->delete();

        return \response()->json([
            'message' => 'Origin Deleted Successful',
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
