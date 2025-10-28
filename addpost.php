<?php include 'nav-bar.php'; ?>
<?php 
include 'config.php';
try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $userQuery = "SELECT * FROM modules";
    $stmt = $pdo->prepare($userQuery);
    $stmt->execute();
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $userID = $_SESSION['user_id'];
        $moduleID = $_POST['module'];

        // Insert new post
        $addPostQuery = "INSERT INTO posts (title, content, userID, moduleID)
                         VALUES (:title, :content, :userID, :moduleID)";
        $addPostsSmt = $pdo->prepare($addPostQuery);
        $addPostsSmt->bindValue(':title', $title);
        $addPostsSmt->bindValue(':content', $content);
        $addPostsSmt->bindValue(':userID', $userID);
        $addPostsSmt->bindValue(':moduleID', $moduleID);
        $addPostsSmt->execute();

        $message = "✅ Post added successfully!";
    }

} catch (PDOException $e){
    $output = "Unable to connect to the database server: " . $e; 
}
?>

<?php include 'templates/addpost.html.php'; ?>

