<?php include 'nav-bar.php'; ?>
<?php include 'config.php'; ?>

<?php
try {
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Handle POST (delete or edit)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mode = $_POST['mode'] ?? '';
    // add
    if ($mode === 'add') {
        $id = $_POST['edit_module_id'];
        $name = $_POST['edit_name'];

        $stmt = $pdo->prepare("INSERT INTO modules (moduleID, moduleName) VALUES (:id, :name)");
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $message = "Module added successfully!";
    } elseif ($mode === 'edit') { // edit
        $oldId = $_POST['edit_id'];
        $newId = $_POST['edit_module_id'];
        $name = $_POST['edit_name'];
        $stmt = $pdo->prepare("UPDATE modules SET moduleID = :newId, moduleName = :name WHERE moduleID = :oldId");
        $stmt->bindValue(':newId', $newId);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':oldId', $oldId);
        $stmt->execute();
        $message = "Module updated successfully!";
    } elseif (isset($_POST['delete_id'])) { // delete
        $stmt = $pdo->prepare("DELETE FROM modules WHERE moduleID = :id");
        $stmt->bindValue(':id', $_POST['delete_id']);
        $stmt->execute();
        $message = "Module deleted successfully!";
    }
  }

  // Fetch modules for display
  $stmt = $pdo->query('SELECT moduleID, moduleName FROM modules ORDER BY moduleName ASC');
  $modules = $stmt->fetchAll();

} catch (PDOException $e) {
  http_response_code(500);
  die('Database error.');
}
?>

<?php include 'templates/manage_modules.html.php'; ?>
