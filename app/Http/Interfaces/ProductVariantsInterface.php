<?php

namespace App\Http\Interfaces;

use App\Http\Requests\ProductStoreRequest;



interface ProductVariantsInterface
{
    public function store(ProductStoreRequest $request);
    public function show();
    public function changeActive($id);

}
