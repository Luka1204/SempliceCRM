<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\User;
use App\Repositories\DealRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DealService
{
    public function __construct(
        private DealRepository $dealRepository
    ) {}

    public function getUserDeals(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->dealRepository->getAllForUser($user, $perPage);
    }

    public function createDeal(array $data, User $user): Deal
    {
        return $this->dealRepository->createForUser($data, $user);
    }

    public function updateDeal(Deal $deal, array $data): bool
    {
        return $this->dealRepository->update($deal, $data);
    }

    public function deleteDeal(Deal $deal): bool
    {
        return $this->dealRepository->delete($deal);
    }

    public function getDealsByStage(User $user, string $stage): LengthAwarePaginator
    {
        return $this->dealRepository->getByStage($user, $stage);
    }

    public function getUpcomingDeals(User $user, int $days = 7): LengthAwarePaginator
    {
        return $this->dealRepository->getUpcomingDeals($user, $days);
    }

    public function getDealStats(User $user): array
    {
        return $this->dealRepository->getStats($user);
    }

    public function closeDealAsWon(Deal $deal): bool
    {
        return $deal->closeWon();
    }

    public function closeDealAsLost(Deal $deal): bool
    {
        return $deal->closeLost();
    }
}