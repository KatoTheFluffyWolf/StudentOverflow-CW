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

        if (isset($_FILES['image'])) {
            // Path to the folder to save file 
            $targetDir = "uploads/";
            $uuid = bin2hex(random_bytes(16));
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $targetFile = $targetDir . $uuid . '.' . $fileType;

            // Check if the file already exists
            

            //check file type in 
            $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                $message = "Upload failed.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    // File uploaded successfully
                } else {
                    $message = "Sorry, there was an error uploading your file.";
                }
            }
        }





        // Insert new post
        $addPostQuery = "INSERT INTO posts (title, content, userID, moduleID, dateCreated, imgPath)
                         VALUES (:title, :content, :userID, :moduleID, NOW(), :imgPath)";
        $addPostsSmt = $pdo->prepare($addPostQuery);
        $addPostsSmt->bindValue(':title', $title);
        $addPostsSmt->bindValue(':content', $content);
        $addPostsSmt->bindValue(':userID', $userID);
        $addPostsSmt->bindValue(':moduleID', $moduleID);
        $addPostsSmt->bindValue(':imgPath', $targetFile ?? null);
        $addPostsSmt->execute();

        $message = "✅ Post added successfully!";
    }


} catch (PDOException $e){
    $output = "Unable to connect to the database server: " . $e; 
}
?>

<?php include 'templates/addpost.html.php'; ?>

