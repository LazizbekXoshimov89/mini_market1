<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductVariantsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RepositoryActionController;
use App\Http\Controllers\SellingPriceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("user/register", [UserController::class, "register"]);
Route::post("user/login", [UserController::class, "login"]);
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::put("user/update/{id}", [UserController::class, "update"]);
    Route::post("user/create", [UserController::class, "store"]);
    Route::get("user/show/{id}", [UserController::class, "show"]);
    Route::post("market/create", [MarketController::class, "store"]);
    Route::get("market/show", [MarketController::class, "show"]);
    Route::put("market/changeActive/{id}", [MarketController::class, "changeActive"]);
    Route::post("category/create", [CategoryController::class, "store"]);
    Route::get("category/show", [CategoryController::class, "show"]);
    Route::put("category/changeActive/{id}", [CategoryController::class, "changeActive"]);
    Route::post("product/create", [ProductVariantsController::class, "store"]);
    Route::get("product/show", [ProductVariantsController::class, "show"]);
    Route::put("product/changeActive/{id}", [ProductVariantsController::class, "changeActive"]);
    Route::post("partner/create", [PartnerController::class, "store"]);
    Route::get("partner/show", [PartnerController::class, "show"]);
    Route::put("partner/changeActive/{id}", [PartnerController::class, "changeActive"]);
    Route::post("invoice/create", [InvoicesController::class, "store"]);
    Route::post("inputProduct/create", [RepositoryActionController::class, "inputProduct"]);
    Route::post("sellingPrice/create", [SellingPriceController::class, "store"]);
    Route::get("qoldiq/show", [ReportController::class,"index"]);
    Route::post("outputinvoice/create", [InvoicesController::class,"outputInvoice"]);
    Route::post("outputProduct/create", [RepositoryActionController::class, "outputProduct"]);
    Route::post("outputProduct/test", [RepositoryActionController::class, "sellProducts"]);

});
