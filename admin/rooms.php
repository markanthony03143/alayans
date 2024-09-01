<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Rooms</title>
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
        <h1 class="fw-bold mb-3">Meeting Rooms</h1>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add Room</button>
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
                    <?php
                        $rooms = [
                            ['id' => 1, 'name' => 'Boardroom A', 'location' => '1st Floor', 'capacity' => 20, 'facilities' => 'Projector, Whiteboard'],
                            ['id' => 2, 'name' => 'Conference Room B', 'location' => '2nd Floor', 'capacity' => 50, 'facilities' => 'Video conferencing, Smart TV'],
                            ['id' => 3, 'name' => 'Meeting Room C', 'location' => '3rd Floor', 'capacity' => 10, 'facilities' => 'Whiteboard'],
                            ['id' => 4, 'name' => 'Executive Suite', 'location' => '5th Floor', 'capacity' => 8, 'facilities' => 'Video conferencing, Catering'],
                            ['id' => 5, 'name' => 'Training Room', 'location' => 'Basement', 'capacity' => 30, 'facilities' => 'Projector, Computers'],
                        ];

                        foreach ($rooms as $room) {
                            echo "<tr>
                                <td>{$room['id']}</td>
                                <td>{$room['name']}</td>
                                <td>{$room['location']}</td>
                                <td>{$room['capacity']}</td>
                                <td>{$room['facilities']}</td>
                                <td class='action-column'>
                                    <div class='action-buttons'>
                                        <button class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#editRoomModal' data-room-id='{$room['id']}'>Edit</button>
                                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteRoomModal' data-room-id='{$room['id']}'>Delete</button>
                                    </div>
                                </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark">Add Room</button>
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
                    <button type="button" class="btn btn-outline-danger" onclick="saveRoomChanges()">Save Changes</button>
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