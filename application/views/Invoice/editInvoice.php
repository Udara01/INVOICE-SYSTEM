<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php $this->load->view('layouts/navbar'); ?>

  <div class="container mt-5">
    <h2>Invoice Details</h2>

    <div class="card p-4">
      <h3>Invoice #<?= htmlspecialchars($invoice->id) ?></h3>
      <p><strong>Customer Name:</strong> <?= htmlspecialchars($invoice->customerName) ?></p>
      <p><strong>Item Name:</strong> <?= htmlspecialchars($invoice->itemName) ?></p>
      <p><strong>Item Price:</strong> Rs. <?= htmlspecialchars($invoice->price) ?></p>
      <p><strong>Item Description:</strong> <?= htmlspecialchars($invoice->description) ?></p>


      <!-- Delete Button -->
      <div class="d-flex justify-content-center mt-3 gap-3">
        <a href="<?= site_url('invoice/delete/' . $invoice->id) ?>"
          class="btn btn-danger px-4"
          style="min-width: 150px;"
          onclick="return confirm('Are you sure you want to delete this invoice?');">
          Delete
        </a>
        <a href="<?= site_url('invoice') ?>" class="btn btn-secondary px-4" style="min-width: 150px;">
          Back
        </a>
      </div>
    </div>

    <!--Invoice Update Part -->
    <h2 class="mt-5">Update Invoice</h1>
    <div class="card p-4">
    <form action="<?= site_url('invoice/update/' . $invoice->id) ?>" method="post">
      <div class="mb-3">
        <label for="customerName" class="form-label">Customer Name</label>
        <input type="text" class="form-control" id="customerName" name="customerName" 
              value="<?= htmlspecialchars($invoice->customerName) ?>" required>
      </div>

      <div class="mb-3">
        <label for="item_id" class="form-label">Select Item</label>
        <select class="form-select" id="item_id" name="item_id" required>
          <?php foreach ($items as $item): ?>
            <option value="<?= $item->id ?>" 
              data-price="<?= $item->price ?>" 
              data-description="<?= htmlspecialchars($item->description) ?>"
              <?= $invoice->productID == $item->id ? 'selected' : '' ?>>
              <?= htmlspecialchars($item->itemName) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Item Price (Rs.)</label>
        <input type="text" class="form-control" id="item_price" value="<?= $invoice->price ?>" disabled>
      </div>

      <div class="mb-3">
        <label class="form-label">Item Description</label>
        <textarea class="form-control" id="item_description" rows="3" disabled><?= $invoice->description ?></textarea>
      </div>

      <div class="d-flex justify-content-center mt-3">
        <button type="submit" class="btn btn-success px-4" style="min-width: 150px;">
          Update Invoice
        </button>
        <a href="<?= site_url('invoice') ?>" class="btn btn-secondary px-4 ms-3" style="min-width: 150px;">
          Back
        </a>
      </div>

    </form>
    </div>


  </div>
  <script>
  const itemSelect = document.getElementById('item_id');
  const priceField = document.getElementById('item_price');
  const descField = document.getElementById('item_description');

  itemSelect.addEventListener('change', function() {
    const selected = itemSelect.options[itemSelect.selectedIndex];
    priceField.value = selected.getAttribute('data-price');
    descField.value = selected.getAttribute('data-description');
  });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
