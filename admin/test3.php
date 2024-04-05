<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Scheduling</title>
    <!-- Include FullCalendar.js CSS and JavaScript -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <!-- Include jQuery -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
</head>

<body>
    <div id='calendar'></div>

    <script>
        $(document).ready(function() {
            // Initialize FullCalendar
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaWeek,agendaDay'
                },
                // Fetch events from database
                events: 'get_events.php', // You need to create this file to fetch events from the database
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    // Handle selection of time slot here
                    alert('Selected: ' + start.format() + ' to ' + end.format());
                    // You can then proceed to submit the appointment request to the server
                }
            });
        });
    </script>
</body>

</html>