<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment; 

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Crear una nueva cita.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:255',
            'doctor_id' => 'required|integer|exists:doctors,id',
            'patient_id' => 'required|integer|exists:patients,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $appointment = $this->appointmentService->createAppointment($request->all());
            return response()->json([
                'message' => 'Appointment created successfully',
                'data' => $appointment,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Listar todas las citas.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $appointments = $this->appointmentService->getAllAppointments();
        return response()->json([
            'data' => $appointments,
        ]);
    }

    /**
     * Mostrar una cita específica.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $appointment = $this->appointmentService->getAppointmentById($id);
            return response()->json([
                'data' => $appointment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Actualizar una cita.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|date_format:Y-m-d',
            'time' => 'sometimes|date_format:H:i',
            'reason' => 'sometimes|string|max:255',
            'doctor_id' => 'sometimes|integer|exists:doctors,id',
            'patient_id' => 'sometimes|integer|exists:patients,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $appointment = $this->appointmentService->updateAppointment($id, $request->all());
            return response()->json([
                'message' => 'Appointment updated successfully',
                'data' => $appointment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Eliminar una cita.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->appointmentService->deleteAppointment($id);
            return response()->json([
                'message' => 'Appointment deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

   

    public function getAppointmentsByPatient($patientId)
    {
        // Obtener todas las citas asignadas al paciente con el id $patientId
        $appointments = $this->appointmentService->getAppointmentsByPatientId($patientId);

        // Obtener nombre del paciente desde la sesión
        $name = Session::get('user')['name'];

        // Pasar las citas y el nombre del paciente a la vista patient_home
        return view('patient_home', compact('appointments', 'name'));
    }

    public function getAppointmentsByDoctor($doctorId)
    {
        // Obtener las citas asignadas al doctor con el id $doctorId
        $appointments = $this->appointmentService->getAppointmentsByDoctorId($doctorId);
    
        // Obtener nombre del doctor desde la sesión
        $name = Session::get('user')['name'];
    
        // Pasar las citas y el nombre del doctor a la vista doctor_home
        return view('doctor_home', compact('appointments', 'name'));
    }


    public function updateAppointmentStatus(Request $request, $appointmentId)
{
    // Validar que el estado sea uno de los valores posibles
    $request->validate([
        'status' => 'required|in:Pending,Completed,Cancelled'
    ]);

    // Obtener la cita por su ID
    $appointment = Appointment::find($appointmentId);

    if (!$appointment) {
        return redirect()->back()->withErrors('Appointment not found');
    }

    // Actualizar el estado de la cita
    $appointment->status = $request->input('status');
    $appointment->save();

    // Redirigir al doctor con un mensaje de éxito
    return redirect()->route('appointments.byDoctor', ['doctorId' => $appointment->doctor_id])
                 ->with('success', 'Appointment status updated successfully');

}

    

} 


 

