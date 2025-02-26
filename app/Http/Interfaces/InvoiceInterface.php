<?php

namespace App\Http\Interfaces;

use App\Http\Requests\InvoiceStorerequest;
use App\Http\Requests\OutputInvoiceRequest;

interface InvoiceInterface
{
    public function store(InvoiceStorerequest $request);
    public function outputInvoice(OutputInvoiceRequest $request);


}
