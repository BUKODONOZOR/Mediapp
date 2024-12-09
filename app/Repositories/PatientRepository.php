<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    public function getAll()
    {
        return Patient::all();
    }

    public function findById($id)
    {
        return Patient::find($id);
    }

    public function findByEmail(string $email)
    {
        return Patient::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return Patient::create($data);
    }

    public function update($id, array $data)
    {
        $patient = $this->findById($id);
        return $patient ? $patient->update($data) : null;
    }

    public function delete($id)
    {
        $patient = $this->findById($id);
        return $patient ? $patient->delete() : false;
    }
}
