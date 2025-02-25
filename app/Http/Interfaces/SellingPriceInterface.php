<?php

namespace App\Http\Interfaces;

use App\Http\Requests\SellingPriceCreateRequest;

interface SellingPriceInterface
{
    public function store(SellingPriceCreateRequest $request);
}


