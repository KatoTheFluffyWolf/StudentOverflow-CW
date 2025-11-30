<?php
include 'config.php'; // contains $dsn, $DB_USER, $DB_PASS
include 'nav-bar.php';

// Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

$errors = [];
$success = '';

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_id'])) {
            // Handle delete user
            $deleteId = (int) $_POST['delete_id'];
            
            //Delete upvotes associated with the user
            $upvoteDeleteStmt = $pdo->prepare("DELETE FROM post_upvotes WHERE userID = :id");
            $upvoteDeleteStmt->bindValue(':id', $deleteId);
            $upvoteDeleteStmt->execute();

            //Unlink posts' images associated with the user
            $imgSelectStmt = $pdo->prepare("SELECT imgPath FROM posts WHERE userID = :id");
            $imgSelectStmt->bindValue(':id', $deleteId);
            $imgSelectStmt->execute();
            $images = $imgSelectStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($images as $img) {
                if (!empty($img['imgPath']) && file_exists($img['imgPath'])) {
                    unlink($img['imgPath']); // Delete the image file
                }
            }

            //Delete posts associated with the user
            $postDeleteStmt = $pdo->prepare("DELETE FROM posts WHERE userID = :id");
            $postDeleteStmt->bindValue(':id', $deleteId);
            $postDeleteStmt->execute();

            //Delete Comments associated with the user
            $commentDeleteStmt = $pdo->prepare("DELETE FROM post_comments WHERE userID = :id");
            $commentDeleteStmt->bindValue(':id', $deleteId);
            $commentDeleteStmt->execute();

            //unlink profile image if any
            $profileImgStmt = $pdo->prepare("SELECT avatarPath FROM users WHERE userID = :id");
            $profileImgStmt->bindValue(':id', $deleteId);  
            $profileImgStmt->execute();
            $profileImg = $profileImgStmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($profileImg['avatarPath']) && file_exists($profileImg['avatarPath'])) {
                unlink($profileImg['avatarPath']); // Delete the profile image file
            }
            // Finally, delete the user
            $deleteStmt = $pdo->prepare("DELETE FROM users WHERE userID = :id");
            $deleteStmt->bindValue(':id', $deleteId);
            $deleteStmt->execute();

            // Prevent form resubmission on refresh
            header('Location: ' . $_SERVER['PHP_SELF'] . '?deleted=1');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? '';

        // Basic validation
        if ($username === '' || $name === '' || $email === '' || $password === '' || $role === '') {
            $errors[] = 'All fields are required.';
        } else {
            // check for existing username or email
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $checkStmt->bindValue(':username', $username);
            $checkStmt->bindValue(':email', $email);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                $errors[] = 'Username or email already exists.';
            }
        }

        if (empty($errors)) {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insertStmt = $pdo->prepare(
                "INSERT INTO users (username, name, email, password, role)
                 VALUES (:username, :name, :email, :password, :role)"
            );
            $insertStmt->bindValue(':username', $username);
            $insertStmt->bindValue(':name', $name);
            $insertStmt->bindValue(':email', $email);
            $insertStmt->bindValue(':password', $hashedPassword);
            $insertStmt->bindValue(':role', $role);
            $insertStmt->execute();

            // Prevent form resubmission on refresh
            header('Location: ' . $_SERVER['PHP_SELF'] . '?added=1');
            exit;
        }
    }

    // Optional success message if redirected after add
    if (isset($_GET['added']) && $_GET['added'] == 1) {
        $success = 'User added successfully.';
    }

    // ---------- FETCH USERS FOR DISPLAY ----------
    $stmt = $pdo->query("SELECT userID, username, name, email, role FROM users ORDER BY userID DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Now $users, $errors, and $success are available in the template
?>
<?php include 'templates/manage_users.html.php'; ?>
