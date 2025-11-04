<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <style>
    body { background-color: #f8f9fa; }
    .profile-card {
      max-width: 500px;
      margin: 60px auto;
      border-radius: 15px;
      overflow: hidden;
    }
    .profile-header {
      background: linear-gradient(135deg, #ff4500, #ff7b00);
      color: white;
      text-align: center;
      padding: 40px 20px;
    }
    .profile-header img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid white;
      object-fit: cover;
    }
    .profile-body {
      background-color: white;
      padding: 25px;
    }
    .btn-edit {
      background-color: #ff4500;
      border: none;
    }
    .btn-edit:hover {
      background-color: #e03e00;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="row">
    <!-- LEFT SIDE: Profile -->
    <div class="col-md-4">
      <div class="card profile-card shadow-lg">
        <div class="profile-header">
          <img src="<?= $user['avatarPath'] ? htmlspecialchars($user['avatarPath']) : 'default-avatar.png' ?>" alt="User Avatar">
          <h3 class="mt-3"><?= htmlspecialchars($user['username']) ?></h3>
          <p class="text-white-50 mb-0"><?= htmlspecialchars($user['email']) ?></p>
        </div>
        <div class="profile-body">
          <h5>About Me</h5>
          <p><?= $user['bio'] ? nl2br(htmlspecialchars($user['bio'])) : 'No bio added yet.' ?></p>
          <hr>
          <p><strong>Joined:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
          <div class="d-flex justify-content-between mt-3">
            <?php if ($user['userID'] == $_SESSION['user_id'] || $_SESSION['role'] === 'admin'): ?>
              <a href="edit-user.php?id=<?= $user['userID'] ?>" class="btn btn-edit text-white">Edit Profile</a>
            <?php endif; ?> 
            <a href="logout.php" class="btn btn-outline-secondary">Log Out</a>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT SIDE: User Posts -->
    <div class="col-md-8">
      <h4 class="mb-3 mt-5"><?= htmlspecialchars($user['username']) ?>’s Posts</h4>
      <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
          <div class="card post-card shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-primary"><?= htmlspecialchars($post['title']) ?></h5>
              <p class="card-text"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?><?= strlen($post['content']) > 200 ? '...' : '' ?></p>
              <p class="mb-1"><strong>Module:</strong> <?= htmlspecialchars($post['moduleName']) ?></p>
              <small class="text-muted">Posted on <?= htmlspecialchars($post['dateCreated']) ?></small>
              <div class="mt-2">
                <a href="post_detail.php?id=<?= $post['postID'] ?>" class="btn btn-outline-primary btn-sm">View</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted">This user hasn’t posted anything yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>