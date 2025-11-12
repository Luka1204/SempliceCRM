<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activities\StoreActivityRequest;
use App\Http\Requests\Activities\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Company;
use App\Models\Contact;
use App\Services\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __construct(
        private ActivityService $activityService
    ) {
        $this->authorizeResource(Activity::class, 'activity');
    }

    public function index(Request $request): View
    {
        $activities = $this->activityService->getUserActivities($request->user());
        $upcomingActivities = $this->activityService->getUpcomingActivities($request->user());

        return view('activities.index', compact('activities', 'upcomingActivities'));
    }

    public function create(Request $request): View
    {
        $companies = Company::byUser(auth()->user())->get();
        $contacts = Contact::byUser(auth()->user())->get();
        $types = Activity::TYPES;
        $statuses = Activity::STATUSES;

        // Si viene de una compañía o contacto específico
        $preSelectedCompany = $request->get('company_id');
        $preSelectedContact = $request->get('contact_id');

        return view('activities.create', compact('companies', 'contacts', 'types', 'statuses', 'preSelectedCompany', 'preSelectedContact'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $activity = $this->activityService->createActivity($request->validated(), $request->user());

        return redirect()->route('activities.show', $activity)
            ->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity): View
    {
        $activity->load(['company', 'contact']);

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        $companies = Company::byUser(auth()->user())->get();
        $contacts = Contact::byUser(auth()->user())->get();
        $types = Activity::TYPES;
        $statuses = Activity::STATUSES;

        return view('activities.edit', compact('activity', 'companies', 'contacts', 'types', 'statuses'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        $this->activityService->updateActivity($activity, $request->validated());

        return redirect()->route('activities.show', $activity)
            ->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $this->activityService->deleteActivity($activity);

        return redirect()->route('activities.index')
            ->with('success', 'Activity deleted successfully.');
    }

    public function complete(Activity $activity): RedirectResponse
    {
        $this->authorize('update', $activity);
        
        $this->activityService->markAsCompleted($activity);

        return redirect()->back()
            ->with('success', 'Activity marked as completed.');
    }

    public function search(Request $request): View
    {
        $activities = $this->activityService->searchActivities(
            $request->user(), 
            $request->get('search', '')
        );

        return view('activities.index', compact('activities'));
    }
}