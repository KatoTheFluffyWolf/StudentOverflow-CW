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
    .post-image { margin-top: 15px; border-radius: 8px; }
    .btn-primary:hover { background-color: #e03e00; }
  </style>
</head>
<body>

<div class="container my-4">
  <a href="index.php" class="btn btn-link"><i class="fa-solid fa-arrow-left"></i> Back</a>

  <div class="post-card shadow-sm mb-4">


    <div class="small text-muted mb-2">
            Posted by <strong><?= htmlspecialchars($post['username']) ?></strong> 
            in <span class="text-primary"><?= htmlspecialchars($post['moduleID'] . ' - ' . $post['moduleName']) ?></span>
    </div>  
    <p class="text-muted small mb-2">Post ID: <?= $post['postID'] ?></p>
    <h3><?= htmlspecialchars($post['title']) ?></h3>
    <p><?= htmlspecialchars($post['content']) ?></p>


     <!-- Buttons visible only for author -->
   <!-- Buttons only for author -->
  <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['userID']): ?>
    <div class="d-flex gap-2 mb-2">
      <button type="button" id="editBtn" class="btn btn-dark">Edit</button>
      <form method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
      </form>
    </div>

    <!-- Hidden edit form -->
    <form method="POST" id="editForm" style="display: none;" enctype="multipart/form-data">
      <input type="text" name="edited_title" class="form-control mb-2"
        value="<?= htmlspecialchars($post['title']) ?>" required>

      <textarea name="edited_content" class="form-control mb-2" rows="4"><?= htmlspecialchars($post['content']) ?></textarea>
      
    <!-- Image upload field -->
    <div class="mb-3">
      <label for="edited_image" class="form-label fw-semibold">Change Image</label>
      <input type="file" name="edited_image" class="form-control" accept="image/*">
      <?php if (!empty($post['imgPath'])): ?>
        <p class="mt-2 small text-muted">Current Image:</p>
        <img src="<?= htmlspecialchars($post['imgPath']) ?>" alt="Current Image" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: cover;">
      <?php endif; ?>
    </div>


      <button type="submit" name="edit" class="btn btn-dark btn-sm mb-3">Save Changes</button>
      <button type="button" id="cancelBtn" class="btn btn-secondary btn-sm mb-3">Cancel</button>
    </form>
  <?php endif; ?>


    <?php if ($post['imgPath']): ?>
      <img src="<?= htmlspecialchars($post['imgPath']) ?>" alt="Post Image" class="post-image img-fluid mb-3">
    <?php endif; ?>

      <!-- Show Edit/Delete only for author -->

    <form method="POST" action="">
      <button type="submit" name="upvote"
              class="btn <?= $alreadyUpvoted ? 'btn-secondary' : 'btn-primary' ?>"
              <?= $alreadyUpvoted ? 'disabled' : '' ?>>
              <i class="fa-solid fa-thumbs-up"></i> Like
    </button>
    <span class="ms-2 text-dark"><?= $post['upvotes'] ?> people liked this question.</span>
    </form>
  </div>


 <!-- Comments Section -->
  <h5>Comments</h5>
  <?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" class="mt-2" enctype="multipart/form-data">
      <textarea name="comment" class="form-control mb-2" rows="5" placeholder="Write a comment..."></textarea>
      <input type="file" name="commentImage" class="form-control mb-2">
      <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>
  <?php else: ?>
    <p><a href="login.php" class="btn btn-outline-primary">Log in to comment</a></p>
  <?php endif; ?>

  <?php foreach ($comments as $c): ?>
  <div class="comment-box shadow-sm p-3 mb-3 bg-white rounded">
    <small class="text-muted">Answered on <?= htmlspecialchars($c['created_at']) ?></small>

    <!-- 👇 Entire visible comment section -->
    <div id="comment-display-<?= $c['commentID'] ?>">
      <p class="mb-1">
        <strong><?= htmlspecialchars($c['username']) ?></strong>:
        <?= nl2br(htmlspecialchars($c['content'])) ?>
      </p>

      <?php if (!empty($c['imgPath'])): ?>
        <img src="<?= htmlspecialchars($c['imgPath']) ?>" 
             alt="Comment Image"
             class="img-fluid rounded mb-2"
             style="max-height: 250px; object-fit: cover;">
      <?php endif; ?>
    </div>

    <!-- 👇 Author-only controls -->
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $c['userID']): ?>
      <div class="d-flex gap-2 mb-2">
        <button type="button" class="btn btn-sm btn-dark" onclick="showEditForm(<?= $c['commentID'] ?>)">Edit</button>
        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this comment?');">
          <input type="hidden" name="delete_comment_id" value="<?= $c['commentID'] ?>">
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>

      <!-- 👇 Hidden edit form -->
      <form method="POST" id="edit-form-<?= $c['commentID'] ?>" 
            enctype="multipart/form-data"
            class="edit-form" style="display: none;">
        <textarea name="edited_comment" class="form-control mb-2" rows="3"><?= htmlspecialchars($c['content']) ?></textarea>

        <label for="edited_comment_image_<?= $c['commentID'] ?>" class="form-label fw-semibold">Change Image (optional)</label>
        <input type="file" name="edited_comment_image" id="edited_comment_image_<?= $c['commentID'] ?>" 
               class="form-control mb-2" accept="image/*">

        <input type="hidden" name="edit_comment_id" value="<?= $c['commentID'] ?>">
        <button type="submit" class="btn btn-sm btn-success">Save</button>
        <button type="button" class="btn btn-sm btn-secondary" onclick="cancelEdit(<?= $c['commentID'] ?>)">Cancel</button>
      </form>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>

</body>
</html>
<script>
  // JS to toggle edit mode
  const editBtn = document.getElementById('editBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const editForm = document.getElementById('editForm');
  const postContent = document.getElementById('post-content');
  const postTitle = document.getElementById('post-title');

  if (editBtn) {
    editBtn.addEventListener('click', () => {
      editForm.style.display = 'block';
      postContent.style.display = 'none';
      postTitle.style.display = 'none';
      editBtn.style.display = 'none';
    });
  }

  if (cancelBtn) {
    cancelBtn.addEventListener('click', () => {
      editForm.style.display = 'none';
      postContent.style.display = 'block';
      postTitle.style.display = 'block';
      editBtn.style.display = 'inline-block';
    });
  }
  function showEditForm(id) {
  document.getElementById('edit-form-' + id).style.display = 'block';
  document.getElementById('comment-content-' + id).style.display = 'none';
}

function cancelEdit(id) {
  document.getElementById('edit-form-' + id).style.display = 'none';
  document.getElementById('comment-content-' + id).style.display = 'block';
}
</script>