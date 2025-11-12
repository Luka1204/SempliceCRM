<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;
use App\Repositories\ActivityRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityService
{
    public function __construct(
        private ActivityRepository $activityRepository
    ) {}

    public function getUserActivities(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->activityRepository->getAllForUser($user, $perPage);
    }

    public function getUpcomingActivities(User $user, int $days = 7): LengthAwarePaginator
    {
        return $this->activityRepository->getUpcomingForUser($user, $days);
    }

    public function createActivity(array $data, User $user): Activity
    {
        return $this->activityRepository->createForUser($data, $user);
    }

    public function updateActivity(Activity $activity, array $data): bool
    {
        return $this->activityRepository->update($activity, $data);
    }

    public function deleteActivity(Activity $activity): bool
    {
        return $this->activityRepository->delete($activity);
    }

    public function markAsCompleted(Activity $activity): bool
    {
        return $this->activityRepository->markAsCompleted($activity);
    }

    public function searchActivities(User $user, string $search): LengthAwarePaginator
    {
        return $this->activityRepository->searchForUser($user, $search);
    }

    public function getActivityStats(User $user): array
    {
        $totalActivities = Activity::byUser($user)->count();
        $upcomingActivities = Activity::byUser($user)->upcoming()->count();
        $completedActivities = Activity::byUser($user)->completed()->count();

        return [
            'total_activities' => $totalActivities,
            'upcoming_activities' => $upcomingActivities,
            'completed_activities' => $completedActivities,
        ];
    }
}