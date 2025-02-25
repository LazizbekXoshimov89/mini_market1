<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\SellingPriceInterface;
use App\Http\Requests\SellingPriceCreateRequest;
use App\Models\SellingPrice;

class SellingPriceRepository implements SellingPriceInterface
{
    public function __construct(
        private SellingPrice $sellingPrice,
    ) {}

    public function store(SellingPriceCreateRequest $request)
    {
        $this->sellingPrice::where('product_variant_id', $request->product_variant_id)
        ->where('active', true)
        ->update([
            "active" => false,
            "end_date" => date("Y-m-d H:i:s")
        ]);
    $selling_price = $this->sellingPrice::create([
        "product_variant_id" => $request->product_variant_id,
        "price" => $request->price,
        "start_date" => $request->start_date,
        "active" => $request->active,
        "market_id" => $request->market_id,
    ]);
    return response()->json(["message" => "sotish narxi yaratildi", "selling_price" => $selling_price], 201);
    }
}
