<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Newsfeed</title>
  <style>
    body { background-color: #dae0e6; font-family: Arial; }

    a.card-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }

    .card {
      margin: 15px auto;
      max-width: 80vw;
      border-radius: 10px;
      transition: transform 0.1s ease, box-shadow 0.1s ease;
    }

    .card:hover {
      transform: scale(1.01);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
      background-color: #ff4500;
      border: none;
    }
    .btn-primary:hover {
      background-color: #e03e00;
    }

    .text-primary {
      color: #ff4500 !important;
    }
  </style>
</head>
<body>

<div class="container my-4">
  <h2 class="text-center mb-4">Latest Questions</h2>

  <?php foreach ($posts as $p): ?>
    <?php
      // Check if the current user already upvoted this post
      $check = $pdo->prepare("SELECT 1 FROM post_upvotes WHERE userID = :uid AND postID = :pid");
      $check->execute([':uid' => $_SESSION['user_id'], ':pid' => $p['postID']]);
      $alreadyUpvoted = $check->rowCount() > 0;
    ?>

    <a href="post_detail.php?id=<?= $p['postID'] ?>" class="card-link">
      <div class="card shadow">
        <div class="card-body">
          <div class="small text-muted mb-2">
            Posted by <strong><?= htmlspecialchars($p['username']) ?></strong> 
            in <span class="text-primary"><?= htmlspecialchars($p['moduleID'] . ' - ' . $p['moduleName']) ?></span>
          </div>

          <h4><?= htmlspecialchars($p['title']) ?></h4>
          <p>
            <?= htmlspecialchars(strlen($p['content']) > 150 
                ? substr($p['content'], 0, 150) . '...' 
                : $p['content']) ?>
          </p>
          
          <?php if ($p['imgPath']): ?>
          <img src="<?= htmlspecialchars($p['imgPath']) ?>" alt="Post Image" class="post-image img-fluid">
          <?php endif; ?>

          <!-- Upvote button INSIDE card -->
          <form method="POST" action="" class="d-inline-block mt-2">
            <input type="hidden" name="post_id" value="<?= $p['postID'] ?>">
            <button type="submit" name="upvote"
              class="btn <?= $alreadyUpvoted ? 'btn-secondary' : 'btn-primary' ?>"
              <?= $alreadyUpvoted ? 'disabled' : '' ?>>
              <i class="fa-solid fa-thumbs-up"></i>
            </button>
            <span class="ms-2 text-dark"><?= $p['upvotes'] ?> people liked this question.</span>
          </form>

        </div>
      </div>
    </a>
  <?php endforeach; ?>
</div>

</body>
</html>
