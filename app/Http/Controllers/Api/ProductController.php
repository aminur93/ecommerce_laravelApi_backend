<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ProductImage;
use App\Products;
use App\SubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::getProducts();

        return response()->json([
            'products' => $products,
            'status_code' => 200
        ],200);
    }

    public function getSubCategories($category_id)
    {
        $sub_category = SubCategory::getSubCat($category_id);

        return \response()->json([
            'sub_category' => $sub_category,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create product
                $product = new Products();

                $product->category_id = $request->category_id;
                $product->sub_cat_id = $request->sub_cat_id;
                $product->tag_id = $request->tag_id;
                $product->brand_id = $request->brand_id;
                $product->author_id = $request->author_id;
                $product->name = $request->name;
                $product->title = $request->title;
                $product->model_number = $request->model_number;
                $product->code = $request->code;
                $product->slug = Str::slug($request->name);
                $product->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');
                    if($image_tmp->isValid()){
                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extension;

                        $original_image_path = public_path().'/assets/admin/uploads/original_image/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1920,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(1000,529)->save($medium_image_path);
                        Image::make($image_tmp)->resize(500,529)->save($small_image_path);

                        $product->image = $filename;
                    }
                }


                $product->material_id = $request->material_id;
                $product->origin_id = $request->origin_id;
                $product->price = $request->price;
                $product->weight = $request->weight;
                $product->date = $request->date;

                if ($request->feature == true)
                {
                    $product->feature = 1;
                }else{
                    $product->feature = 0;
                }

                if ($request->approve == true)
                {
                    $product->approve = 1;
                }else{
                    $product->approve = 0;
                }

                if ($request->publish == true)
                {
                    $product->publish = 1;
                }else{
                    $product->publish = 0;
                }

               $product->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Product Added Successful',
                    'status_code' => 200
                ], Response::HTTP_OK);


            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id)
    {
        $product = Products::getEditProduct($id);

        return \response()->json([
            'product' => $product,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function update(Request $request,$id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create product
                $product = Products::findOrFail($id);

                $product->category_id = $request->category_id;
                $product->sub_cat_id = $request->sub_cat_id;
                $product->tag_id = $request->tag_id;
                $product->brand_id = $request->brand_id;
                $product->author_id = $request->author_id;
                $product->name = $request->name;
                $product->title = $request->title;
                $product->model_number = $request->model_number;
                $product->code = $request->code;
                $product->slug = Str::slug($request->name);
                $product->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');
                    if($image_tmp->isValid()){
                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extension;

                        $original_image_path = public_path().'/assets/admin/uploads/original_image/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1920,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(1000,529)->save($medium_image_path);
                        Image::make($image_tmp)->resize(500,529)->save($small_image_path);
                    }
                }else{
                    $filename = $request->current_image;
                }

                $product->image = $filename;

                $product->material_id = $request->material_id;
                $product->origin_id = $request->origin_id;
                $product->price = $request->price;
                $product->weight = $request->weight;
                $product->date = $request->date;

                if ($request->feature){
                    $product->feature = $request->feature == "false" ? 0 : 1;
                }

                if ($request->approve){
                    $product->approve = $request->approve == "false" ? 0 : 1;
                }

                if ($request->publish){
                    $product->publish = $request->publish == "false" ? 0 : 1;
                }


                $product->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Product Updated Successful',
                    'status_code' => 200
                ], Response::HTTP_OK);


            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        //
    }

    public function deleteProductImage($id)
    {
        $product = Products::findOrFail($id);

        if ($product->image)
        {
            $original_path = public_path().'/assets/admin/uploads/original_image/'.$product->image;
            $large_path = public_path().'/assets/admin/uploads/large/'.$product->image;
            $medium_path = public_path().'/assets/admin/uploads/medium/'.$product->image;
            $small_path = public_path().'/assets/admin/uploads/small/'.$product->image;

            unlink($original_path);
            unlink($large_path);
            unlink($medium_path);
            unlink($small_path);
        }

        $product->update(['image' => null]);

        return \response()->json([
            'message' => 'Product Image Deleted Successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }

    public function feature($product_id)
    {
        $product = Products::findOrFail($product_id);

        if ($product->feature == 1){

            Products::where('id',$product_id)->update(['feature' => 0]);

            return \response()->json([
                'message' => 'Product feature remove',
                'status_code' => 200
            ], Response::HTTP_OK);
        }

        if ($product->feature == 0){

            Products::where('id',$product_id)->update(['feature' => 1]);

            return \response()->json([
                'message' => 'Product feature is successful',
                'status_code' => 200
            ], Response::HTTP_OK);
        }
    }

    public function approve($product_id)
    {
        $product = Products::findOrFail($product_id);

        if ($product->approve == 1)
        {
            Products::where('id',$product_id)->update(['approve' => 0]);

            return \response()->json([
                'message' => 'Product approve remove',
                'status_code' => 200
            ], Response::HTTP_OK);
        }

        if ($product->approve == 0)
        {
            Products::where('id', $product_id)->update(['approve' => 1]);

            return \response()->json([
                'message' => 'Product approve is successful',
                'status_code' => 200
            ], Response::HTTP_OK);
        }
    }

    public function publish($product_id)
    {
        $product = Products::findOrFail($product_id);

        if ($product->publish == 1)
        {
            Products::where('id', $product_id)->update(['publish' => 0]);

            return \response()->json([
                'message' => 'Product publish remove',
                'status_code' => 200
            ], Response::HTTP_OK);
        }

        if ($product->publish == 0)
        {
            Products::where('id', $product_id)->update(['publish' => 1]);

            return \response()->json([
                'message' => 'Product publish is successful',
                'status_code' => 200
            ], Response::HTTP_OK);
        }
    }

    public function getImage($product_id)
    {
        $product_image = ProductImage::getProductImage($product_id);

        return \response()->json([
            'product_image' => $product_image,
            'status_code' => 200
        ],Response::HTTP_OK);
    }

    public function imageStore(Request $request)
    {
        //dd($request->image);

        if ($request->isMethod('post')) {

            //create product Image

            if ($request->hasFile('image'))
            {
                foreach ($request->file('image') as $value)
                {
                    $image_tmp = $value;
                    $name=$value->getClientOriginalName();
                    $filename = $name;

                    $original_image_path = public_path().'/assets/admin/uploads/original_image/'.$filename;
                    $large_path = public_path().'/assets/admin/uploads/large/'.$filename;
                    $medium_image_path = public_path().'/assets/admin/uploads/medium/'.$filename;
                    $small_image_path = public_path().'/assets/admin/uploads/small/'.$filename;

                    //Resize Image
                    Image::make($image_tmp)->save($original_image_path);
                    Image::make($image_tmp)->resize(1920,680)->save($large_path);
                    Image::make($image_tmp)->resize(1000,529)->save($medium_image_path);
                    Image::make($image_tmp)->resize(500,529)->save($small_image_path);

                    //$value->move(public_path().'/assets/admin/uploads/product_images/original/'.$name);

                    DB::table('product_images')->insert([
                        'product_id' => $request->product_id,
                        'image' => $filename
                    ]);
                }
            }

            return \response()->json([
                'message' => 'Product Image Added Successful',
                'status_code' => 200
            ], Response::HTTP_OK);

        }
    }

    public function imageEdit($image_id)
    {
        $product_image = ProductImage::findOrFail($image_id);

        return \response()->json([
            'product_image' => $product_image,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    public function imageUpdate(Request $request, $image_id)
    {
        if ($request->isMethod('post'))
        {
            //update product Images

            try{

                //update product image

                $product_image = ProductImage::findOrFail($image_id);

                $product_image->product_id = $request->product_id;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');
                    if($image_tmp->isValid()){
                        $extension = $image_tmp->getClientOriginalName();
                        $filename = $extension;

                        $original_image_path = public_path().'/assets/admin/uploads/original_image/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1920,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(1000,529)->save($medium_image_path);
                        Image::make($image_tmp)->resize(500,529)->save($small_image_path);
                    }
                }else{
                    $filename = $request->current_image;
                }

                $product_image->image = $filename;

                $product_image->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Product Image Updated Successful',
                    'status_code' => 200
                ],Response::HTTP_OK);


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

    public function imageDestroy($image_id)
    {
        $product_image = ProductImage::findOrFail($image_id);

        if ($product_image->image != null)
        {
            $original_path = public_path().'/assets/admin/uploads/original_image/'.$product_image->image;
            $large_path = public_path().'/assets/admin/uploads/large/'.$product_image->image;
            $medium_path = public_path().'/assets/admin/uploads/medium/'.$product_image->image;
            $small_path = public_path().'/assets/admin/uploads/small/'.$product_image->image;

            unlink($original_path);
            unlink($large_path);
            unlink($medium_path);
            unlink($small_path);
        }

        $product_image->delete();

        return \response()->json([
            'message' => 'Product Image Destroy Successful',
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
