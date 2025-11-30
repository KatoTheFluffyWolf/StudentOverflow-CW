<?php
include 'config.php';
include 'nav-bar.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['role'] != 'admin' && $_SESSION['user_id'] != $_GET['id']) { //not admin nor self
    die("Unauthorized access.");
}

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Determine which user profile is being edited
    if (isset($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin' && $_GET['id'] != $_SESSION['user_id']) {
        $userID = $_GET['id']; // Admin editing another user
    } else {
        $userID = $_SESSION['user_id']; // Normal user editing own profile
    }

    // Fetch user info
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = :id");
    $stmt->bindValue(':id', $userID);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        // Only admin or self can delete
        if ($_SESSION['role'] == 'admin' || $_SESSION['user_id'] == $userID) {
            // Delete avatar file if exists
            if (!empty($user['avatarPath']) && file_exists($user['avatarPath'])) {
                unlink($user['avatarPath']);
            }
            // Unlink user's posts' images
            $imgStmt = $pdo->prepare("SELECT imgPath FROM posts WHERE userID = :id");
            $imgStmt->bindValue(':id', $userID);
            $imgStmt->execute();
            $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($images as $img) {
                if (!empty($img['imgPath']) && file_exists($img['imgPath'])) {
                    unlink($img['imgPath']);
                }
            }
            
            // Delete user's comments
            $delcomments = $pdo->prepare("DELETE FROM post_comments WHERE userID = :id");
            $delcomments->bindValue(':id', $userID);
            $delcomments->execute();
            // Delete user's upvotes
            $delupvotes = $pdo->prepare("DELETE FROM post_upvotes WHERE userID = :id");
            $delupvotes->bindValue(':id', $userID);
            $delupvotes->execute();
            // Delete their posts too
            $delpost = $pdo->prepare("DELETE FROM posts WHERE userID = :id");
            $delpost->bindValue(':id', $userID);
            $delpost->execute();

            // Delete user from database
            $del = $pdo->prepare("DELETE FROM users WHERE userID = :id");
            $del->bindValue(':id', $userID, PDO::PARAM_INT);
            $del->execute();

            // If user deleted themselves, end session
            if ($_SESSION['user_id'] == $userID) {
                session_destroy();
                header("Location: login.php?msg=account_deleted");
                exit();
            } else {
                header("Location: manage-users.php?msg=user_deleted");
                exit();
            }
        } else {
            die("Unauthorized deletion attempt.");
        }
    }
    elseif (isset($_POST['save'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];
        $fullname = $_POST['fullname'];
        $passwordSQL = '';
        $error = '';
        $success = '';

        // Check if email is already used by another account
        $checkEmail = $pdo->prepare("SELECT userID FROM users WHERE email = :email AND userID != :id");
        $checkEmail->bindValue(':email', $email);
        $checkEmail->bindValue(':id', $userID);
        $checkEmail->execute();
        if ($checkEmail->fetch()) {
            $error = "This email is already in use by another account.";
        } else {
            // Handle new password if provided
            if (!empty($_POST['new_password'])) {
                $hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $passwordSQL = ", password = :password";
            }

            // Handle avatar upload if provided
            $avatarPath = $user['avatarPath'];
            if (!empty($_FILES['avatarPath']['name'])) {
                $uploadDir = 'uploads/avatars/';
                $unique_id = uniqid();

                $fileTmp = $_FILES['avatarPath']['tmp_name'];
                $fileName = $unique_id . '_' . basename($_FILES['avatarPath']['name']);
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $targetFile = $uploadDir . $fileName;

                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($fileType, $allowedTypes)) {
                    move_uploaded_file($fileTmp, $targetFile);
                    $avatarPath = $targetFile;
                } else {
                    $error = "Only JPG, PNG, and GIF files are allowed.";
                }
            }

            if (empty($error)) {
                // Update user info in the database
                $update = $pdo->prepare("
                    UPDATE users 
                    SET username = :username, email = :email, name = :name, bio = :bio, avatarPath = :avatar
                    $passwordSQL
                    WHERE userID = :id
                ");
                $update->bindValue(':username', $username);
                $update->bindValue(':email', $email);
                $update->bindValue(':name', $fullname);
                $update->bindValue(':bio', $bio);
                $update->bindValue(':avatar', $avatarPath);
                $update->bindValue(':id', $userID);
                if ($passwordSQL) {
                    $update->bindValue(':password', $hashedPassword);
                }
                $update->execute();

                $success = "Profile updated successfully!";

                // Refresh user data
                $stmt = $pdo->prepare("SELECT username, email, bio, avatarPath FROM users WHERE userID = :id");
                $stmt->bindValue(':id', $userID);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
}
    

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<?php include 'templates/edit-user.html.php'; ?>
