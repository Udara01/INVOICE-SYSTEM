<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Category Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php $this->load->view('layouts/navbar'); ?>

  <div class="container mt-5">
    <h2 class="mb-4">Manage Categories</h2>

    <!-- Create Category Form -->
    <div class="card mb-5">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add New Category</h5>
      </div>
      <div class="card-body">
        <form action="<?= site_url('Category_controller/create_category') ?>" method="post" class="row g-3">
          <div class="col-md-6">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" name="categoryName" class="form-control" placeholder="Enter category name" required>
          </div>
          <div class="col-md-6">
            <label for="categoryDescription" class="form-label">Category Description</label>
            <input type="text" name="categoryDescription" class="form-control" placeholder="Enter description">
          </div>
          <div class="col-12 d-grid mt-3">
            <button type="submit" class="btn btn-success">Save Category</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Category Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Update</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $category): ?>
            <tr>
              <form action="<?= site_url('Category_controller/update_category/' . $category->id) ?>" method="post">
                <td class="text-center"><?= htmlspecialchars($category->id) ?></td>
                <td>
                  <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($category->category_name) ?>">
                </td>
                <td>
                  <input type="text" name="category_description" class="form-control" value="<?= htmlspecialchars($category->categoryDescription) ?>">
                </td>
                <td class="text-center">
                  <button type="submit" class="btn btn-sm btn-warning">Update</button>
                </td>
              </form>
              <td class="text-center">
                <form action="<?= site_url('Category_controller/delete_category/' . $category->id) ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this category?');">
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
