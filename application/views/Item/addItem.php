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
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow p-4">
        <h3 class="mb-4">Add Item</h3>

        <form action="/item/addItem" method="post">
          <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
              <?php echo validation_errors(); ?>
            </div>
          <?php endif; ?>

          <table class="table table-bordered bg-white align-middle">
            <tbody>
              <tr>
                <th style="width: 25%;">Item Name</th>
                <td><input type="text" name="itemName" class="form-control" required></td>
              </tr>
              <tr>
                <th>Category</th>
                <td>
                  <select id="category_select" name="category_ID" class="form-select" required>
                    <option value="" disabled selected>-- Select Category --</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?= htmlspecialchars($category->id) ?>">
                        <?= htmlspecialchars($category->category_name) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Quantity</th>
                <td>
                  <input type="number" step="0.01" name="stock" class="form-control" required>
                </td>
              </tr>
              <tr>
                <th>Item Price (Rs.)</th>
                <td>
                  <input type="number" step="0.01" name="itemPrice" class="form-control" required>
                </td>
              </tr>
              <tr>
                <th>Description</th>
                <td>
                  <textarea name="itemDescription" class="form-control" rows="3" required></textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-primary w-100">Add Item</button>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>

