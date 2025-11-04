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
  <h2 class="text-center mb-4">Manage Users</h2>

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
              <a href="delete-user.php?id=<?= $user['userID'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">No users found.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>