<?php
namespace App\Http\Repositories;
use App\Http\Interfaces\MarketInterface;
use App\Http\Requests\MarketStoreRequest;
use App\Models\Market;
use Illuminate\Support\Facades\Auth;

class MarketRepository implements MarketInterface
{
    public function __construct(
        private Market $market,
        private Auth $auth,
    ) {}

    public function store(MarketStoreRequest $request)
    {
        $market = $this->market::create([
          "title" => $request->title,
          "adress" => $request->adress,
          "active" => $request->active,
          "start_date" => date('Y-m-d'),
          "user_id" => auth()->id(),
        ]);
        return response()->json(["message" => "Market yaratildi", "market" => $market], 201);
    }


    public function show()
    {
        $markets =$this->market::
        where('user_id', $this->auth::user()->id)
     ->get();
        return response()->json(["markets" => $markets], 200);
    }

    public function changeActive($id)
    {
    $market = $this->market::find($id);

    if (!$market) {
        return response()->json(["message" => "bu id li market mavjud emas"], 404);
    }
    $market->active = !$market->active;
    $market->save();
    return response()->json(["message" => "amaliyot bajarildi"], 200);
    }


}
