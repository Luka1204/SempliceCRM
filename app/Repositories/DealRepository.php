<?php

namespace App\Repositories;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class DealRepository
{
    public function getAllForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Deal::byUser($user)
            ->with(['company', 'contact'])
            ->latest()
            ->paginate($perPage);
    }

    public function findForUser(int $id, User $user): ?Deal
    {
        return Deal::byUser($user)->with(['company', 'contact'])->find($id);
    }

    public function createForUser(array $data, User $user): Deal
    {
        return Deal::create([
            ...$data,
            'user_id' => $user->id
        ]);
    }

    public function update(Deal $deal, array $data): bool
    {
        return $deal->update($data);
    }

    public function delete(Deal $deal): bool
    {
        return $deal->delete();
    }

    public function getByStage(User $user, string $stage): LengthAwarePaginator
    {
        return Deal::byUser($user)
            ->byStage($stage)
            ->with(['company', 'contact'])
            ->latest()
            ->paginate(10);
    }

    public function getUpcomingDeals(User $user, int $days = 7): LengthAwarePaginator
    {
        return Deal::byUser($user)
            ->upcoming($days)
            ->with(['company', 'contact'])
            ->latest()
            ->paginate(10);
    }

    public function getStats(User $user): array
    {
        return [
            'total' => Deal::byUser($user)->count(),
            'open' => Deal::byUser($user)->open()->count(),
            'closed' => Deal::byUser($user)->closed()->count(),
            'won' => Deal::byUser($user)->where('stage', 'closed_won')->count(),
            'total_amount' => Deal::byUser($user)->where('stage', 'closed_won')->sum('amount'),
        ];
    }
}