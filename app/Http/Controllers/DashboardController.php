<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        
        $stats = $this->dashboardService->getUserStats($user);
        $recentCompanies = $this->dashboardService->getRecentCompanies($user);
        $recentContacts = $this->dashboardService->getRecentContacts($user);
        $companiesByCreation = $this->dashboardService->getCompaniesByCreationDate($user);

        return view('dashboard', compact('stats', 'recentCompanies', 'recentContacts', 'companiesByCreation'));
    }
}