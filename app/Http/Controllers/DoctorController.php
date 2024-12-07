<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use App\Services\DoctorService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected $service;

    public function __construct(DoctorService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllDoctors());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:doctors',
            'specialty' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'phone_number' => 'nullable|string',
        ]);

        return response()->json($this->service->createDoctor($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'nullable|email|unique:doctors,email,' . $id,
            'name' => 'nullable|string',
            'specialty' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'phone_number' => 'nullable|string',
        ]);

        return response()->json($this->service->updateDoctor($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->service->deleteDoctor($id));
    }
}