<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\InvoiceInterface;
use App\Http\Requests\InvoiceStorerequest;
use App\Http\Requests\OutputInvoiceRequest;
use App\Models\Invoice;


class InvoiceRepository implements InvoiceInterface
{
    public function __construct(
        private Invoice $invoice,

    ) {}

    public function store(InvoiceStorerequest $request)
    {
        {
            $invoice = $this->invoice::create([
              "partner_id" => $request->partner_id,
              "date_time" => $request->date_time,
              "total_value" => $request->total_value,
              "comment" => $request->comment,
              "type" => $request->type,
              "status" => $request->status ?? "continue",
            ]);
            return response()->json(["message" => "Invois yaratildi", "invoice" => $invoice], 201);
        }
    }

    public function outputInvoice(OutputInvoiceRequest $request)
    {
        {
            $invoice = $this->invoice::create([
              "date_time" => $request->date_time,
              "total_value" => $request->total_value,
              "comment" => $request->comment,
              "type" => $request->type,
              "status" => $request->status ?? "continue",
            ]);
            return response()->json(["message" => "Invois yaratildi", "invoice" => $invoice], 201);
        }
    }
}
