<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #dae0e6;
      font-family: Arial, sans-serif;
    }
    .create-post-container {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      max-width: 700px;
      margin: 40px auto;
      box-shadow: 0 2px 6px #0000001a;
    }
    .nav-tabs .nav-link.active {
      border: none;
      border-bottom: 3px solid #ff4500;
      color: #ff4500 !important;
      font-weight: 600;
    }
    .btn-primary {
      background-color: #ff4500;
      border: none;
    }
    .btn-primary:hover {
      background-color: #e03e00;
    }
  </style>
</head>

<body>
  <div class="create-post-container">
    <h4 class="mb-3">Create a Post</h4>

    <form action="" method="POST" enctype="multipart/form-data">
        <ul class="nav nav-tabs mb-3" id="postTab" role="tablist">
            <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#post">Post</button>
            </li>
            <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#image">Image</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="post">
            <div class="mb-3">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>

             <div class="mb-3">
            <label for="module" class="form-label fw-semibold">Modules</label>
            <select class="form-select" id="module" name="module" required>
              <option value="">-- Select a Module --</option>
              <?php foreach ($modules as $module): ?>
                <option value="<?php echo htmlspecialchars($module['moduleID']); ?>">
                    <?php echo htmlspecialchars($module['moduleID'] . ' - ' . $module['moduleName']); ?>
                </option>
                <?php endforeach; ?>
            </select>
          </div>

            <div class="mb-3">
                <textarea name="content" class="form-control" rows="6" placeholder="Text (optional)"></textarea>
            </div>
            </div>

            <div class="tab-pane fade" id="image">
            <div class="mb-3">
                <input type="file" name="image" class="form-control">
            </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit Post</button>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success text-center mt-3">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
    </form>


    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
