<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\RepositoryActionInterface;
use App\Http\Requests\OutputInvoiceRequest;
use App\Http\Requests\RepositoryActionRequest;
use App\Models\Invoice;
use App\Models\Output_product_detail;
use App\Models\Repository_action;
use Illuminate\Support\Facades\DB;

class RepositoryActionRepository implements RepositoryActionInterface
{
    public function __construct(
        private DB $db,
        private Invoice $invoice,
        private Repository_action $repository_action,
        private Output_product_detail $output_product_detail
    ) {}

    public function inputProduct(RepositoryActionRequest $request)
    {
        $this->db::beginTransaction();
        try {
            $products = $request->product;
            $invoice = $this->invoice::find($request->invoice_id);
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    "product_variant_id" => $product['id'],
                    "count" => $product['count'],
                    "price" => $product['price'],
                    "invoice_id" => $request->invoice_id,
                ];
            }

            $this->repository_action::upsert($data, ['invoice_id', 'product_variant_id'], ['count', 'price']);
            // Repository_action::insert($data);
            $products = $this->repository_action::where('invoice_id', $request->invoice_id)
                ->get();
            $totalValue = 0;
            foreach ($products as $product) {
                $totalValue += $product['count'] * $product['price'];
            }
            $invoice->update([
                "total_value" => $totalValue
            ]);
            $this->db::commit();
            return response()->json(["message" => "Repository_action yaratildi"], 201);
        } catch (\Throwable $th) {
            $this->db::rollBack();
            throw $th;
        }
    }

    public function outputProduct(OutputInvoiceRequest $request)
    {
        $this->db::beginTransaction();
        try{
        $invoice = $this->invoice::find($request->invoice_id);
        if ($invoice->status!= "continue"){
            return "faktura tasdiqlangan yoki bekor qilingan!";
        }
        $products = collect($request->products);
        $remains = $this->repository_action::selectRaw('repository_actions.product_variant_id, SUM(repository_actions.count) as total_count,selling_prices.price as selling_price')
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
                $repoAction = $this->repository_action::create([
                    "product_variant_id" => $product['product_variant_id'],
                    "count" => -1 * $product['count'],
                    "price" => $remain->selling_price,
                    'invoice_id' => $request->invoice_id
                ]);
                $remainForFoyda = $this->repository_action::where('product_variant_id', $product['product_variant_id'])
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
                        $this->repository_action::where('id', $currentCount->id)->update([
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

                        $this->repository_action::where('id', $currentCount->id)->update([
                            "current_count" => 0
                        ]);
                        $sellCount = $sellCount - $currentCount->current_count;
                    }
                    if ($sellCount == 0)
                        break;
                }

                $this->output_product_detail::insert($sellProductsDetails);
                $this->invoice::find($request->invoice_id)
                ->update([
                    'status' => 'done'
                ]);
                $this->db::commit();
                return 'ok';
            }
            } catch (\Throwable $th) {
                $this->db::rollBack();
                throw $th;
        }
    }
}
