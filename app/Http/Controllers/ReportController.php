<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ReportInterface;


class ReportController extends Controller
{
    public function __construct(
        private ReportInterface $reportInterface
    )
    {}
    public function index()
    {
        return $this->reportInterface->index();

    }
}

