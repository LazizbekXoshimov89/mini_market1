<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerStoreRequest;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
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
    public function store(PartnerStoreRequest $request)
    {
       $partner =  Partner::create([
          "title" => $request->title,
          "phone" => $request->phone,
          "active" => $request->active
        ]);
        return response()->json(["message" => " partner yaratildi", "partner" => $partner], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $partners= Partner::get();
        return response()->json(["partners" => $partners], 200);
    }

    /**
     * Update the specified resource in storage.
     */



     public function changeActive($id)
     {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(["message" => "bu id li hamkor mavjud emas"], 404);
        }
        $partner->active = !$partner->active;
        $partner->save();
        return response()->json(["message" => "amaliyot bajarildi"], 200);
     }

    
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
