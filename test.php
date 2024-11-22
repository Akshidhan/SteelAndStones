<?php
include 'connect.php';

$userQuery = "SELECT * FROM users ORDER BY username ASC";
$users = $conn->query($userQuery);

$adminQuery = "SELECT * FROM admin ORDER BY username ASC";
$admins = $conn->query($adminQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/adminPage.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>User Management</h2>

    <!-- Users Section -->
    <div class="my-5">
        <h3>Customer Accounts</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">
                    Username 
                    <span class="sort-alpha-down" onclick="sortTable('users', 'username')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">Email</th>
                <th scope="col">Logged By Google</th>
                <th scope="col">Verified</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($users->num_rows > 0): ?>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= $row['googleLogin'] ? 'Yes' : 'No' ?></td>
                        <td><?= $row['account_activation_hash'] ? 'No' : 'Yes' ?></td>
                        <td>
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="btn btn-danger btn-sm" onclick="deleteRecord('user', <?= $row['userID'] ?>)">Delete</button></li>
                                <li>
                                    <button class="btn btn-primary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modifyModal" 
                                            data-type="user"
                                            data-id="<?= $row['userID'] ?>" 
                                            data-username="<?= $row['username'] ?>" 
                                            data-email="<?= $row['email'] ?>">
                                        Modify
                                    </button>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No Users Found!</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Admins Section -->
    <div class="my-5">
        <h3>Admin Accounts</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">
                    Username 
                    <span class="sort-icon" onclick="sortTable('admins', 'username')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">Password</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($admins->num_rows > 0): ?>
                <?php while ($row = $admins->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['password']) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="btn btn-danger btn-sm" onclick="deleteRecord('admin', <?= $row['adminID'] ?>)">Delete</button></li>
                                    <li>
                                        <button class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modifyModal" 
                                                data-type="admin"
                                                data-id="<?= $row['adminID'] ?>" 
                                                data-username="<?= $row['username'] ?>" 
                                                data-email="<?= $row['email'] ?>" >
                                            Modify
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            
                            

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No Users Found!</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modify Modal -->
<div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">Modify Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modifyForm">
                    <input type="hidden" id="recordType" name="type">
                    <input type="hidden" id="recordId" name="id">
                    <div class="mb-3">
                        <label for="modalUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="modalUsername" name="username">
                    </div>
                    <div class="mb-3" id="emailField">
                        <label for="modalEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modalEmail" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitModifyForm()">Save Changes</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>
