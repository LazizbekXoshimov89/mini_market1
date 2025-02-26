<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ProductVariantsInterface;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product_variant;

class ProductVariantsController extends Controller
{
    public function __construct(
        private ProductVariantsInterface $productVariantsInterface
    )
    {}
    public function store(ProductStoreRequest $request)
    {
        return $this->productVariantsInterface->store($request);

    }

    public function show()
    {
      return $this->productVariantsInterface->show();

    }


     public function changeActive($id)
     {
        return $this->productVariantsInterface->changeActive($id);

     }

}


