<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Home</title>
</head>
<body>
    <h1>Welcome, {{ $name }}</h1>
    <h2>Your Patient ID is: {{ $patientId }}</h2>  <!-- Mostrar el ID aquí -->
    <h2>Your Appointments</h2>
@if (!empty($appointments) && $appointments->count() > 0)
    <ul>
        @foreach ($appointments as $appointment)
            <li>
                {{ $appointment->date }} - {{ $appointment->time }} - {{ $appointment->reason }}
                (Doctor: {{ $appointment->doctor->name }})
            </li>
        @endforeach
    </ul>
@else
    <p>No appointments found.</p>
@endif


    @if (session('success'))
        <div>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <form method="POST" action="/appointments">
    @csrf
    <input type="text" name="date" placeholder="Fecha">
    <input type="text" name="time" placeholder="Hora">
    <input type="text" name="reason" placeholder="Motivo">
    <input type="text" name="doctor_id" placeholder="ID del doctor">
    <input type="text" name="patient_id" value="{{ $patientId }}" placeholder="ID del paciente" readonly>
    <button type="submit">Crear Cita</button>
    </form>

    <h2>Your Appointments</h2>
    <ul>
        @foreach ($appointments as $appointment)
            <li>
                {{ $appointment->date }} - {{ $appointment->time }} - {{ $appointment->reason }} 
                (Doctor: {{ $appointment->doctor->name }})
            </li>
        @endforeach
    </ul>
</body>
</html>
