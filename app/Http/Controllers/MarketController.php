<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\MarketInterface;
use App\Http\Requests\MarketStoreRequest;



class MarketController extends Controller
{
    public function __construct(
        private MarketInterface $marketInterface
    )
    {}

    public function store(MarketStoreRequest $request)
    {
        return $this->marketInterface->store($request);
    }

    public function show()
    {
        return $this->marketInterface->show();
    }



     public function changeActive($id)
    {
       return $this->marketInterface->changeActive($id);
    }


}
