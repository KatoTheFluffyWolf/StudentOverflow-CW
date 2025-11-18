<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StudentOverflow</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
/>
  <style>
    body { background-color: #f8f9fa; }
    .navbar-nav .nav-link {
      display: flex;
      align-items: center;
      height: 100%;
      padding: 10px 15px;
      font-size: 16px;
    }
    .nav-link.active {
      font-weight: 600;
      color: #fcfcfcff !important;
      background-color: #000436f5 !important;
    }
    .custom-navbar { padding-top: 0; padding-bottom: 0; }
    .navbar-nav .nav-link.active {
      background-color: #000e22ff !important;
      color: #fff !important;
      border-radius: 0;
      height: 100%;
    }
    .navbar-nav .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .navbar-nav { height: 100%; }
    .logo { width: auto; height: 8vh; }
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
        

        <?php if (isset($_SESSION['user_id'])):
          $role = $_SESSION['role'] ?? ''; ?>
          
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="user-profile.php">Profile</a>
          </li>

          <?php if ($role === 'student'): ?>
            <li class="nav-item">
              <a class="nav-link" href="addpost.php">Add Post</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Admin</a>
            </li>

          <?php elseif ($role === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="addpost.php">Add Post</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage_users.php">Manage Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage_modules.php">Manage Modules</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stats.php">View Stats</a>
            </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">Log Out</a>
          </li>

        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Log In</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const current = window.location.pathname.split("/").pop();
  document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
    if (link.getAttribute("href") === current) {
      link.classList.add("active");
    }
  });
</script>

</body>
</html>
