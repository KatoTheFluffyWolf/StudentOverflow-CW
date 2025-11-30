<?php
include 'nav-bar.php';
include 'config.php';

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Load modules for the select
    $stmt = $pdo->prepare("SELECT * FROM modules");
    $stmt->execute();
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title    = $_POST['title'];
        $content  = $_POST['content'];
        $userID   = $_SESSION['user_id'];
        $moduleID = $_POST['module'];

        // Default: no image
        $imgPath = null;

        // --- IMAGE HANDLING ---
        if (isset($_FILES['image'])) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            // Check if file type is allowed
            if (in_array($fileType, $allowedTypes)) {
                // Generate unique filename
                $unique_id = uniqid();
                $newFileName = $targetDir . $unique_id . '.' . $fileType;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $newFileName)) {
                    $imgPath = $newFileName;
                }
            }
            else {
                // Invalid file type, ignore the upload
                $imgPath = null;
            }
                
        }

        // Insert post (imgPath may be NULL)
        $sql = "INSERT INTO posts (title, content, userID, moduleID, dateCreated, imgPath)
                VALUES (:title, :content, :userID, :moduleID, NOW(), :imgPath)";
        $st = $pdo->prepare($sql);
        $st->bindValue(':title', $title);
        $content === '' ? $st->bindValue(':content', null)
                        : $st->bindValue(':content', $content);
        $st->bindValue(':userID', $userID);
        $st->bindValue(':moduleID', $moduleID);
        $imgPath === null ? $st->bindValue(':imgPath', null)
                          : $st->bindValue(':imgPath', $imgPath);
        $st->execute();

        $message = $message ?? "Post added successfully!";
    }
} catch (PDOException $e) {
    $message = "DB error: " . $e->getMessage();
}

include 'templates/addpost.html.php';
