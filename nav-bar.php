
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
      background-color: #010763f5 !important;
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
    <a class="navbar-brand" href="/studentoverflow/index.php"><img src="WhiteLogoUOG.png" class = "logo" ></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="/studentoverflow/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-post.php">Add Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/studentoverflow/users/list_users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/studentoverflow/modules/list_modules.php">Modules</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/studentoverflow/contact.php">Contact Admin</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>