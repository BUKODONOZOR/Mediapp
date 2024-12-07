<?php
namespace App\Http\Controllers;

use App\Services\PatientService;
use App\Services\DoctorService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllAppointments());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'reason' => 'required|string',
            'status' => 'nullable|string',
        ]);

        try {
            return response()->json($this->service->createAppointment($data), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
            'reason' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        return response()->json($this->service->updateAppointment($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->service->deleteAppointment($id));
    }
}
