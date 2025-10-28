<?php
include 'nav-bar.php';
include 'config.php';


try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle upvote click
    if (isset($_POST['upvote'])) {
        $postID = (int) $_POST['post_id'];
        $userID = $_SESSION['user_id'];

        // Insert only if this user hasn't upvoted this post
        $check = $pdo->prepare("SELECT 1 FROM post_upvotes WHERE userID = :userID AND postID = :postID");
        $check->execute([':userID' => $userID, ':postID' => $postID]);

        if ($check->rowCount() === 0) {
            $insert = $pdo->prepare("INSERT INTO post_upvotes (userID, postID) VALUES (:userID, :postID)");
            $insert->bindValue(':userID', $userID);
            $insert->bindValue(':postID', $postID);
            $insert->execute();
        }
    }

    // Fetch all posts with upvote counts
    $sql = "SELECT p.postID, p.title, p.content, u.username, m.moduleName, p.moduleID,
                   COUNT(v.voteID) AS upvotes
            FROM posts p
            JOIN users u ON p.userID = u.userID
            JOIN modules m ON p.moduleID = m.moduleID
            LEFT JOIN post_upvotes v ON p.postID = v.postID
            GROUP BY p.postID
            ORDER BY p.postID DESC";
    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('DB Error: ' . $e->getMessage());
}
?>
<?php include 'templates/index.html.php'; ?>