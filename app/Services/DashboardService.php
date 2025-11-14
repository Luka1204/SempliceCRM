<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function __construct(
        private ActivityService $activityService
    ) {}

    public function getUserStats(User $user): array
    {
        $activityStats = $this->activityService->getActivityStats($user);

        return [
            'companies_count' => Company::byUser($user)->count(),
            'contacts_count' => Contact::byUser($user)->count(),
            'deals_count' => Deal::byUser($user)->count(),
            'activities_count' => $activityStats['total'] ?? 0,
            'recent_companies_count' => Company::byUser($user)->where('created_at', '>=', now()->subDays(30))->count(),
            'recent_contacts_count' => Contact::byUser($user)->where('created_at', '>=', now()->subDays(30))->count(),
            'recent_deals_count' => Deal::byUser($user)->where('created_at', '>=', now()->subDays(30))->count(),
            'upcoming_activities_count' => $activityStats['scheduled'] ?? 0,
            'completed_activities_count' => $activityStats['completed'] ?? 0,
        ];
    }

    public function getRecentCompanies(User $user, int $limit = 5): Collection
    {
        return Company::byUser($user)
            ->withCount('contacts')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getRecentContacts(User $user, int $limit = 5): Collection
    {
        return Contact::byUser($user)
            ->with('company')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getRecentDeals(User $user, int $limit = 5): Collection
    {
        return Deal::byUser($user)
            ->with(['company', 'contact'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getUpcomingActivities(User $user, int $limit = 5): Collection
    {
        return Activity::byUser($user)
            ->upcoming(7) // Próximos 7 días
            ->with(['company', 'contact'])
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();
    }

    public function getRecentActivities(User $user, int $limit = 5): Collection
    {
        return Activity::byUser($user)
            ->with(['company', 'contact'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getCompaniesByCreationDate(User $user): array
    {
        return Company::byUser($user)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    public function getActivityTypesDistribution(User $user): array
    {
        return Activity::byUser($user)
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }
}