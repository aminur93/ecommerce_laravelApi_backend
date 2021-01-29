<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();

        return response()->json([
            'tags' => $tags,
            'status_code' => 200
        ],200);
    }

    public function store(TagRequest $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                //create tag

                $tag = new Tag();

                $tag->tag_name = $request->tag_name;
                $tag->tag_slug = Str::slug($request->tag_name);

                $tag->save();

                DB::commit();

                return response()->json([
                    'message' => 'Tag Added Successfully',
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
        $tag = Tag::findOrFail($id);

        return response()->json([
            'tag' => $tag,
            'status_code' => 200
        ],200);
    }

    public function update(TagRequest $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update tag

                $tag = Tag::findOrFail($id);

                $tag->tag_name = $request->tag_name;
                $tag->tag_slug = Str::slug($request->tag_name);

                $tag->save();

                DB::commit();

                return response()->json([
                    'message' => 'Tag Updated Successfully',
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
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return response()->json([
            'message' => 'Tag Deleted Successfully',
            'status_code' => 200
        ],200);
    }
}
