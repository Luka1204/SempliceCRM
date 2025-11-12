<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityRepository
{
    public function getAllForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Activity::byUser($user)
            ->with(['company', 'contact'])
            ->latest()
            ->paginate($perPage);
    }

    public function getUpcomingForUser(User $user, int $days = 7): LengthAwarePaginator
    {
        return Activity::byUser($user)
            ->upcoming($days)
            ->with(['company', 'contact'])
            ->paginate(10);
    }

    public function findForUser(int $id, User $user): ?Activity
    {
        return Activity::byUser($user)->with(['company', 'contact'])->find($id);
    }

    public function createForUser(array $data, User $user): Activity
    {
        return Activity::create([
            ...$data,
            'user_id' => $user->id,
            'status' => $data['scheduled_at'] ? 'scheduled' : 'completed'
        ]);
    }

    public function update(Activity $activity, array $data): bool
    {
        return $activity->update($data);
    }

    public function delete(Activity $activity): bool
    {
        return $activity->delete();
    }

    public function markAsCompleted(Activity $activity): bool
    {
        return $activity->markAsCompleted();
    }

    public function searchForUser(User $user, string $search): LengthAwarePaginator
    {
        return Activity::byUser($user)
            ->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->with(['company', 'contact'])
            ->latest()
            ->paginate(10);
    }

    public function getByCompany(User $user, int $companyId): LengthAwarePaginator
    {
        return Activity::byUser($user)
            ->where('company_id', $companyId)
            ->with(['company', 'contact'])
            ->latest()
            ->paginate(10);
    }

    public function getByContact(User $user, int $contactId): LengthAwarePaginator
    {
        return Activity::byUser($user)
            ->where('contact_id', $contactId)
            ->with(['company', 'contact'])
            ->latest()
            ->paginate(10);
    }
}