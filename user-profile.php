<?php
include 'nav-bar.php';
include 'config.php';


// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//Determine which profile to show
if (isset($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin' && $_GET['id'] != $_SESSION['user_id']) {
    // Admin viewing another user's profile
    $userID = (int) $_GET['id'];
} else {
    // Regular user (or admin viewing own profile)
    $userID = $_SESSION['user_id'];
}

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT userID, username, email, bio, created_at, avatarPath FROM users WHERE userID = :id");
    $stmt->bindValue(':id', $userID);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

     $postStmt = $pdo->prepare("
        SELECT p.postID, p.title, p.content, p.dateCreated, m.moduleName
        FROM posts p
        LEFT JOIN modules m ON p.moduleID = m.moduleID
        WHERE p.userID = :id
        ORDER BY p.dateCreated DESC
    ");
    $postStmt->bindValue(':id', $userID);
    $postStmt->execute();
    $posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<?php include 'templates/user-profile.html.php'; ?>