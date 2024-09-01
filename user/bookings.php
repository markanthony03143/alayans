<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        body, table,th{
            font-family: 'Montserrat', sans-serif;
            color: #425974;
        }
        .action-column {
            width: 130px; /* Adjust as needed */
            min-width: 130px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
        }
        .action-buttons .btn {
            flex: 0 0 auto;
        }
        .modal-content{
            border-radius: 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="fw-bold mb-3">Bookings</h1>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#bookRoomModal">Book a Room</button>
        <div class="table-responsive">
            <table class="table table-striped mt-3 align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Duration</th>
                        <th class="action-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Sample booking data
                    $bookings = [
                        ['id' => 1, 'room' => 'Conference Room B', 'date' => '2023-05-15', 'time' => '09:00 AM', 'duration' => 2],
                        ['id' => 2, 'room' => 'Meeting Room C', 'date' => '2023-05-16', 'time' => '11:00 AM', 'duration' => 1],
                        ['id' => 3, 'room' => 'BoardRoom A', 'date' => '2023-05-17', 'time' => '01:30 PM', 'duration' => 3],
                        ['id' => 4, 'room' => 'Training Room', 'date' => '2023-05-18', 'time' => '03:30 PM', 'duration' => 1],
                        ['id' => 5, 'room' => 'Executive Suite', 'date' => '2023-05-19', 'time' => '05:00 PM', 'duration' => 4],
                    ];

                    foreach ($bookings as $booking) {
                        echo "<tr>";
                        echo "<td>" . $booking['id'] . "</td>";
                        echo "<td>" . $booking['room'] . "</td>";
                        echo "<td>" . $booking['date'] . "</td>";
                        echo "<td>" . $booking['time'] . "</td>";
                        echo "<td>" . $booking['duration'] . " hours</td>";
                        echo "<td class='action-column'>
                                <div class='action-buttons'>
                                    <button class='btn btn-sm btn-outline-danger' data-bs-toggle='modal' data-bs-target='#editBookingModal' data-booking-id='" . $booking['id'] . "'>Edit</button>
                                    <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteBookingModal' data-booking-id='" . $booking['id'] . "'>Cancel</button>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Book Room Modal -->
    <div class="modal fade" id="bookRoomModal" tabindex="-1" aria-labelledby="bookRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookRoomModalLabel">Book a Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookRoomForm">
                        <div class="mb-3">
                            <label for="bookRoomSelect" class="form-label">Select Room</label>
                            <select class="form-select" id="bookRoomSelect" required>
                                <option value="">Choose a room...</option>
                                <option value="1">Boardroom A</option>
                                <option value="2">Conference Room B</option>
                                <option value="3">Meeting Room C</option>
                                <option value="4">Executive Suite</option>
                                <option value="5">Training Room</option>
                                <!-- Add more room options as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bookDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="bookDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="bookTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookDuration" class="form-label">Duration (hours)</label>
                            <input type="number" class="form-control" id="bookDuration" min="0.5" max="8" step="0.5" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-dark">Book Room</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookingModalLabel">Edit Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBookingForm">
                        <input type="hidden" id="editBookingId">
                        <div class="mb-3">
                            <label for="editRoomSelect" class="form-label">Select Room</label>
                            <select class="form-select" id="editRoomSelect" required>
                                <option value="">Choose a room...</option>
                                <option value="1">Boardroom A</option>
                                <option value="2">Conference Room B</option>
                                <option value="3">Meeting Room C</option>
                                <option value="4">Executive Suite</option>
                                <option value="5">Training Room</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="editTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDuration" class="form-label">Duration (hours)</label>
                            <input type="number" class="form-control" id="editDuration" min="0.5" max="8" step="0.5" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-danger">Update Booking</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="deleteBookingModal" tabindex="-1" aria-labelledby="deleteBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBookingModalLabel">Cancel Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this booking?</p>
                    <p><strong>Booking Details:</strong></p>
                    <p id="cancelBookingDetails"></p>
                    <input type="hidden" id="cancelBookingId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Booking</button>
                    <button type="button" class="btn btn-danger">Yes, Cancel Booking</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ... (previous JavaScript code remains the same) ...

        // JavaScript to handle populating the edit modal with booking data
        var editBookingModal = document.getElementById('editBookingModal')
        editBookingModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var bookingId = button.getAttribute('data-booking-id')
            var modalTitle = editBookingModal.querySelector('.modal-title')
            var bookingIdInput = editBookingModal.querySelector('#editBookingId')

            modalTitle.textContent = 'Edit Booking ' + bookingId
            bookingIdInput.value = bookingId

            // Here you would typically fetch the booking data and populate the form
            // For this example, we'll just set some placeholder data
            editBookingModal.querySelector('#editRoomSelect').value = '2'
            editBookingModal.querySelector('#editDate').value = '2023-05-15'
            editBookingModal.querySelector('#editTime').value = '09:00'
            editBookingModal.querySelector('#editDuration').value = '2'
        })

        // JavaScript to handle populating the cancel modal with booking data
        var deleteBookingModal = document.getElementById('deleteBookingModal')
        deleteBookingModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var bookingId = button.getAttribute('data-booking-id')
            var modalTitle = deleteBookingModal.querySelector('.modal-title')
            var bookingIdInput = deleteBookingModal.querySelector('#cancelBookingId')
            var bookingDetails = deleteBookingModal.querySelector('#cancelBookingDetails')

            modalTitle.textContent = 'Cancel Booking ' + bookingId
            bookingIdInput.value = bookingId

            // Here you would typically fetch the booking data and populate the details
            // For this example, we'll just set some placeholder data
            bookingDetails.innerHTML = 'Room: Conference Room B<br>' +
                                       'Date: 2023-05-15<br>' +
                                       'Time: 09:00 AM<br>' +
                                       'Duration: 2 hours'
        })
    </script>
</body>
</html>