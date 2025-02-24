<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
    public function store(CategoryStoreRequest $request)
    {
        $category = category::create([
         "title" => $request->title,
         "active" => $request->active,
          "market_id" => $request->market_id,
        ]);

        return response()->json(["message" => "Kateqoriya yaratildi", "category" => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $category = category::get();
        return response()->json(["category" => $category], 200);
    }



     public function changeActive($id)
    {
    $category = category::find($id);

    if (!$category) {
        return response()->json(["message" => "bu id li categoriya mavjud emas"], 404);
    }
    $category->active = !$category->active;
    $category->save();
    return response()->json(["message" => "amaliyot bajarildi"], 200);
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
