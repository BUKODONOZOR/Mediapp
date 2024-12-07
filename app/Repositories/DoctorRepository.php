<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;


class DoctorRepository
{
    public function getAll()
    {
        return Doctor::all();
    }

    public function findById($id)
    {
        return Doctor::find($id);
    }

    public function create(array $data)
    {
        return Doctor::create($data);
    }

    public function update($id, array $data)
    {
        $doctor = $this->findById($id);
        return $doctor ? $doctor->update($data) : null;
    }

    public function delete($id)
    {
        $doctor = $this->findById($id);
        return $doctor ? $doctor->delete() : false;
    }
}
