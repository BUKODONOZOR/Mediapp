<?php

namespace App\Services;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AppointmentService
{
    public function createAppointment(array $data): Appointment
    {
        $this->validateTimeConflicts($data['date'], $data['time'], $data['doctor_id']);
        $this->validateMedicalProblem($data['reason'], $data['patient_id']); 

        $appointment = Appointment::create([
            'date' => $data['date'],
            'time' => $data['time'],
            'reason' => $data['reason'], 
            'doctor_id' => $data['doctor_id'],
            'patient_id' => $data['patient_id'],
            'status' => $data['status'] ?? 'pending',
        ]);

        // Enviar correos electrónicos
        $this->sendEmailNotification($appointment);

        return $appointment;
    }

    protected function validateTimeConflicts(string $date, string $time, int $doctorId): void
    {
        $appointmentTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

        $conflict = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $date)
            ->where(function ($query) use ($appointmentTime) {
                $query->whereBetween('time', [
                    $appointmentTime->subHour()->format('H:i'),
                    $appointmentTime->addHour()->format('H:i'),
                ]);
            })
            ->exists();

        if ($conflict) {
            throw new \Exception('A conflicting appointment exists within the same timeframe.');
        }
    }

    protected function validateMedicalProblem(string $details, int $patientId): void
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        $exists = Appointment::where('patient_id', $patientId)
            ->where('reason', $details)
            ->where('date', '>=', $oneMonthAgo->format('Y-m-d'))
            ->exists();

        if ($exists) {
            throw new \Exception('You cannot register two appointments for the same medical problem within a month.');
        }
    }

    protected function sendEmailNotification(Appointment $appointment): void
    {
        $patientEmail = $appointment->patient->email;
        $doctorEmail = $appointment->doctor->email;

        $message = "Dear {$appointment->patient->name},\n\n";
        $message .= "An appointment has been scheduled:\n";
        $message .= "Date: {$appointment->date}\n";
        $message .= "Time: {$appointment->time}\n";
        $message .= "Reason: {$appointment->reason}\n";
        $message .= "Doctor: {$appointment->doctor->name}\n\n";
        $message .= "Thank you!";

        // Enviar correo al paciente
        Mail::raw($message, function ($mail) use ($patientEmail) {
            $mail->to($patientEmail)
                ->subject('New Appointment Scheduled');
        });

        // Enviar correo al doctor
        Mail::raw($message, function ($mail) use ($doctorEmail) {
            $mail->to($doctorEmail)
                ->subject('New Appointment Scheduled');
        });
    }

    public function getAllAppointments()
    {
        return Appointment::all();
    }

    public function getPaginatedAppointments(int $perPage = 10)
    {
        return Appointment::paginate($perPage);
    }

    public function getAppointmentById(int $id): Appointment
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            throw new \Exception("Appointment with ID {$id} not found.");
        }

        return $appointment;
    }

    public function getAppointmentsByPatientId(int $patientId)
    {
        return Appointment::where('patient_id', $patientId)->get();
    }

    public function getAppointmentsByDoctorId(int $doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)->get();
    }
}
