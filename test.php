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
                    <span class="sort-icon" onclick="sortTable('users', 'username')">🔼</span>
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
                        <td><?= $row['account_activation_hash'] ? 'Yes' : 'No' ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteRecord('user', <?= $row['adminID'] ?>)">Delete</button>
                            <button class="btn btn-primary btn-sm" onclick="showModifyModal('user', <?= $row['userID'] ?>)">Modify</button>
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
                    <span class="sort-icon" onclick="sortTable('admins', 'username')">🔼</span>
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
                            <button class="btn btn-danger btn-sm" onclick="deleteRecord('admin', <?= $row['adminID'] ?>)">Delete</button>
                            <button class="btn btn-primary btn-sm" onclick="showModifyModal('admin', <?= $row['adminID'] ?>)">Modify</button>
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
            <form id="modifyForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">Modify User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="recordType" name="recordType">
                    <input type="hidden" id="recordID" name="recordID">
                    <div class="mb-3">
                        <label for="modifyUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="modifyUsername" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="modifyEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modifyEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="modifyPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="modifyPassword" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
