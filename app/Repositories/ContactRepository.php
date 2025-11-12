<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactRepository
{
    public function getAllForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Contact::byUser($user)
            ->with('company')
            ->latest()
            ->paginate($perPage);
    }

    public function findForUser(int $id, User $user): ?Contact
    {
        return Contact::byUser($user)->with('company')->find($id);
    }

    public function createForUser(array $data, User $user): Contact
    {
        return Contact::create([
            ...$data,
            'user_id' => $user->id
        ]);
    }

    public function update(Contact $contact, array $data): bool
    {
        return $contact->update($data);
    }

    public function delete(Contact $contact): bool
    {
        return $contact->delete();
    }

    public function searchForUser(User $user, string $search): LengthAwarePaginator
    {
        return Contact::byUser($user)
            ->search($search)
            ->with('company')
            ->latest()
            ->paginate(10);
    }

    public function getByCompany(User $user, int $companyId): LengthAwarePaginator
    {
        return Contact::byUser($user)
            ->where('company_id', $companyId)
            ->with('company')
            ->latest()
            ->paginate(10);
    }
}