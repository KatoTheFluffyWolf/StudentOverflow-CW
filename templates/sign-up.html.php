<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <style>
    body { background-color: #dae0e6; font-family: Arial; }
    .btn-primary {
      background-color: #ff4500;
      border: none;
    }
    .btn-primary:hover {
      background-color: #e03e00;
    }
    .text-primary {
      color: #ff4500 !important;
    }
  </style>
</head>
<body>

<div class="container mt-5 d-flex justify-content-center">
  <div class="card shadow-lg" style="width: 28rem;">
    <!-- Card header -->
    <div class="card-header bg-dark text-white text-center fs-4 fw-semibold">
      Sign Up
    </div>

    <!-- Card body -->
    <div class="card-body">

      <?php if (isset($error)){?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php } ?>

      <form action="" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label fs-5">Username</label>
          <input type="text" class="form-control form-control-lg" id="username" name="username" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label fs-5">Email</label>
          <input type="text" class="form-control form-control-lg" id="email" name="email" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label fs-5">Password</label>
          <input type="password" class="form-control form-control-lg" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirmed-password" class="form-label fs-5">Confirm Password</label>
          <input type="password" class="form-control form-control-lg" id="confirmed-password" name="confirmed-password" required>
        </div>
        <div class="form-check mb-4">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label fs-6" for="exampleCheck1">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100">Sign up</button>
      </form>
      <?php if (!empty($message)): ?>
            <div class="alert alert-success text-center mt-3">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>



