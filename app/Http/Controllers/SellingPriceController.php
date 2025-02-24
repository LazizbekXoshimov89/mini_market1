<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellingPriceCreateRequest;
use App\Models\SellingPrice;
use Illuminate\Http\Request;

class SellingPriceController extends Controller
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
    public function store(SellingPriceCreateRequest $request)
    {
        SellingPrice::where('product_variant_id', $request->product_variant_id)
            ->where('active', true)
            ->update([
                "active" => false,
                "end_date" => date("Y-m-d H:i:s")
            ]);
        $selling_price = SellingPrice::create([
            "product_variant_id" => $request->product_variant_id,
            "price" => $request->price,
            "start_date" => $request->start_date,
            "active" => $request->active,
            "market_id" => $request->market_id,
        ]);
        return response()->json(["message" => "sotish narxi yaratildi", "selling_price" => $selling_price], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
