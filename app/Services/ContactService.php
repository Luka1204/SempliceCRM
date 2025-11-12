<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\User;
use App\Repositories\ContactRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService
{
    public function __construct(
        private ContactRepository $contactRepository
    ) {}

    public function getUserContacts(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->contactRepository->getAllForUser($user, $perPage);
    }

    public function createContact(array $data, User $user): Contact
    {
        return $this->contactRepository->createForUser($data, $user);
    }

    public function updateContact(Contact $contact, array $data): bool
    {
        return $this->contactRepository->update($contact, $data);
    }

    public function deleteContact(Contact $contact): bool
    {
        return $this->contactRepository->delete($contact);
    }

    public function searchContacts(User $user, string $search): LengthAwarePaginator
    {
        return $this->contactRepository->searchForUser($user, $search);
    }

    public function getContactsByCompany(User $user, int $companyId): LengthAwarePaginator
    {
        return $this->contactRepository->getByCompany($user, $companyId);
    }
}