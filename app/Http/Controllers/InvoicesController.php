<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\InvoiceInterface;
use App\Http\Requests\InvoiceStorerequest;
use App\Http\Requests\OutputInvoiceRequest;


class InvoicesController extends Controller
{
    public function __construct(
        private InvoiceInterface $invoiceInterface
    )
    {}


    public function store(InvoiceStorerequest $request)
    {
        return $this->invoiceInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function outputInvoice(OutputInvoiceRequest $request)
    {
        return $this->invoiceInterface->outputInvoice($request);
    }



}
