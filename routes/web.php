<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\RegistrationController;

Route::get('register/patient', [RegistrationController::class, 'showPatientForm'])->name('register.patient.form');
Route::post('register/patient', [RegistrationController::class, 'registerPatient'])->name('register.patient.submit');

Route::get('register/doctor', [RegistrationController::class, 'showDoctorForm'])->name('register.doctor.form');
Route::post('register/doctor', [RegistrationController::class, 'registerDoctor'])->name('register.doctor.submit');


use App\Http\Controllers\LoginController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;


Route::get('patient/home', [PatientController::class, 'home'])->name('patient.home');

Route::get('doctor/home', [DoctorController::class, 'home'])->name('doctor.home');
Route::post('doctor/appointments/{id}/status', [DoctorController::class, 'updateAppointmentStatus'])->name('doctor.appointments.update_status');

use App\Http\Controllers\AppointmentController;

Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('appointments.index'); //  todas las citas
    Route::post('/', [AppointmentController::class, 'create'])->name('appointments.create'); //  una nueva cita
    Route::get('/{id}', [AppointmentController::class, 'show'])->name('appointments.show'); //  una cita específica
    Route::put('/{id}', [AppointmentController::class, 'update'])->name('appointments.update'); // Actualizar una cita
    Route::delete('/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy'); // Eliminar una cita

    Route::get('/patient/{patientId}', [AppointmentController::class, 'getAppointmentsByPatient'])->name('appointments.byPatient');

   Route::get('/doctor/{doctorId}', [AppointmentController::class, 'getAppointmentsByDoctor'])->name('appointments.byDoctor');


    Route::post('/appointments/update_status/{appointmentId}', [AppointmentController::class, 'updateAppointmentStatus'])->name('doctor.appointments.update_status');
});
