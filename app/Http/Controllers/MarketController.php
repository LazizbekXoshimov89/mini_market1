<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketStoreRequest;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
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
    public function store(MarketStoreRequest $request)
    {
        $market = Market::create([
          "title" => $request->title,
          "adress" => $request->adress,
          "active" => $request->active,
          "start_date" => date('Y-m-d'),
          "user_id" => auth()->id(),
        ]);
        return response()->json(["message" => "Market yaratildi", "market" => $market], 201);
    }




    /**
     * Display the specified resource.
     */
    public function show()
    {
        $markets =Market::
        where('user_id', Auth::user()->id)
     ->get();
        return response()->json(["markets" => $markets], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


     public function changeActive($id)
    {
    $market = Market::find($id);

    if (!$market) {
        return response()->json(["message" => "bu id li market mavjud emas"], 404);
    }
    $market->active = !$market->active;
    $market->save();
    return response()->json(["message" => "amaliyot bajarildi"], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
