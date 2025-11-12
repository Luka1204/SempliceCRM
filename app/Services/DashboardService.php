<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getUserStats(User $user): array
    {
        return [
            'companies_count' => Company::byUser($user)->count(),
            'contacts_count' => Contact::byUser($user)->count(),
            'recent_companies_count' => Company::byUser($user)->where('created_at', '>=', now()->subDays(30))->count(),
            'recent_contacts_count' => Contact::byUser($user)->where('created_at', '>=', now()->subDays(30))->count(),
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

    public function getCompaniesByCreationDate(User $user): array
    {
        return Company::byUser($user)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}