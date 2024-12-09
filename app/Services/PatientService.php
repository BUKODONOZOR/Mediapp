<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class PatientService
{
    protected $repository;

    public function __construct(PatientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPatients()
    {
        return $this->repository->getAll();
    }

    public function findPatientByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function createPatient(array $data)
    {
        return $this->repository->create($data);
    }

    public function updatePatient($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deletePatient($id)
    {
        return $this->repository->delete($id);
    }
}
 