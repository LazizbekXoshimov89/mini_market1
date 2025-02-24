<?php

namespace App\Http\Controllers;

use App\Models\Repository_action;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return Repository_action::selectRaw('product_variant_id, SUM(count) as total_count')
        // ->groupBy('product_variant_id')
        // ->get();

         $remain = Repository_action::selectRaw('repository_actions.product_variant_id, product_variants.title, SUM(repository_actions.count) as total_count,selling_prices.price as selling_price')
            ->join('product_variants', 'repository_actions.product_variant_id', '=', 'product_variants.id')
            ->join('selling_prices', 'repository_actions.product_variant_id', '=', 'selling_prices.product_variant_id' )
            //->join('selling_prices', 'active', '=', 'true' )
            ->groupBy('repository_actions.product_variant_id', 'product_variants.title','selling_prices.price',)
            ->get();
            return $remain;

          }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

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
