<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php $this->load->view('layouts/navbar'); ?>

  <div class="container mt-5">
    <!--div class="mb-4">
      <h3>Items List</h3>
      <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php /* foreach ($items as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item->itemName) ?></td>
            <td><?= htmlspecialchars($item->price) ?></td>
            <td><?= htmlspecialchars($item->description) ?></td>
            <td>
        <form action="/item/deleteItem" method="post" style="display:inline;" onsubmit="return confirm('Are you sure?');">
          <input type="hidden" name="item_id" value="<?= $item->id ?>">
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
          </tr>
          <?php endforeach;*/ ?>
          
        </tbody>
      </table>
    </div -->
  <div class='row justify-content-center'>
    <div class="col-md-6 col-Xl-5">
    <div class="card p-4 shadow">
      <h3 class="mb-4">Update Item</h3>
      <form action="/item/updateItem" method="post">

       

        <div class="mb-3">
          <label for="itemSelect" class="form-label">Select Item</label>
          <select id="itemSelect" name="item_id" class="form-select">
            <?php foreach ($items as $item): ?>
            <option value="<?= $item->id ?>"
              data-name="<?= htmlspecialchars($item->itemName) ?>"
              data-price="<?= htmlspecialchars($item->price) ?>"
              data-desc="<?= htmlspecialchars($item->description) ?>"
              data-stock="<?= htmlspecialchars($item->stock) ?>">
              <?= htmlspecialchars($item->itemName) ?> 
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Item Name</label>
          <input type="text" id="itemName" name="itemName" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Item Price (Rs.)</label>
          <input type="number" step="0.01" id="itemPrice" name="itemPrice" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea id="itemDescription" name="itemDescription" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" step="0.01" id="itemStock" name="itemStock" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-warning w-100">Update Item</button>
      </form>
    </div>
    </div>
  </div>
  </div>

  <script>
    const select = document.getElementById('itemSelect');
    const nameInput = document.getElementById('itemName');
    const priceInput = document.getElementById('itemPrice');
    const descInput = document.getElementById('itemDescription');
    const stockInput = document.getElementById('itemStock');

    select.addEventListener('change', function () {
      const selected = this.options[this.selectedIndex];
      nameInput.value = selected.dataset.name;
      priceInput.value =  selected.dataset.price;
      descInput.value = selected.dataset.desc;
      stockInput.value = selected.dataset.stock;
    });

    select.dispatchEvent(new Event('change'));
  </script>
</body>
</html>
