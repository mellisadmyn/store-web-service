<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $product                = new Product();
            $product->name          = $request->name;
            $product->price         = $request->price;
            $product->description   = $request->description;
            $product->stock         = $request->stock;
            if ($request->has('image')){
                $file       = $request->file('image');
                $fileName   = time().'.'.$file->getClientOriginalExtension();
                $filePath   = public_path('images');
                $file->move($filePath, $fileName);
                $product->image_path = $filePath.$fileName;

            }
            $product->save();
            return response()->json([
                'product'   => $product,
                'success'   => true,
                'notif'     =>'product has been created',
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 422);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try{
            $product = Product::find($id);
            return response()->json($product);
            
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 422);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        try{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->stock = $request->stock;
            if ($request->has('image')){
                $file       = $request->file('image');
                $fileName   = time().'.'.$file->getClientOriginalExtension();
                $filePath   = public_path('images');
                $file->move($filePath, $fileName);
                $product->image_path = $filePath.$fileName;
            }
            $product->save();
            return response()->json([
                'product' =>$product,
                'success' => true,
                'notif'=>'product has been updated',
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 422);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try{
            $product = Product::find($id);
            $filePath = $product->image_path;
            File::delete($filePath);
            $product->delete();
            return response()->json([
                'success' => true,
                'notif'=>'product has been deleted',
            ],200);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 422);
        }
    }
}