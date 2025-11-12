<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private CompanyRepository $companyRepository)
    {
    }

    public function index(Request $request): View
    {
        dd($this->companyRepository->getAllForUser($request->user()));
        die();
        $totalCompanies = count($this->companyRepository->getAllForUser($request->user()));
        dd($totalCompanies);
        return view('dashboard', [
            'totalCompanies' => $totalCompanies,
            // Agregar más datos luego
        ]);
    }
}