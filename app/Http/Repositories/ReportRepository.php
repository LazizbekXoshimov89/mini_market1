<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\ReportInterface;
use App\Models\Repository_action;


class ReportRepository implements ReportInterface
{
    public function __construct(
        private Repository_action $repository_action,

    ) {}

    public function index(){

$remain = $this->repository_action::selectRaw('repository_actions.product_variant_id, product_variants.title, SUM(repository_actions.count) as total_count,selling_prices.price as selling_price')
            ->join('product_variants', 'repository_actions.product_variant_id', '=', 'product_variants.id')
            ->join('selling_prices', 'repository_actions.product_variant_id', '=', 'selling_prices.product_variant_id' )
            ->groupBy('repository_actions.product_variant_id', 'product_variants.title','selling_prices.price',)
            ->get();
            return $remain;
    }
}
