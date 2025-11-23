<?php include 'nav-bar.php'; ?>
<?php
// login.php
include 'config.php';

try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password']; 

        $pdo = new PDO($dsn, $DB_USER, $DB_PASS);

        // 1. Get user by username only
        $userQuery = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($userQuery);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id']  = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            $_SESSION['email']    = $user['email'];

            header("Location: index.php");
            exit();
        } else {
            // Invalid credentials
            $error = "Invalid username or password.";
        }
    }
} catch (PDOException $e) {
    $output = "Unable to connect to the database server: " . $e->getMessage();
}
?>
<?php include 'templates/login.html.php'; ?>
