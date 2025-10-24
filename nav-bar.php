<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StudentOverflow</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-nav .nav-link {
    display: flex;
    align-items: center;
    height: 100%;
    padding: 10px 15px;
    font-size: 16px;}

    .nav-link.active {
      font-weight: 600;
      color: #fcfcfcff !important;
      background-color: #000436f5 !important;
    }
    .custom-navbar {
      padding-top: 0px;
      padding-bottom: 0px;
    }

    .navbar-nav .nav-link.active {
        background-color: #000e22ff !important;
        color: #fff !important;
        border-radius: 0;
        height: 100%;
    }

    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .navbar-nav {
        height: 100%;
    }
    .logo {
        width:auto;
        height:8vh;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm custom-navbar">
  <div class="container">
    <a class="navbar-brand" href="/studentoverflow/index.php">
      <img src="WhiteLogoUOG.png" class="logo" alt="UoG Logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.html.php">Home</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Logged-in users -->
          <li class="nav-item">
              <a class="nav-link" href="profile.php">Profile</a>
            </li>
          <?php if ($_SESSION['role'] === 'student'): ?>
            <!-- Student menu -->
            <li class="nav-item">
              <a class="nav-link" href="addpost.php">Add Post</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/studentoverflow/contact.php">Contact Admin</a>
            </li>


          <?php elseif ($_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="addpost.php">Add Post</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/studentoverflow/users/list_users.php">Manage Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/studentoverflow/modules/list_modules.php">Manage Modules</a>
            </li>
          <?php endif; ?>

          <!-- Common to all logged-in users -->
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">Log Out</a>
          </li>

        <?php else: ?>
          <!-- Not logged in -->
          <li class="nav-item">
            <a class="nav-link" href="login.php">Log In</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const current = window.location.pathname.split("/").pop();
  document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
    if (link.getAttribute("href") === current) {
      link.classList.add("active");
    }
  });
</script>