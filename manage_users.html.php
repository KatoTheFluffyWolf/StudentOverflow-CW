<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 12px; }
  </style>
</head>
<body>

<div class="container mt-5">
  <!-- TITLE + ADD USER BUTTON ROW -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage Users</h2>
    <!-- Modal trigger button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
      + Add User
    </button>
  </div>

  <div class="row g-4">
    <?php if (count($users) > 0): ?>
      <?php foreach ($users as $user): ?>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-primary"><?= htmlspecialchars($user['username']) ?></h5>
              <p class="card-text mb-1"><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
              <p class="card-text mb-1"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
              <p class="card-text mb-1"><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
              <a href="user-profile.php?id=<?= $user['userID'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $user['userID'] ?>">
                <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete this user?')">Delete</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">No users found.</p>
    <?php endif; ?>
  </div>
</div>

<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
              <option value="student">Student</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save User</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
