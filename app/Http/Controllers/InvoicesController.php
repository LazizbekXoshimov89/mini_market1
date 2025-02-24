<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStorerequest;
use App\Http\Requests\OutputInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceStorerequest $request)
    {
        {
            $invoice = Invoice::create([
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

    /**
     * Display the specified resource.
     */
    public function outputInvoice(OutputInvoiceRequest $request)
    {
        {
            $invoice = Invoice::create([
              "date_time" => $request->date_time,
              "total_value" => $request->total_value,
              "comment" => $request->comment,
              "type" => $request->type,
              "status" => $request->status ?? "continue",
            ]);
            return response()->json(["message" => "Invois yaratildi", "invoice" => $invoice], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
