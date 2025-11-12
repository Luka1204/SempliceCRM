<?php

namespace App\Http\Controllers;

use App\Http\Requests\Deals\StoreDealRequest;
use App\Http\Requests\Deals\UpdateDealRequest;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Services\DealService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function __construct(
        private DealService $dealService
    ) {
        $this->authorizeResource(Deal::class, 'deal');
    }

    public function index(Request $request): View
    {
        $deals = $this->dealService->getUserDeals($request->user());
        $stats = $this->dealService->getDealStats($request->user());

        return view('deals.index', compact('deals', 'stats'));
    }

    public function create(): View
    {
        $companies = Company::byUser(auth()->user())->get();
        $contacts = Contact::byUser(auth()->user())->get();
        $stages = Deal::STAGES;

        return view('deals.create', compact('companies', 'contacts', 'stages'));
    }

    public function store(StoreDealRequest $request): RedirectResponse
    {
        $this->dealService->createDeal($request->validated(), $request->user());

        return redirect()->route('deals.index')
            ->with('success', 'Deal created successfully.');
    }

    public function show(Deal $deal): View
    {
        $deal->load(['company', 'contact']);

        return view('deals.show', compact('deal'));
    }

    public function edit(Deal $deal): View
    {
        $companies = Company::byUser(auth()->user())->get();
        $contacts = Contact::byUser(auth()->user())->get();
        $stages = Deal::STAGES;

        return view('deals.edit', compact('deal', 'companies', 'contacts', 'stages'));
    }

    public function update(UpdateDealRequest $request, Deal $deal): RedirectResponse
    {
        $this->dealService->updateDeal($deal, $request->validated());

        return redirect()->route('deals.index')
            ->with('success', 'Deal updated successfully.');
    }

    public function destroy(Deal $deal): RedirectResponse
    {
        $this->dealService->deleteDeal($deal);

        return redirect()->route('deals.index')
            ->with('success', 'Deal deleted successfully.');
    }

    public function byStage(Request $request, string $stage): View
    {
        $deals = $this->dealService->getDealsByStage($request->user(), $stage);
        $stats = $this->dealService->getDealStats($request->user());

        return view('deals.index', compact('deals', 'stats', 'stage'));
    }

    public function upcoming(Request $request): View
    {
        $deals = $this->dealService->getUpcomingDeals($request->user());
        $stats = $this->dealService->getDealStats($request->user());

        return view('deals.index', compact('deals', 'stats'));
    }

    public function closeWon(Deal $deal): RedirectResponse
    {
        $this->authorize('update', $deal);
        
        $this->dealService->closeDealAsWon($deal);

        return redirect()->back()
            ->with('success', 'Deal marked as won successfully.');
    }

    public function closeLost(Deal $deal): RedirectResponse
    {
        $this->authorize('update', $deal);
        
        $this->dealService->closeDealAsLost($deal);

        return redirect()->back()
            ->with('success', 'Deal marked as lost successfully.');
    }
}