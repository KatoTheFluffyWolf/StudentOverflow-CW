<?php include 'nav-bar.php'; ?>

<div class="container mt-5 d-flex justify-content-center">
  <div class="card shadow-lg" style="width: 28rem;">
    <!-- Card header -->
    <div class="card-header bg-primary text-white text-center fs-4 fw-semibold">
      Log In
    </div>

    <!-- Card body -->
    <div class="card-body">
      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label fs-5">Username</label>
          <input type="text" class="form-control form-control-lg" id="username" name="username" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label fs-5">Password</label>
          <input type="password" class="form-control form-control-lg" id="password" name="password">
        </div>
        <div class="form-check mb-4">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label fs-6" for="exampleCheck1">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100">Submit</button>
      </form>
    </div>

    <!-- Optional footer -->
    <div class="card-footer text-center text-muted">
      Don't have an account? <a href="#">Sign up!</a>
    </div>
  </div>
</div>
