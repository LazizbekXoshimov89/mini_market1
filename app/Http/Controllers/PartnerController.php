<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\PartnerInterface;
use App\Http\Requests\PartnerStoreRequest;


class PartnerController extends Controller
{


    public function __construct(
        private PartnerInterface $partnerInterface
    )
    {}



    public function store(PartnerStoreRequest $request)
    {
      return $this->partnerInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return $this->partnerInterface->show();
    }



     public function changeActive($id)
     {
        return $this->partnerInterface->changeActive($id);

     }


}
