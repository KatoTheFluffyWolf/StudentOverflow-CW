<?php include 'nav-bar.php'; ?>
<?php
// login.php
include 'config.php';
try {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmed_password = $_POST['confirmed-password'];
        $email = $_POST['email'];

        if ($password !== $confirmed_password) {
            $error = "Passwords do not match.";
        } else {
            $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
            $CheckUserQuery = "SELECT * FROM users WHERE username = :username";
            $stmt = $pdo->prepare($CheckUserQuery);
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            $exist_user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($exist_user) {
                $error = "Username already taken. Please choose another.";
            } else {
                $InsertUserQuery = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'student')";
                $stmt = $pdo->prepare($InsertUserQuery);
                $stmt->bindValue(':username', $username);
                $stmt->bindValue(':password', $password);
                $stmt->execute();

                $message = "Registration successful. You can now log in.";
            }
        }
        
    }
}
else {
    $error = "Invalid request method.";
}
}
catch (PDOException $e){
    $output = "Unable to connect to the database server: " . $e; 
}

?>
<?php include 'templates/sign-up.html.php'; ?>
