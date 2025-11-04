<?php
include 'nav-bar.php';
include 'config.php';

$pdo = new PDO($dsn, $DB_USER, $DB_PASS);

$postID = (int) $_GET['id'];

// Handle upvote before fetching post
if (isset($_POST['upvote']) && isset($_SESSION['user_id'])) {
  $uid = $_SESSION['user_id'];

  $check = $pdo->prepare("SELECT 1 FROM post_upvotes WHERE userID = :uid AND postID = :pid");
  $check->bindValue(':uid', $uid);
  $check->bindValue(':pid', $postID);
  $check->execute();

  if ($check->rowCount() == 0) {
    $insert = $pdo->prepare("INSERT INTO post_upvotes (userID, postID) VALUES (:uid, :pid)");
    $insert->bindValue(':uid', $uid);
    $insert->bindValue(':pid', $postID);
    $insert->execute();
  }

  header("Location: post_detail.php?id=$postID");
  exit();
}



// Fetch post
$postQuery = $pdo->prepare("
  SELECT 
    p.postID, p.userID, p.title, p.content, u.username, m.moduleName, p.moduleID, p.imgPath, p.dateCreated,
    COUNT(v.voteID) AS upvotes
  FROM posts p
  JOIN users u ON p.userID = u.userID
  JOIN modules m ON p.moduleID = m.moduleID
  LEFT JOIN post_upvotes v ON p.postID = v.postID
  WHERE p.postID = :id
  GROUP BY p.postID
");
$postQuery->bindValue(':id', $postID);
$postQuery->execute();
$post = $postQuery->fetch(PDO::FETCH_ASSOC);

// Check if already upvoted
$alreadyUpvoted = false;
if (isset($_SESSION['user_id'])) {
  $check = $pdo->prepare("SELECT 1 FROM post_upvotes WHERE userID = :uid AND postID = :pid");
  $check->bindValue(':uid', $_SESSION['user_id']);
  $check->bindValue(':pid', $postID);
  $check->execute();
  $alreadyUpvoted = $check->rowCount() > 0;
}
//Handle delete
if (isset($_POST['delete']) && isset($_SESSION['user_id'])) {

if (!empty($post['imgPath']) && file_exists($post['imgPath'])) {
    unlink($post['imgPath']); // 🗑️ Delete the image file
  }


  
  $delete = $pdo->prepare("DELETE FROM posts WHERE postID = :pid AND userID = :uid");
  $delete-> bindValue(':pid', $postID);
  $delete-> bindValue(':uid', $_SESSION['user_id']);
  $delete->execute();



  header("Location: index.php"); // back to main page
  exit();
}

// Handle edit (title + content + image)
if (isset($_POST['edit']) && isset($_SESSION['user_id'])) {
  $newTitle = $_POST['edited_title'];
  $newContent = $_POST['edited_content'];
  $targetFile = $post['imgPath']; // keep old image by default

  //If user uploaded a new image
  if (isset($_FILES['edited_image'])) {
    $targetDir = "uploads/";

    $uuid = bin2hex(random_bytes(16));
    $fileType = strtolower(pathinfo($_FILES["edited_image"]["name"], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
      $targetFile = $targetDir . $uuid . '.' . $fileType;
      move_uploaded_file($_FILES["edited_image"]["tmp_name"], $targetFile);

       if (!empty($post['imgPath']) && file_exists($post['imgPath'])) {
        unlink($post['imgPath']);
       }
    }
  }

  if ($newTitle !== '' && $newContent !== '') {
    $update = $pdo->prepare("UPDATE posts 
                             SET title = :title, content = :content, imgPath = :imgPath 
                             WHERE postID = :pid AND userID = :uid");

    $update->bindValue(':title', $newTitle);
    $update->bindValue(':content', $newContent);
    $update->bindValue(':imgPath', $targetFile);
    $update->bindValue(':pid', $postID);
    $update->bindValue(':uid', $_SESSION['user_id']);
    $update->execute();
  }

  header("Location: post_detail.php?id=$postID");
  exit();
}
// Handle new comment
if (isset($_POST['comment'])) {
  $commentContent = trim($_POST['comment']);
  $targetFile = null;

  if (isset($_FILES['commentImage'])) {
    $targetDir = "uploads/";

    $unique_id = uniqid();
    $fileType = strtolower(pathinfo($_FILES["commentImage"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . $unique_id . '.' . $fileType;
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
      move_uploaded_file($_FILES["commentImage"]["tmp_name"], $targetFile);
    } else {
      $targetFile = null;
    }
  }

  // Insert comment (with or without image)
  if ($commentContent !== '' || $targetFile !== null) {
    $insertCmt = $pdo->prepare("
      INSERT INTO post_comments (postID, userID, content, imgPath, created_at)
      VALUES (:pid, :uid, :content, :imgPath, NOW())
    ");
    $insertCmt->bindValue(':pid', $postID);
    $insertCmt->bindValue(':uid', $_SESSION['user_id']);
    $insertCmt->bindValue(':content', $commentContent);
    $insertCmt->bindValue(':imgPath', $targetFile);
    $insertCmt->execute();
  }

  header("Location: post_detail.php?id=$postID");
  exit();
}
// Get comments
$cmtQuery = $pdo->prepare("
  SELECT c.*, u.username 
  FROM post_comments c
  JOIN users u ON c.userID = u.userID
  WHERE c.postID = :postID
  ORDER BY c.created_at DESC
");
$cmtQuery->execute([':postID' => $postID]);
$comments = $cmtQuery->fetchAll(PDO::FETCH_ASSOC);

// Handle comment deletion
if (isset($_POST['delete_comment_id']) && isset($_SESSION['user_id'])) {
  $commentID = (int) $_POST['delete_comment_id'];

  if ((!empty($c['imgPath']) && file_exists($c['imgPath']))) {
    unlink($c['imgPath']); 
  }

  $delete = $pdo->prepare("DELETE FROM post_comments WHERE commentID = :cid AND userID = :uid");
  $delte->bindValue(':cid', $commentID);
  $delete->bindValue(':uid', $_SESSION['user_id']);
  $delete->execute();
  header("Location: post_detail.php?id=$postID");
  exit();
}

// Handle comment edit
if (isset($_POST['edit_comment_id']) && isset($_SESSION['user_id'])) {
  $commentID = (int) $_POST['edit_comment_id'];
  $newText = trim($_POST['edited_comment']);

  if ($newText !== '') {
    $update = $pdo->prepare("UPDATE post_comments SET content = :content WHERE commentID = :cid AND userID = :uid");
    $update->bindValue(':content', $newText);
    $update->bindValue(':cid', $commentID);
    $update->bindValue(':uid', $_SESSION['user_id']);
    $update->execute();
  }
  header("Location: post_detail.php?id=$postID");
  exit();
}


?>
<?php include 'templates/post_detail.html.php'; ?>
