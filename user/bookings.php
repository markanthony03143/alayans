<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <?php include
        'navbar.php'; 
        $itemsPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';    

        // Sample booking data
        $bookings = [
            ['id' => 1, 'room' => 'Conference Room B', 'date' => '2023-05-15', 'time' => '09:00 AM', 'duration' => 2],
            ['id' => 2, 'room' => 'Meeting Room C', 'date' => '2023-05-16', 'time' => '11:00 AM', 'duration' => 1],
            ['id' => 3, 'room' => 'BoardRoom A', 'date' => '2023-05-17', 'time' => '01:30 PM', 'duration' => 3],
            ['id' => 4, 'room' => 'Training Room', 'date' => '2023-05-18', 'time' => '03:30 PM', 'duration' => 1],
            ['id' => 5, 'room' => 'Executive Suite', 'date' => '2023-05-19', 'time' => '05:00 PM', 'duration' => 4],
        ];

        for ($i = 6; $i <= 50; $i++) {
            $bookings[] = [
                'id' => $i,
                'room' => 'Room ' . chr(64 + ($i % 5 + 1)),
                'date' => date('Y-m-d', strtotime("+$i days")),
                'time' => date('H:i', strtotime("+$i hours")),
                'duration' => rand(1, 4)
            ];
        }

        $filteredBookings = array_filter($bookings, function($booking) use ($search) {
            return empty($search) || 
                   stripos($booking['room'], $search) !== false || 
                   stripos($booking['date'], $search) !== false ||
                   stripos($booking['time'], $search) !== false;
        });
        
        $totalItems = count($filteredBookings);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = min($currentPage, $totalPages);
        
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedBookings = array_slice($filteredBookings, $offset, $itemsPerPage);
    ?>
    <div class="container mt-5">
        <h1 class="fw-bold mb-3">Bookings</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#bookRoomModal">Book a Room</button>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search bookings" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
        </div>
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
                    <?php foreach ($paginatedBookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['room']; ?></td>
                            <td><?php echo $booking['date']; ?></td>
                            <td><?php echo $booking['time']; ?></td>
                            <td><?php echo $booking['duration'] . ' ' . ($booking['duration'] > 1 ? 'hours' : 'hour'); ?></td>
                            <td class="action-column">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#editBookingModal" data-booking-id="<?php echo $booking['id']; ?>">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookingModal" data-booking-id="<?php echo $booking['id']; ?>">Cancel</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Booking table navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

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
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isRecurring">
                                <label class="form-check-label" for="isRecurring">
                                    Recurring Booking
                                </label>
                            </div>
                        </div>
                        <div id="recurringOptions" style="display: none;">
                            <div class="mb-3">
                                <label for="recurringType" class="form-label">Repeat</label>
                                <select class="form-select" id="recurringType">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recurringUntil" class="form-label">Until</label>
                                <input type="date" class="form-control" id="recurringUntil">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success">Book Room</button>
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
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editIsRecurring">
                                <label class="form-check-label" for="editIsRecurring">
                                    Recurring Booking
                                </label>
                            </div>
                        </div>
                        <div id="editRecurringOptions" style="display: none;">
                            <div class="mb-3">
                                <label for="editRecurringType" class="form-label">Repeat</label>
                                <select class="form-select" id="editRecurringType">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editRecurringUntil" class="form-label">Until</label>
                                <input type="date" class="form-control" id="editRecurringUntil">
                            </div>
                        </div>
                        <div id="editRecurringUpdateOptions" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Update:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editRecurringUpdate" id="editRecurringUpdateThis" value="this" checked>
                                    <label class="form-check-label" for="editRecurringUpdateThis">
                                        This occurrence only
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editRecurringUpdate" id="editRecurringUpdateFollowing" value="following">
                                    <label class="form-check-label" for="editRecurringUpdateFollowing">
                                        This and following occurrences
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editRecurringUpdate" id="editRecurringUpdateAll" value="all">
                                    <label class="form-check-label" for="editRecurringUpdateAll">
                                        All occurrences
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" >Update Booking</button>
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
                    <div id="cancelRecurringOptions" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Cancel:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cancelRecurring" id="cancelRecurringThis" value="this" checked>
                                <label class="form-check-label" for="cancelRecurringThis">
                                    This occurrence only
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cancelRecurring" id="cancelRecurringFollowing" value="following">
                                <label class="form-check-label" for="cancelRecurringFollowing">
                                    This and following occurrences
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cancelRecurring" id="cancelRecurringAll" value="all">
                                <label class="form-check-label" for="cancelRecurringAll">
                                    All occurrences
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Booking</button>
                    <button type="button" class="btn btn-danger" >Yes, Cancel Booking</button>
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
            var cancelRecurringOptions = deleteBookingModal.querySelector('#cancelRecurringOptions')

            modalTitle.textContent = 'Cancel Booking ' + bookingId
            bookingIdInput.value = bookingId

            // Here you would typically fetch the booking data and populate the details
            // For this example, we'll just set some placeholder data
            var isRecurring = Math.random() < 0.5; // Randomly decide if the booking is recurring
            var recurringType = isRecurring ? ['Daily', 'Weekly', 'Monthly'][Math.floor(Math.random() * 3)] : 'None';

            bookingDetails.innerHTML = 'Room: Conference Room B<br>' +
                                    'Date: 2023-05-15<br>' +
                                    'Time: 09:00 AM<br>' +
                                    'Duration: 2 hours<br>' +
                                    'Repeat: ' + recurringType;

            if (isRecurring) {
                cancelRecurringOptions.style.display = 'block';
            } else {
                cancelRecurringOptions.style.display = 'none';
            }
        })

        document.getElementById('isRecurring').addEventListener('change', function() {
            document.getElementById('recurringOptions').style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('editIsRecurring').addEventListener('change', function() {
            document.getElementById('editRecurringOptions').style.display = this.checked ? 'block' : 'none';
            document.getElementById('editRecurringUpdateOptions').style.display = this.checked ? 'block' : 'none';
        });


    </script>
</body>
</html>
