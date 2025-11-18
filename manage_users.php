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

    // ---------- HANDLE ADD USER FORM SUBMIT ----------
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? '';

        // Basic validation
        if ($username === '' || $name === '' || $email === '' || $password === '' || $role === '') {
            $errors[] = 'All fields are required.';
        } else {
            // Optional: check for existing username or email
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $checkStmt->execute([
                ':username' => $username,
                ':email'    => $email
            ]);

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
