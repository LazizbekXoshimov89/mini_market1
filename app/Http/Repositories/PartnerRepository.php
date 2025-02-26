<?php
namespace App\Http\Repositories;
use App\Http\Interfaces\PartnerInterface;
use App\Http\Requests\PartnerStoreRequest;
use App\Models\Partner;



class PartnerRepository implements PartnerInterface
{
    public function __construct(
        private Partner $partner,
    ) {}

    public function store(PartnerStoreRequest $request)
    {
       $partner =  $this->partner::create([
          "title" => $request->title,
          "phone" => $request->phone,
          "active" => $request->active
        ]);
        return response()->json(["message" => " partner yaratildi", "partner" => $partner], 201);
    }

    public function show()
    {
        $partners= $this->partner::get();
        return response()->json(["partners" => $partners], 200);
    }

    public function changeActive($id)
    {
       $partner = $this->partner::find($id);
       if (!$partner) {
           return response()->json(["message" => "bu id li hamkor mavjud emas"], 404);
       }
       $partner->active = !$partner->active;
       $partner->save();
       return response()->json(["message" => "amaliyot bajarildi"], 200);
    }

}
