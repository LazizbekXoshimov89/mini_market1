<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\category;



class CategoryRepository implements CategoryInterface
{
    public function __construct(
        private category $category,

    ) {}

    public function store(CategoryStoreRequest $request)
    {
        $category = $this->category::create([
         "title" => $request->title,
         "active" => $request->active,
          "market_id" => $request->market_id,
        ]);

        return response()->json(["message" => "Kateqoriya yaratildi", "category" => $category], 201);
    }

    public function show()
    {
        $category = $this->category::get();
        return response()->json(["category" => $category], 200);
    }

    public function changeActive($id)
    {
    $category = $this->category::find($id);

    if (!$category) {
        return response()->json(["message" => "bu id li categoriya mavjud emas"], 404);
    }
    $category->active = !$category->active;
    $category->save();
    return response()->json(["message" => "amaliyot bajarildi"], 200);
    }

}

