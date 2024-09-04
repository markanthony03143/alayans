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
        <?php 
            include 'navbar.php';
            $itemsPerPage = 10;
            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Sample booking data
            $bookings = [
                ['id' => 1, 'room' => 'Conference Room B', 'name' => 'John Doe', 'date' => '2023-05-15', 'time' => '09:00 AM', 'duration' => 2],
                ['id' => 2, 'room' => 'Meeting Room C', 'name' => 'Jane Doe', 'date' => '2023-05-16', 'time' => '11:00 AM', 'duration' => 1],
                ['id' => 3, 'room' => 'BoardRoom A', 'name' => 'John Smith', 'date' => '2023-05-17', 'time' => '01:30 PM', 'duration' => 3],
                ['id' => 4, 'room' => 'Training Room', 'name' => 'Jane Smith', 'date' => '2023-05-18', 'time' => '03:30 PM', 'duration' => 1],
                ['id' => 5, 'room' => 'Executive Suite', 'name' => 'John Doe', 'date' => '2023-05-19', 'time' => '05:00 PM', 'duration' => 4],
            ];

            for ($i = 6; $i <= 50; $i++) {
                $bookings[] = [
                    'id' => $i,
                    'room' => 'Room ' . chr(64 + ($i % 5 + 1)),
                    'name' => 'John Doe',
                    'date' => date('Y-m-d', strtotime("+$i days")),
                    'time' => date('h:i A', strtotime("+$i hours")),
                    'duration' => rand(1, 4)
                ];
            }

            $filteredBookings = array_filter($bookings, function($booking) use ($search) {
                return empty($search) || 
                    stripos($booking['room'], $search) !== false || 
                    stripos($booking['name'], $search) !== false ||
                    stripos($booking['date'], $search) !== false;
            });
            
            $totalItems = count($filteredBookings);
            $totalPages = ceil($totalItems / $itemsPerPage);
            $currentPage = min($currentPage, $totalPages);
            
            $offset = ($currentPage - 1) * $itemsPerPage;
            $paginatedBookings = array_slice($filteredBookings, $offset, $itemsPerPage);
        ?>
        <div class="container mt-5">
            <h1 class="fw-bold mb-3">Bookings</h1>
            <!-- Filter Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Filter Bookings</h5>
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-3">
                            <label for="filterRoom" class="form-label">Room</label>
                            <select class="form-select" id="filterRoom">
                                <option value="">All Rooms</option>
                                <option value="1">Boardroom A</option>
                                <option value="2">Conference Room B</option>
                                <option value="3">Meeting Room C</option>
                                <option value="4">Executive Suite</option>
                                <option value="5">Training Room</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filterDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                        <div class="col-md-3">
                            <label for="filterUser" class="form-label">User</label>
                            <input type="text" class="form-control" id="filterUser" placeholder="Enter user name">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger me-2" onclick="applyFilter()">Apply Filter</button>
                            <button type="button" class="btn btn-secondary" onclick="resetFilter()">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Room</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paginatedBookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking['id']; ?></td>
                                <td><?php echo $booking['room']; ?></td>
                                <td><?php echo $booking['name']; ?></td>
                                <td><?php echo $booking['date']; ?></td>
                                <td><?php echo $booking['time']; ?></td>
                                <td><?php echo $booking['duration'] . ' ' . ($booking['duration'] > 1 ? 'hours' : 'hour'); ?></td>
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
    </body>
    </html>