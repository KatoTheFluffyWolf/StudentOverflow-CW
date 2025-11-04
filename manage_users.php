<?php
include 'config.php'; // contains $dsn, $DB_USER, $DB_PASS
include 'nav-bar.php';

// Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Access denied. You do not have permission to access this page.");
}

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT userID, username, name, email, role FROM users ORDER BY userID DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<?php include 'templates/manage_users.html.php'; ?>