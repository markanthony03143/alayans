
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        body, table, th {
            font-family: 'Montserrat', sans-serif;
            color: #425974;
        }
        .action-column {
            width: 130px;
            min-width: 130px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
        }
        .action-buttons .btn {
            flex: 0 0 auto;
        }
        .modal-content {
            border-radius: 0;
            position: relative;
            margin: auto;
            top: 20%;
            width: 80%;
            max-width: 600px;
        }
        .modal-dialog {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }
        .pagination .page-link:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }
        .pagination .page-link {
            color: #dc3545;
        }
        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include 'SAnavbar.php';?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <h2 class="fw-bold mb-3">Booking</h2>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Event Entry Modal -->
    <div class="modal fade" id="event_entry_modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Book a Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="room_select">Select Room</label>
                        <select name="room_select" id="room_select" class="form-control">
                            <option value="">Choose a room...</option>
                            <option value="Conference Room">Conference Room</option>
                            <option value="Training Room">Training Room</option>
                            <option value="Meeting Room A">Meeting Room A</option>
                            <option value="Meeting Room B">Meeting Room B</option>
                            <option value="Meeting Room C">Meeting Room C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event_name">Booking Name</label>
                        <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter your booking name">
                    </div>
                    <div class="form-group">
                        <label for="event_start_date">Date</label>
                        <input type="date" name="event_start_date" id="event_start_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="event_time">Time</label>
                        <input type="time" name="event_time" id="event_time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="event_duration">Duration (hours)</label>
                        <input type="number" name="event_duration" id="event_duration" class="form-control" placeholder="Enter duration in hours" step="0.5" min="0.5">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="recurring_booking">
                        <label class="form-check-label" for="recurring_booking">Recurring Booking</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_event()">Save Booking</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" id="event_details_modal" tabindex="-1" aria-labelledby="eventDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Room:</strong> <span id="event_room"></span></p>
                    <p><strong>Booking Name:</strong> <span id="event_name_details"></span></p>
                    <p><strong>Date:</strong> <span id="event_date"></span></p>
                    <p><strong>Time:</strong> <span id="event_time"></span></p>
                    <p><strong>Duration:</strong> <span id="event_duration"></span> hours</p>
                    <p><strong>Recurring Booking:</strong> <span id="event_recurring"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize FullCalendar with basic configuration
            var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    // Populate the modal with selected dates
                    $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                    $('#event_entry_modal').modal('show');
                },
                events: [],  // Initially, no events
                eventRender: function(event, element) {
                    if (event.description) {
                        element.find('.fc-title').append('<br/><span class="fc-description">' + event.description + '</span>');
                    }
                },
                eventClick: function(event) {
                    // Populate and show the event details modal
                    $('#event_room').text(event.title.split(' (')[1].replace(')', ''));
                    $('#event_name_details').text(event.title.split(' (')[0]);
                    $('#event_date').text(moment(event.start).format('YYYY-MM-DD'));
                    $('#event_time').text(moment(event.start).format('HH:mm'));

                    // Calculate and format the duration
                    var duration = moment.duration(moment(event.end).diff(moment(event.start)));
                    var hours = duration.asHours();
                    $('#event_duration').text(hours.toFixed(1)); // Display with one decimal place
                    
                    $('#event_recurring').text(event.description === "Recurring Booking" ? "Yes" : "No");

                    $('#event_details_modal').modal('show');
                }
            });
        });

        // Function to save an event and add it to the calendar
        function save_event() {
            var event_name = $("#event_name").val();
            var event_start_date = $("#event_start_date").val();
            var event_time = $("#event_time").val();
            var event_duration = parseFloat($("#event_duration").val());
            var room_select = $("#room_select").val();
            var recurring_booking = $("#recurring_booking").is(":checked");

            if (event_name === "" || event_start_date === "" || event_time === "" || isNaN(event_duration)) {
                alert("Please enter all required details.");
                return false;
            }

            // Calculate event end time based on duration
            var start_datetime = moment(event_start_date + ' ' + event_time);
            var end_datetime = start_datetime.clone().add(event_duration, 'hours');

            // Add the new event to the calendar
            $('#calendar').fullCalendar('renderEvent', {
                title: `${event_name} (${room_select})`,
                start: start_datetime,
                end: end_datetime,
                description: recurring_booking ? "Recurring Booking" : "",
                allDay: false
            }, true); // Stick the event

            // Hide the modal
            $('#event_entry_modal').modal('hide');

            // Clear the form fields
            $("#event_name").val('');
            $("#event_start_date").val('');
            $("#event_time").val('');
            $("#event_duration").val('');
            $("#room_select").val('Conference Room');
            $("#recurring_booking").prop('checked', false);
        }
    </script>
</body>
</html>