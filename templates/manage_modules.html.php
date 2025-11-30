<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Module Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body { background:#f5f6f8; }
    .card.module-card { transition: transform .08s ease-in-out; }
    .card.module-card:hover { transform: translateY(-2px); }
  </style>
</head>
<body>
<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Module Management</h1>
    <button type="button" 
        class="btn btn-primary" 
        data-bs-toggle="modal" 
        data-bs-target="#editModuleModal" 
        data-mode="add">
  + Add Module
</button>
  </div>

  <?php if (empty($modules)): ?>
    <div class="alert alert-info">No modules yet. Click “Add Module” to create one.</div>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($modules as $m): ?>
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
          <div class="card module-card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <div class="mb-2 small text-muted"><?= $m['moduleID'] ?></div>
              <h5 class="card-title mb-2">
                <?= htmlspecialchars($m['moduleName']) ?>
              </h5>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModuleModal"
                  data-id="<?= $m['moduleID'] ?>"
                  data-name="<?= htmlspecialchars($m['moduleName']) ?>"
                >
                  Edit
                </button>
                <form method="POST" onsubmit="return confirm('Delete this module?');">
                  <input type="hidden" name="delete_id" value="<?= $m['moduleID'] ?>">
                  <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- Shared Edit Modal -->
<div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <input type="hidden" name="mode" id="mode" value="edit">

      <div class="modal-header">
        <h5 class="modal-title" id="editModuleModalLabel">Edit Module</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="edit_id" id="edit_id">
         <div class="mb-3">
          <label for="edit_module_id" class="form-label">Module ID</label>
          <input type="text" class="form-control" name="edit_module_id" id="edit_module_id" required>
        </div>

        <div class="mb-3">
          <label for="edit_name" class="form-label">Module Name</label>
          <input type="text" class="form-control" name="edit_name" id="edit_name" required>
        </div>
      </div>

      <div class="modal-footer">
        <?php if (!empty($message)): ?>
            <div class="alert alert-success text-center mt-3">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        
      </div>

    </form>
  </div>
</div>
<script>
const editModal = document.getElementById('editModuleModal');
editModal.addEventListener('show.bs.modal', (event) => {
  const btn = event.relatedTarget;
  const mode = btn.getAttribute('data-mode') || 'edit';
  const id = btn.getAttribute('data-id');
  const name = btn.getAttribute('data-name');

  const title = editModal.querySelector('.modal-title');
  const saveBtn = editModal.querySelector('.btn-primary');
  const idInput = document.getElementById('edit_module_id');
  const nameInput = document.getElementById('edit_name');
  const hiddenId = document.getElementById('edit_id');
  const modeInput = document.getElementById('mode');

  if (mode === 'add') {
    // Switch to ADD mode
    title.textContent = 'Add Module';
    saveBtn.textContent = 'Add Module';
    idInput.value = '';
    nameInput.value = '';
    hiddenId.value = '';
    modeInput.value = 'add';
  } else {
    // Switch to EDIT mode
    title.textContent = 'Edit Module';
    saveBtn.textContent = 'Save Changes';
    idInput.value = id;
    nameInput.value = name;
    hiddenId.value = id;
    modeInput.value = 'edit';
  }
});
</script>
</body>
</html>
