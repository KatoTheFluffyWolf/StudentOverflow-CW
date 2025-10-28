<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($post['title']) ?> - StudentOverflow</title>
  <style>
    body { background-color: #dae0e6; font-family: Arial; }
    .post-card { background: white; border-radius: 10px; padding: 20px; }
    .comment-box { background: white; border-radius: 10px; padding: 15px; margin-top: 10px; }
    .btn-primary { background-color: #ff4500; border: none; }
    .btn-primary:hover { background-color: #e03e00; }
  </style>
</head>
<body>

<div class="container my-4">
  <a href="index.php" class="btn btn-link"><i class="fa-solid fa-arrow-left"></i> Back</a>

  <div class="post-card shadow-sm mb-4">
    <h3><?= htmlspecialchars($post['title']) ?></h3>
    <p class="text-muted small mb-3">Post ID: <?= $post['postID'] ?></p>
    <p><?= htmlspecialchars($post['content']) ?></p>

    <form method="POST" action="">
      <button type="submit" name="upvote"
              class="btn <?= $alreadyUpvoted ? 'btn-secondary' : 'btn-primary' ?>"
              <?= $alreadyUpvoted ? 'disabled' : '' ?>>
              <i class="fa-solid fa-thumbs-up"></i> Like
    </button>
    <span class="ms-2 text-dark"><?= $post['upvotes'] ?> people liked this question.</span>
    </form>
  </div>

  <h5>Comments</h5>
  <?php foreach ($comments as $c): ?>
    <div class="comment-box shadow-sm">
    <p class="mb-1">
        <strong><?= htmlspecialchars($c['username']) ?></strong>:
        <?= htmlspecialchars($c['content']) ?>
    </p>
    <small class="text-muted">Answered on <?= $c['created_at'] ?></small>
    </div>
  <?php endforeach; ?>

  <?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" class="mt-3">
      <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Write a comment..."></textarea>
      <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>
  <?php else: ?>
    <p><a href="login.php" class="btn btn-outline-primary">Log in to comment</a></p>
  <?php endif; ?>
</div>

</body>
</html>