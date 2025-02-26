<?php

namespace App\Http\Interfaces;

use App\Http\Requests\PartnerStoreRequest;




interface PartnerInterface
{
    public function store(PartnerStoreRequest $request);
    public function show();
    public function changeActive($id);

}
