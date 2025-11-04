<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Admin</title>
</head>
<style>
    .btn-primary {
      background-color: #ff4500;
      border: none;
    }
    .btn-primary:hover {
      background-color: #e03e00;
    }
</style>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0">Contact Admin</h4>
    </div>
    <div class="card-body">
      <form action="" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="subject" class="form-label">Subject</label>
          <input type="text" class="form-control" id="subject" name="subject" required>
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success text-center mt-3">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary w-100">Send Message</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
