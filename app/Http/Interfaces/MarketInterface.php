<?php

namespace App\Http\Interfaces;

use App\Http\Requests\MarketStoreRequest;





interface MarketInterface
{
    public function store(MarketStoreRequest $request);
    public function show();
    public function changeActive($id);

}
