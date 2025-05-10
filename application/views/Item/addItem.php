<!--DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Item</title>
</head>
<body>
  <h1>Add Item</h1>

  <form action="/item/addItem" method="post">
    <label for="itemName">Item Name: </label>
    <input type="text" name="itemName" id="itemName" placeholder="Item Name" required> <br>

    <label for="itemPrice">Item Price: </label>
    <input type="number" name="itemPrice" id="itemPrice" step="0.01" placeholder="Item Price" required> <br>

    <label for="itemDescription">Item Description: </label>
    <textarea name="itemDescription" id="itemDescription" placeholder="Item Description" required></textarea> <br>

    <button type="submit">Add Item</button>
  </form>
</body>
</html-->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php $this->load->view('layouts/navbar'); ?>
  <div class="container mt-5">
    <div class='row justify-content-center'>
  <div class="col-md-6 col-Xl-5">
    <div class="card p-4 shadow">
      <h3 class="mb-4">Add Item</h3>

      <form action="/item/addItem" method="post">
      
      <?php if (validation_errors()): ?>
        <div class="alert alert-danger">
          <?php echo validation_errors(); ?>
        </div>
      <?php endif; ?>


        <div class="mb-3">
          <label for="itemName" class="form-label">Item Name</label>
          <input type="text" name="itemName" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="itemPrice" class="form-label">Category</label>
            
          <select id="category_select" name="category_ID" class="form-select" required>
            <option value="" disabled selected>-- Select Category --</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= htmlspecialchars($category->id) ?>"
                      data-name="<?= htmlspecialchars($category->category_name) ?>">
                <?= htmlspecialchars($category->category_name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="itemPrice" class="form-label">Item quentity</label>
          <input type="number" step="0.01" name="stock" class="form-control" required>
          </div>

        <div class="mb-3">
          <label for="itemPrice" class="form-label">Item Price (Rs.)</label>
          <input type="number" step="0.01" name="itemPrice" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="itemDescription" class="form-label">Description</label>
          <textarea name="itemDescription" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Item</button>
      </form>
    </div>
  </div>
  </div>
  </div>
</body>
</html>

