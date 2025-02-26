<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductVariantsInterface;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Invoice;
use App\Models\Output_product_detail;
use App\Models\Product_variant;
use App\Models\Repository_action;
use Illuminate\Support\Facades\DB;

class ProductVariantsRepository implements ProductVariantsInterface
{
    public function __construct(
        private Product_variant $product_variant,
    ) {}

    public function store(ProductStoreRequest $request)
    {
       $product_variant = $this->product_variant::create([
            "title" => $request->title,
            "category_id"=>$request->category_id,
            "active" => $request->active
        ]);
        return response()->json(["message" => " product_variant yaratildi", "variant" => $product_variant], 201);
    }

    public function show()
    {
      $variants = $this->product_variant::get();
        return response()->json(["variants" => $variants], 200);
    }

    public function changeActive($id)
    {
       $variant = $this->product_variant::find($id);
       if (!$variant) {
           return response()->json(["message" => "bu id li variant mavjud emas"], 404);
       }
       $variant->active = !$variant->active;
       $variant->save();
       return response()->json(["message" => "amaliyot bajarildi"], 200);
    }
}
