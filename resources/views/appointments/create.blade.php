<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Book a New Appointment</h2>
    <form id="appointment-form">
        <div class="mb-3">
            <label for="service" class="form-label">Service</label>
            <select class="form-select" id="service" name="service_id">
                <option value="">-- Select a Service --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="appointment-time" class="form-label">Appointment Time</label>
            <input type="datetime-local" class="form-control" id="appointment-time" name="appointment_time">
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
        <div id="error-message" class="alert alert-danger mt-3 d-none"></div>
    </form>
</div>

<script>
    // Submit form using AJAX
    $('#appointment-form').on('submit', function (event) {
        event.preventDefault();

        const formData = {
            service_id: $('#service').val(),
            appointment_time: $('#appointment-time').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '/appointments',
            method: 'POST',
            data: formData,
            success: function () {
                alert('Appointment booked successfully!');
                window.location.href = '/appointments';
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (const field in errors) {
                    errorMessage += `${errors[field][0]}<br>`;
                }
                $('#error-message').html(errorMessage).removeClass('d-none');
            }
        });
    });

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>
</body>
</html>
