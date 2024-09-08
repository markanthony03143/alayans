<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Rooms</title>
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

        $rooms = [
            ['id' => 1, 'name' => 'Boardroom A', 'location' => '1st Floor', 'capacity' => 20, 'facilities' => 'Projector, Whiteboard'],
            ['id' => 2, 'name' => 'Conference Room B', 'location' => '2nd Floor', 'capacity' => 50, 'facilities' => 'Video conferencing, Smart TV'],
            ['id' => 3, 'name' => 'Meeting Room C', 'location' => '3rd Floor', 'capacity' => 10, 'facilities' => 'Whiteboard'],
            ['id' => 4, 'name' => 'Executive Suite', 'location' => '5th Floor', 'capacity' => 8, 'facilities' => 'Video conferencing, Catering'],
            ['id' => 5, 'name' => 'Training Room', 'location' => 'Basement', 'capacity' => 30, 'facilities' => 'Projector, Computers'],
        ];

        $facilities = ['Projector', 'Whiteboard', 'Video conferencing', 'Smart TV', 'Catering', 'Computers'];

        for ($i = 6; $i <= 30; $i++) {
            $roomFacilities = array_rand(array_flip($facilities), rand(1, 3));
            $roomFacilities = is_array($roomFacilities) ? $roomFacilities : [$roomFacilities];
            
            $rooms[] = [
                'id' => $i,
                'name' => 'Room ' . chr(64 + ($i % 26 + 1)), // This will cycle through A-Z
                'location' => (($i % 5) + 1) . ord('st') . ' Floor',
                'capacity' => rand(5, 50),
                'facilities' => implode(', ', $roomFacilities)
            ];
        }

        $filteredRooms = array_filter($rooms, function($room) use ($search) {
            return empty($search) || 
                   stripos($room['name'], $search) !== false || 
                   stripos($room['location'], $search) !== false ||
                   stripos($room['facilities'], $search) !== false;
        });
        
        $totalItems = count($filteredRooms);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = min($currentPage, $totalPages);
        
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedRooms = array_slice($filteredRooms, $offset, $itemsPerPage);
    ?>
    <div class="container mt-5">
        <h1 class="fw-bold mb-3">Meeting Rooms</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add Room</button>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search rooms" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mt-3 align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Facilities</th>
                        <th class="action-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paginatedRooms as $room): ?>
                        <tr>
                            <td><?php echo $room['id']; ?></td>
                            <td><?php echo $room['name']; ?></td>
                            <td><?php echo $room['location']; ?></td>
                            <td><?php echo $room['capacity']; ?></td>
                            <td><?php echo $room['facilities']; ?></td>
                            <td class='action-column'>
                                <div class='action-buttons'>
                                    <button class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#editRoomModal' data-room-id='<?php echo $room['id']; ?>'>Edit</button>
                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteRoomModal' data-room-id='<?php echo $room['id']; ?>'>Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Room table navigation">
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

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="roomName" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="roomLocation" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomCapacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="roomCapacity" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomFacilities" class="form-label">Facilities</label>
                            <textarea class="form-control" id="roomFacilities" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Add Room</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm">
                        <input type="hidden" id="editRoomId">
                        <div class="mb-3">
                            <label for="editRoomName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editRoomName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoomLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="editRoomLocation" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoomCapacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="editRoomCapacity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoomFacilities" class="form-label">Facilities</label>
                            <textarea class="form-control" id="editRoomFacilities" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="saveRoomChanges()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Room Modal -->
    <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomModalLabel">Delete Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this room?</p>
                    <p class="fw-bold" id="deleteRoomName"></p>
                    <input type="hidden" id="deleteRoomId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteRoom()">Delete Room</button>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        // JavaScript to handle populating the edit modal with room data
        var editRoomModal = document.getElementById('editRoomModal')
        editRoomModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var roomId = button.getAttribute('data-room-id')
            var modalTitle = editRoomModal.querySelector('.modal-title')
            var roomIdInput = editRoomModal.querySelector('#editRoomId')

            modalTitle.textContent = 'Edit Room ' + roomId
            roomIdInput.value = roomId

            // Here you would typically fetch the room data and populate the form
            // For this example, we'll just set some placeholder data
            editRoomModal.querySelector('#editRoomName').value = 'Boardroom A'
            editRoomModal.querySelector('#editRoomLocation').value = '1st Floor'
            editRoomModal.querySelector('#editRoomCapacity').value = '20'
            editRoomModal.querySelector('#editRoomFacilities').value = 'Projector, Whiteboard'
        })

        // JavaScript to handle populating the delete modal with room data
        var deleteRoomModal = document.getElementById('deleteRoomModal')
        deleteRoomModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var roomId = button.getAttribute('data-room-id')
            var modalTitle = deleteRoomModal.querySelector('.modal-title')
            var roomIdInput = deleteRoomModal.querySelector('#deleteRoomId')
            var roomNameElement = deleteRoomModal.querySelector('#deleteRoomName')

            modalTitle.textContent = 'Delete Room ' + roomId
            roomIdInput.value = roomId
            roomNameElement.textContent = 'Boardroom A' // Replace with actual room name

            // Here you would typically fetch the room data to display the name
            // For this example, we're using a placeholder name
        })

        
    </script>
</body>
</html>
