<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <style>
    body { background-color: #f8f9fa; }
    .edit-card {
      max-width: 600px;
      margin: 60px auto;
      border-radius: 15px;
      overflow: hidden;
    }
    .btn-save {
      background-color: #ff4500;
      border: none;
    }
    .btn-save:hover {
      background-color: #e03e00;
    }
  </style>
</head>
<body>

<div class="card edit-card shadow-lg">
  <div class="card-header bg-dark text-white text-center">
    <h4>Edit Profile</h4>
  </div>
  <div class="card-body">
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif (isset($success)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" id="editForm">
      <div class="mb-3 text-center">
        <img src="<?= $user['avatarPath'] ? htmlspecialchars($user['avatarPath']) : 'default-avatar.png' ?>" 
             class="rounded-circle mb-2" width="120" height="120" style="object-fit:cover;">
        <input type="file" name="avatar" class="form-control mt-2">
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($user['username']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="new_password" class="form-control" placeholder="Leave blank to keep current password">
    </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Bio</label>
        <textarea name="bio" class="form-control" rows="4"><?= htmlspecialchars($user['bio']) ?></textarea>
      </div>
      </form>

      
      <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex gap-2 align-items-center">
          <a href="user-profile.php<?= ($_SESSION['role'] == 'admin' && $userID != $_SESSION['user_id']) ? '?id=' . $userID : '' ?>" 
            class="btn btn-secondary">Cancel</a>

          <?php if ($_SESSION['role'] == 'admin' || $userID == $_SESSION['user_id']): ?>
            <form method="POST" id="deleteForm" class="m-0 d-inline"
                  onsubmit="return confirm('⚠️ Are you sure you want to delete this user? This action cannot be undone.');">
              <input type="hidden" name="delete_user" value="1">
              <button type="submit" class="btn btn-danger">Delete User</button>
            </form>
          <?php endif; ?>
        </div>

        <!-- Save button submits the form above -->
        <button type="submit" class="btn btn-save text-white" form="editForm" name="save" value="1">
          Save Changes
        </button>
      </div>

  </div>
</div>

</body>
</html>