<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyService
{
    public function __construct(
        private CompanyRepository $companyRepository
    ) {}

    public function getUserCompanies(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->companyRepository->getAllForUser($user, $perPage);
    }

    public function createCompany(array $data, User $user): Company
    {
        // Aquí puedes añadir lógica de negocio adicional
        // como notificaciones, eventos, etc.
        
        return $this->companyRepository->createForUser($data, $user);
    }

    public function updateCompany(Company $company, array $data): bool
    {
        return $this->companyRepository->update($company, $data);
    }

    public function deleteCompany(Company $company): bool
    {
        // Lógica adicional antes de eliminar
        if ($company->contacts()->exists()) {
            throw new \Exception('No se puede eliminar una empresa con contactos asociados.');
        }

        return $this->companyRepository->delete($company);
    }

    public function searchCompanies(User $user, string $search): LengthAwarePaginator
    {
        return $this->companyRepository->searchForUser($user, $search);
    }
}