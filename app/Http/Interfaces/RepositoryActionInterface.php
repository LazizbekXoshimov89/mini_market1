<?php

namespace App\Http\Interfaces;

use App\Http\Requests\OutputInvoiceRequest;
use App\Http\Requests\RepositoryActionRequest;


interface RepositoryActionInterface
{
    public function inputProduct(RepositoryActionRequest $request);
    public function outputProduct(OutputInvoiceRequest $request);
}
