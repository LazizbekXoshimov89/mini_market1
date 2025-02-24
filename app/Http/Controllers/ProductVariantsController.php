<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product_variant;
use Illuminate\Http\Request;

class ProductVariantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
       $product_variant = Product_variant::create([
            "title" => $request->title,
            "category_id"=>$request->category_id,
            "active" => $request->active
        ]);
        return response()->json(["message" => " product_variant yaratildi", "variant" => $product_variant], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
      $variants = Product_variant::get();
        return response()->json(["variants" => $variants], 200);
    }

    /**
     * Update the specified resource in storage.
     */

     public function changeActive($id)
     {
        $variant = Product_variant::find($id);
        if (!$variant) {
            return response()->json(["message" => "bu id li variant mavjud emas"], 404);
        }
        $variant->active = !$variant->active;
        $variant->save();
        return response()->json(["message" => "amaliyot bajarildi"], 200);
     }




    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
