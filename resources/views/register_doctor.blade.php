<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Doctor</title>
</head>
<body>
    <h1>Register Doctor</h1>
    <form action="{{ route('register.doctor.submit') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" id="specialty" required><br><br>

        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" id="start_time" required><br><br>

        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" id="end_time" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
