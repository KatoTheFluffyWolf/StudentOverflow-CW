<?php
include 'nav-bar.php';
include 'config.php';

$pdo = new PDO($dsn, $DB_USER, $DB_PASS);

if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit();
}

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
    p.postID, p.title, p.content, u.username, m.moduleName, p.moduleID,
    COUNT(v.voteID) AS upvotes
  FROM posts p
  JOIN users u ON p.userID = u.userID
  JOIN modules m ON p.moduleID = m.moduleID
  LEFT JOIN post_upvotes v ON p.postID = v.postID
  WHERE p.postID = :id
  GROUP BY p.postID
");
$postQuery->execute([':id' => $postID]);
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

// Handle new comment
if (isset($_POST['comment']) && isset($_SESSION['user_id'])) {
  $commentContent = $_POST['comment'];
  if ($commentContent !== '') {
    $insertCmt = $pdo->prepare("INSERT INTO post_comments (postID, userID, content, created_at) VALUES (:pid, :uid, :content, NOW())");
    $insertCmt->bindValue(':pid', $postID);
    $insertCmt->bindValue(':uid', $_SESSION['user_id']);
    $insertCmt->bindValue(':content', $commentContent);
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
?>
<?php include 'templates/post_detail.html.php'; ?>
