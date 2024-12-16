<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Appointments</h2>
    <div id="success-message" class="alert alert-success d-none"></div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Service</th>
            <th>Appointment Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="appointments-table">
        <!-- Data will be loaded dynamically -->
        </tbody>
    </table>
</div>

<script>
    // Load appointments using AJAX
    function loadAppointments() {
        $.ajax({
            url: '/appointments', // Route to fetch appointments
            method: 'GET',
            success: function (data) {
                let rows = '';
                data.forEach((appointment, index) => {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${appointment.service.name}</td>
                            <td>${appointment.appointment_time}</td>
                            <td>${appointment.status}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteAppointment(${appointment.id})">Delete</button>
                            </td>
                        </tr>`;
                });
                $('#appointments-table').html(rows);
            },
            error: function (error) {
                console.error('Error loading appointments:', error);
            }
        });
    }

    // Delete appointment
    function deleteAppointment(id) {
        if (confirm('Are you sure you want to delete this appointment?')) {
            $.ajax({
                url: `/appointments/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function () {
                    $('#success-message').text('Appointment deleted successfully!').removeClass('d-none');
                    loadAppointments();
                },
                error: function (error) {
                    console.error('Error deleting appointment:', error);
                }
            });
        }
    }

    // Load appointments on page load
    $(document).ready(function () {
        loadAppointments();
    });

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>
</body>
</html>
