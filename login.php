<?php include 'nav-bar.php'; ?>
<?php
// login.php
include 'config.php';
try {
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $userQuery = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($userQuery);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Successful login
        $_SESSION['user_id'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];

        header("Location: index.php");
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
<?php include 'templates/login.html.php'; ?>
