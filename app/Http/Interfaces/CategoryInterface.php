<?php

namespace App\Http\Interfaces;

use App\Http\Requests\CategoryStoreRequest;


interface CategoryInterface
{
    public function store(CategoryStoreRequest $request);
    public function show();
    public function changeActive($id);


}
