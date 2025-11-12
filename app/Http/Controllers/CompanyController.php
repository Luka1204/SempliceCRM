<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService
    ) {
        $this->authorizeResource(Company::class, 'company');
    }

    public function index(Request $request): View
    {
        $companies = $this->companyService->getUserCompanies($request->user());
        
        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->companyService->createCompany($request->validated(), $request->user());

        return redirect()->route('companies.index')
            ->with('success', 'Empresa creada exitosamente.');
    }

    public function show(Company $company): View
    {
        $company->load(['contacts', 'deals']);

        return view('companies.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->companyService->updateCompany($company, $request->validated());

        return redirect()->route('companies.index')
            ->with('success', 'Empresa actualizada exitosamente.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        try {
            $this->companyService->deleteCompany($company);
            
            return redirect()->route('companies.index')
                ->with('success', 'Empresa eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function search(Request $request): View
    {
        $companies = $this->companyService->searchCompanies(
            $request->user(), 
            $request->get('search', '')
        );

        return view('companies.index', compact('companies'));
    }
}