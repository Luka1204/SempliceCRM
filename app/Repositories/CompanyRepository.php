<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository
{
    public function getAllForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Company::byUser($user)
            ->withCount(['contacts', 'deals'])
            ->latest()
            ->paginate($perPage);
    }

    public function findForUser(int $id, User $user): ?Company
    {
        return Company::byUser($user)->find($id);
    }

    public function createForUser(array $data, User $user): Company
    {
        return Company::create([
            ...$data,
            'user_id' => $user->id
        ]);
    }

    public function update(Company $company, array $data): bool
    {
        return $company->update($data);
    }

    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    public function searchForUser(User $user, string $search): LengthAwarePaginator
    {
        return Company::byUser($user)
            ->search($search)
            ->latest()
            ->paginate(10);
    }
}