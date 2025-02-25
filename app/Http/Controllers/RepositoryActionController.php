<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\RepositoryActionInterface;
use App\Http\Requests\OutputInvoiceRequest;
use App\Http\Requests\RepositoryActionRequest;
use App\Models\Invoice;
use App\Models\Output_product_detail;
use App\Models\Repository_action;
use App\Models\SellingPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepositoryActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private RepositoryActionInterface $repositoryActionInterface
    )
    {}


    public function inputProduct(RepositoryActionRequest $request)
    {
        return $this->repositoryActionInterface->inputProduct($request);

    }



    public function outputProduct(OutputInvoiceRequest $request)
    {
        return $this->repositoryActionInterface->outputProduct($request);
    }

}
