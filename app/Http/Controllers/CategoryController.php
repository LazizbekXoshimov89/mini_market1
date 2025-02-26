<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{


    public function __construct(
        private CategoryInterface $categoryInterface
    )
    {}



    public function store(CategoryStoreRequest $request)
    {
      return $this->categoryInterface->store($request);

    }

    public function show()
    {
       return $this->categoryInterface->show();
    }



     public function changeActive($id)
    {
      return $this->categoryInterface->changeActive($id);

    }


}
