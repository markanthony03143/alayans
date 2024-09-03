<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
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
    <?php 
        include 'navbar.php'; 
        $itemsPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
    ?>
    <div class="container mt-5">
        <h1 class="fw-bold mb-3">Users</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search users" aria-label="Search" name="search">
                <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mt-3 align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="action-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>john@doe.com</td>
                        <td>Admin</td>
                        <td>123456</td>
                        <td class="action-column">
                            <div class="action-buttons">
                                <button class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#editUserModal' data-user-id='$i'>Edit</button>
                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteUserModal' data-user-id='$i'>Delete</button>
                            </div>
                        </td>
                    </tr> -->
                    <?php
                        $users = [];
                        for ($i = 1; $i <= 30; $i++) {
                            $users[] = [
                                'id' => $i,
                                'name' => 'John Doe',
                                'email' => 'john@doe.com'
                            ];
                        }

                        $filteredUsers = array_filter($users, function($user) use ($search) {
                            return empty($search) || 
                                stripos($user['name'], $search) !== false || 
                                stripos($user['email'], $search) !== false;
                        });
    
                        $totalItems = count($filteredUsers);
                        $totalPages = ceil($totalItems / $itemsPerPage);
                        $currentPage = min($currentPage, $totalPages);
    
                        $offset = ($currentPage - 1) * $itemsPerPage;
                        $paginatedUsers = array_slice($filteredUsers, $offset, $itemsPerPage);
    
                        foreach ($paginatedUsers as $user) {
                            echo "<tr>
                                <td>{$user['id']}</td>
                                <td>{$user['name']}</td>
                                <td>{$user['email']}</td>
                                <td class='action-column'>
                                    <div class='action-buttons'>
                                        <button class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#editUserModal' data-user-id='{$user['id']}'>Edit</button>
                                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteUserModal' data-user-id='{$user['id']}'>Delete</button>
                                    </div>
                                </td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="User table navigation">
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole" required>
                                <option value="">Select a role</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="userPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark">Add User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="editUserId">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editUserName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role</label>
                            <select class="form-select" id="editUserRole" required>
                                <option value="">Select a role</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUserPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editUserPassword" placeholder="Leave blank to keep current password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-danger">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                    <p class="fw-bold" id="deleteUserName"></p>
                    <input type="hidden" id="deleteUserId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete User</button>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        // JavaScript to handle populating the edit modal with user data
        var editUserModal = document.getElementById('editUserModal')
        editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var userId = button.getAttribute('data-user-id')
            var modalTitle = editUserModal.querySelector('.modal-title')
            var userIdInput = editUserModal.querySelector('#editUserId')

            modalTitle.textContent = 'Edit User ' + userId
            userIdInput.value = userId

            // Here you would typically fetch the user data and populate the form
            // For this example, we'll just set some placeholder data
            editUserModal.querySelector('#editUserName').value = 'John Doe'
            editUserModal.querySelector('#editUserEmail').value = 'john@doe.com'
            editUserModal.querySelector('#editUserRole').value = 'Admin'
            editUserModal.querySelector('#editUserPassword').value = ''
        })

        // JavaScript to handle populating the delete modal with user data
        var deleteUserModal = document.getElementById('deleteUserModal')
        deleteUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var userId = button.getAttribute('data-user-id')
            var modalTitle = deleteUserModal.querySelector('.modal-title')
            var userIdInput = deleteUserModal.querySelector('#deleteUserId')
            var userNameElement = deleteUserModal.querySelector('#deleteUserName')

            modalTitle.textContent = 'Delete User ' + userId
            userIdInput.value = userId
            userNameElement.textContent = 'John Doe' // Replace with actual user name

            // Here you would typically fetch the user data to display the name
            // For this example, we're using a placeholder name
        })
    </script>


</body>
</html>