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
        body, table, th {
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
        .modal-content {
            border-radius: 0;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .button-group {
            display: flex;
            gap: 10px; /* Adjust gap as needed */
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
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        .modal-content {
            width: 100%;
            max-width: 500px; /* Adjust as needed */
        }
        .btn-cancel {
            background-color: #dc3545; /* Bootstrap's red color */
            color: #fff;
            border: none;
        }

        .btn-cancel:hover {
            background-color: #c82333; /* Darker shade of red for hover */
        }
    </style>
</head>
<body>
<?php include 'SAnavbar.php'; ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <!-- Button Group -->
        <div class="button-group">
            <!-- Filter by Role Dropdown -->
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="filterRoleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter by Role
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterRoleDropdown">
                    <li><a class="dropdown-item" href="#" onclick="filterByRole('All')">All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterByRole('User')">User</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterByRole('Admin')">Admin</a></li>
                </ul>
            </div>
            <!-- Add Account Button -->
            <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Add Account
            </button>
        </div>

       <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Account</h5>
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
                        <label for="userRole" class="form-label">Select Role</label>
                        <select class="form-select" id="userRole" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
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
                    <button type="submit" class="btn btn-dark">Add Account</button>
            </div>
        </div>
    </div>
</div>



            <!-- Search Bar -->
            <div class="input-group" style="width: 300px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
                <button class="btn btn-outline-secondary" type="button" onclick="searchTable()">Search</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mt-3 align-middle" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="action-column">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                <?php
    $users = [
        ['John Doe', 'user1@user.com', 'User'],
        ['John Did', 'admin1@admin.com', 'Admin'],
        ['John Done', 'user2@user.com', 'User'],
        ['John Dont', 'admin2@admin.com', 'Admin'],
        ['John Didnt', 'user3@user.com', 'User'],
        ['Mark Doe', 'admin3@admin.com', 'Admin'],
        ['Mark Did', 'user4@user.com', 'User'],
        ['Mark Done', 'admin4@admin.com', 'Admin'],
        ['Mark Dont', 'user5@user.com', 'User'],
        ['Mark Didnt', 'admin5@admin.com', 'Admin'],
    ];

    foreach ($users as $index => $user) {
        $id = $index + 1;
        $name = $user[0];
        $email = $user[1];
        $role = $user[2];
        echo "<tr>
            <td>$id</td>
            <td>$name</td>
            <td>$email</td>
            <td>$role</td>
            <td class='action-column'>
                <div class='action-buttons'>
                    <button class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#editUserModal' data-user-id='$id'>Edit</button>
                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteUserModal' data-user-id='$id'>Delete</button>
                </div>
            </td>
        </tr>";
    }
?>
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- Pagination numbers will be dynamically generated here -->
                </ul>
            </nav>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const rowsPerPage = 5;
        const table = document.getElementById('userTable');
        const tbody = table.querySelector('tbody');
        const rows = tbody.getElementsByTagName('tr');
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function paginate(direction) {
            currentPage += direction;
            currentPage = Math.max(1, Math.min(currentPage, totalPages));
            displayRows();
        }

        function goToPage(page) {
            currentPage = page;
            displayRows();
        }

        function displayRows() {
            // Display rows based on the current page
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = (i >= (currentPage - 1) * rowsPerPage && i < currentPage * rowsPerPage) ? '' : 'none';
            }
            updatePaginationControls();
        }

        function updatePaginationControls() {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        // Add "Previous" button
        const prevItem = document.createElement('li');
        prevItem.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
        prevItem.innerHTML = `<a class="page-link" href="#" onclick="paginate(-1)">&laquo;</a>`;
        pagination.appendChild(prevItem);

        // Add numbered page buttons
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('li');
            pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
            pageItem.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>`;
            pagination.appendChild(pageItem);
        }

        // Add "Next" button
        const nextItem = document.createElement('li');
        nextItem.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
        nextItem.innerHTML = `<a class="page-link" href="#" onclick="paginate(1)">&raquo;</a>`;
        pagination.appendChild(nextItem);
    }
        function filterByRole(role) {
            // Filter rows based on the selected role
            for (let i = 0; i < rows.length; i++) {
                const roleCell = rows[i].getElementsByTagName('td')[3]; // 4th column is Role
                rows[i].style.display = (role === 'All' || roleCell.textContent === role) ? '' : 'none';
            }
            updatePaginationControls(); // Update pagination after filtering
        }

        // Initial display of rows and pagination controls
        displayRows();
    </script>

</body>
</html>
