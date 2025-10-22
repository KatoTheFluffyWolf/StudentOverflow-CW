<?php
// login.php
include 'config.php';
session_start();
try {
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $userQuery = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($userQuery);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.html.php");
        exit();
    } else {
        // Invalid credentials
        $error = "Invalid username or password.";
    }
}
}
catch (PDOException $e){
    $output = "Unable to connect to the database server: " . $e; 
}
?>