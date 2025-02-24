<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutputInvoiceRequest;
use App\Http\Requests\RepositoryActionRequest;
use App\Models\Invoice;
use App\Models\Output_product_detail;
use App\Models\Repository_action;
use App\Models\SellingPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepositoryActionController extends Controller
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
    public function inputProduct(RepositoryActionRequest $request)
    {
        DB::beginTransaction();
        try {
            $products = $request->product;
            $invoice = Invoice::find($request->invoice_id);
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    "product_variant_id" => $product['id'],
                    "count" => $product['count'],
                    "price" => $product['price'],
                    "invoice_id" => $request->invoice_id,
                ];
            }

            Repository_action::upsert($data, ['invoice_id', 'product_variant_id'], ['count', 'price']);
            // Repository_action::insert($data);
            $products = Repository_action::where('invoice_id', $request->invoice_id)
                ->get();
            $totalValue = 0;
            foreach ($products as $product) {
                $totalValue += $product['count'] * $product['price'];
            }
            $invoice->update([
                "total_value" => $totalValue
            ]);
            DB::commit();
            return response()->json(["message" => "Repository_action yaratildi"], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }



    public function outputProduct(OutputInvoiceRequest $request)
    {
        DB::beginTransaction();
        try{
        $invoice = Invoice::find($request->invoice_id);
        if ($invoice->status!= "continue"){
            return "faktura tasdiqlangan yoki bekor qilingan!";
        }
        $products = collect($request->products);
        $remains = Repository_action::selectRaw('repository_actions.product_variant_id, SUM(repository_actions.count) as total_count,selling_prices.price as selling_price')
            ->join('selling_prices', 'repository_actions.product_variant_id', '=', 'selling_prices.product_variant_id')
            ->where('selling_prices.active', true)
            ->whereIn('repository_actions.product_variant_id', $products->pluck('product_variant_id'))
            ->groupBy('repository_actions.product_variant_id', 'selling_prices.price')
            ->get();
            $sellProductsDetails = [];
            foreach ($products as $product) {
                $remain = $remains->where('product_variant_id', $product['product_variant_id'])->first();
                if ($remain?->total_count < $product['count']){
                    return "Qoldiq yetarli emas id: {$product['product_variant_id']}";
                }
                $repoAction = Repository_action::create([
                    "product_variant_id" => $product['product_variant_id'],
                    "count" => -1 * $product['count'],
                    "price" => $remain->selling_price,
                    'invoice_id' => $request->invoice_id
                ]);
                $remainForFoyda = Repository_action::where('product_variant_id', $product['product_variant_id'])
                ->where('current_count', '>', 0)
                ->get();
                $sellCount = $product['count'];
                foreach ($remainForFoyda as $currentCount) {
                    if ($currentCount->current_count > $sellCount) {
                        $sellProductsDetails[] = [
                            "repository_action_id" => $repoAction->id,
                            "count" => $sellCount,
                            "selling_price" => $remain->selling_price,
                            'income_price' => $currentCount->price,
                            'difference' => $remain->selling_price - $currentCount->price
                        ];
                        Repository_action::where('id', $currentCount->id)->update([
                            "current_count" => $currentCount->current_count - $sellCount,
                        ]);
                        $sellCount = 0;
                    } else {
                        $sellProductsDetails[] = [
                            "repository_action_id" => $repoAction->id,
                            "count" => $currentCount->current_count,
                            "selling_price" => $remain->selling_price,
                            'income_price' => $currentCount->price,
                            'difference' => $remain->selling_price - $currentCount->price
                        ];

                        Repository_action::where('id', $currentCount->id)->update([
                            "current_count" => 0
                        ]);
                        $sellCount = $sellCount - $currentCount->current_count;
                    }
                    if ($sellCount == 0)
                        break;
                }

                Output_product_detail::insert($sellProductsDetails);
                Invoice::find($request->invoice_id)
                ->update([
                    'status' => 'done'
                ]);
                DB::commit();
                return 'ok';
            }
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
        }
    }



    // public function sellProducts(OutputInvoiceRequest $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //        $invoice = Invoice::find($request->invoice_id);
    //     if ($invoice->status != "continue")
    //         return "faktura yakunlangan";
    //     $products = collect($request->products);
    //     $remains = Repository_action::selectRaw('repository_actions.product_variant_id, SUM(repository_actions.count) as total_count,selling_prices.price as selling_price')
    //         ->join('selling_prices', 'repository_actions.product_variant_id', '=', 'selling_prices.product_variant_id')
    //         ->where('selling_prices.active', true)
    //         ->whereIn('repository_actions.product_variant_id', $products->pluck('product_variant_id'))
    //         ->groupBy('repository_actions.product_variant_id', 'selling_prices.price')
    //         ->get();
    //     $sellProductsDetails = [];
    //     foreach ($products as $product) {
    //         // $remain = Repository_action::selectRaw('repository_actions.product_variant_id, SUM(repository_actions.count) as total_count,selling_prices.price as selling_price')
    //         //     ->join('selling_prices', 'repository_actions.product_variant_id', '=', 'selling_prices.product_variant_id')
    //         //     ->where('selling_prices.active', true)
    //         //     ->where('repository_actions.product_variant_id', $product['product_variant_id'])
    //         //     ->groupBy('repository_actions.product_variant_id', 'selling_prices.price')
    //         //     ->first();
    //         $remain = $remains->where('product_variant_id', $product['product_variant_id'])->first();
    //         if ($remain?->total_count < $product['count'])
    //             return "Qoldiq yetarli emas id: {$product['product_variant_id']}";
    //         $repoAction = Repository_action::create([
    //             "product_variant_id" => $product['product_variant_id'],
    //             "count" => -1 * $product['count'],
    //             "price" => $remain->selling_price,
    //             'invoice_id' => $request->invoice_id
    //         ]);
    //         // $remainForFoyda = $remains->where('product_variant_id', $product['product_variant_id'])
    //         // ->where('current_count', '>', 0)
    //         // ->get();
    //         $remainForFoyda = Repository_action::where('product_variant_id', $product['product_variant_id'])
    //             ->where('current_count', '>', 0)
    //             ->get(); // 2,3
    //         $sellCount = $product['count'];
    //         foreach ($remainForFoyda as $currentCount) {
    //             if ($currentCount->current_count > $sellCount) {
    //                 // sotamiz... va $sellCount = 0, $currentCount = $currentCount - $sellCount
    //                 $sellProductsDetails[] = [
    //                     "repository_action_id" => $repoAction->id,
    //                     "count" => $sellCount,
    //                     "selling_price" => $remain->selling_price,
    //                     'income_price' => $currentCount->price,
    //                     'difference' => $remain->selling_price - $currentCount->price
    //                 ];
    //                 Repository_action::where('id', $currentCount->id)->update([
    //                     "current_count" => $currentCount->current_count - $sellCount,
    //                 ]);
    //                 $sellCount = 0;
    //             } else {
    //                 // sotamiz... va $sellCount = $sellCount - $currentCount, $currentCount = 0
    //                 $sellProductsDetails[] = [
    //                     "repository_action_id" => $repoAction->id,
    //                     "count" => $currentCount->current_count,
    //                     "selling_price" => $remain->selling_price,
    //                     'income_price' => $currentCount->price,
    //                     'difference' => $remain->selling_price - $currentCount->price
    //                 ];

    //                 Repository_action::where('id', $currentCount->id)->update([
    //                     "current_count" => 0
    //                 ]);
    //                 $sellCount = $sellCount - $currentCount->current_count;
    //             }
    //             if ($sellCount == 0)
    //                 break;
    //         }

    //         Output_product_detail::insert($sellProductsDetails);
    //         Invoice::find($request->invoice_id)
    //         ->update([
    //             'status' => 'done'
    //         ]);
    //         DB::commit();
    //         return response()->json(["message" => "sotildi"],  200);
    //     }
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         throw $th;
    //     }








    /**
     * Display the specified resource.
     */


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
