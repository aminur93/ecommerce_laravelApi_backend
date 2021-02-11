<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Material;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::latest()->get();

        return response()->json([
            'materials' => $materials,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function store(MaterialRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create Materials

                $material = new Material();

                $material->material_name = $request->material_name;

                $material->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Material Added Successful',
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
        $material = Material::findOrFail($id);

        return \response()->json([
            'material' => $material,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function update(MaterialRequest $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update materials

                $material = Material::findOrFail($id);

                $material->material_name = $request->material_name;

                $material->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Material Update Successful',
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
        $material = Material::findOrFail($id);
        $material->delete();

        return \response()->json([
            'message' => 'Material Deleted Successful',
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
