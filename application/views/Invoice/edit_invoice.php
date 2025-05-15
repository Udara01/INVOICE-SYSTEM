<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container mt-5">
  <h2 class="mb-4">Edit Invoice</h2>

  <?php if (isset($invoice)): ?>
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Invoice Summary</h5>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-sm-6"><strong>Customer:</strong> <?= $invoice->customer_name ?></div>
          <div class="col-sm-6"><strong>Created By:</strong> <?= $invoice->created_by_name ?></div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6"><strong>Created At:</strong> <?= $invoice->created_at ?></div>
          <div class="col-sm-6"><strong>Updated By:</strong> <?= $invoice->updated_by_name ?></div>
        </div>
        <div class="row">
          <div class="col-sm-6"><strong>Updated At:</strong> <?= $invoice->updated_at ?></div>
        </div>
      </div>
    </div>


    <form method="POST" action="<?= base_url('Customer_invoice/update_invoice/' . $invoice->id) ?>" class="mb-4">
        <div class="mb-3">
          <label for="invoiceNo" class="form-label">Invoice No</label>
          <input type="text" class="form-control" name="invoiceNo" value="<?= $invoice->invoiceNo ?>" required>
        </div>

        <div class="mb-3">
          <label for="customer_id" class="form-label">Customer</label>
          <select name="customer_id" class="form-select" required>
            <?php foreach ($customers as $c): ?>
              <option value="<?= $c->id ?>" <?= ($invoice->customer_id == $c->id) ? 'selected' : '' ?>>
                <?= $c->name ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="total_amount" class="form-label">Total Amount</label>
          <input type="text" class="form-control text-end fw-bold" 
                name="total_amount" 
                value="<?= number_format($invoice->total_amount, 2, '.', ',') ?>" 
                readonly>
        </div>

        <button type="submit" class="btn btn-success">Update Invoice</button>
      </form>

  <?php else: ?>
    <p class="alert alert-warning">Invoice not found!</p>
  <?php endif; ?>

  <hr>

  <h4 class="mb-3">Invoice Items</h4>
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>Item Name</th>
          <th>Description</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Update</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($invoice_items as $item): ?>
          <tr>
            <form action="<?= site_url('Customer_invoice/update_invoice_item/' . $item->id . '/' . $invoice->id) ?>" method="POST">
              <td class="text-center"><?= $item->itemName ?></td>
              <td><input type="text" name="productDescription" class="form-control" value="<?= $item->productDescription ?>"></td>
              <td><input type="number" step="0.01" name="price" class="form-control text-end" value="<?= $item->price ?>"></td>
              <td><input type="number" name="quantity" class="form-control text-end" value="<?= $item->quantity ?>"></td>
              <td class="text-end"><?= number_format($item->price * $item->quantity, 2) ?></td>
              <td>
                <button type="submit" class="btn btn-sm btn-success">Update</button>
              </td>
            </form>
            <td class="text-center">
              <form action="<?= site_url('Customer_invoice/delete_invoice_item/' . $item->id . '/' . $invoice->id) ?>" method="POST" onsubmit="return confirm('Are you sure?');">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot class="fw-bold bg-light text-end">
        <tr>
          <td colspan="3" class="text-center">Total</td>
          <td><?= number_format(array_sum(array_column($invoice_items, 'quantity')), 2) ?></td>
          <td><?= number_format(array_reduce($invoice_items, fn($sum, $i) => $sum + ($i->price * $i->quantity), 0), 2, '.', ',') ?></td>
          <td colspan="2"></td>
        </tr>
      </tfoot>
    </table>


  <hr>

  <div class="card mt-4 mb-5">
  <div class="card-header bg-light">
    <h5 class="mb-0">Add New Item</h5>
  </div>
  <div class="card-body">
    <form id="addItemForm" method="POST" action="<?= site_url('Customer_invoice/add_invoice_item/' . $invoice->id) ?>">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label for="productID" class="form-label">Select Item</label>
          <select class="form-select" id="productID" name="productID" required>
            <option value="">-- Select Item --</option>
            <?php foreach ($all_items as $item): ?>
              <option value="<?= $item->id ?>" 
                      data-price="<?= $item->price ?>" 
                      data-description="<?= htmlspecialchars($item->description) ?>">
                <?= $item->itemName ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label for="description" class="form-label">Description</label>
          <input type="text" class="form-control" id="description" name="description" readonly>
        </div>

        <div class="col-md-2">
          <label for="price" class="form-label">Price</label>
          <input type="text" class="form-control text-end" id="price" name="price">
        </div>

        <div class="col-md-1">
          <label for="quantity" class="form-label">Qty</label>
          <input type="number" class="form-control text-end" id="quantity" name="quantity" min="1" step="1" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Total</label>
          <input type="text" class="form-control text-end" id="item_total" readonly>
        </div>

        <div class="col-md-1 d-grid">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </form>
  </div>
</div>


</div>

<script>

document.getElementById('productID').addEventListener('change', function () {
  const selected = this.options[this.selectedIndex];
  const price = parseFloat(selected.getAttribute('data-price')) || 0;
  const description = selected.getAttribute('data-description') || '';

  document.getElementById('price').value = price.toFixed(2);
  document.getElementById('description').value = description;
  updateTotal();
});

document.getElementById('quantity').addEventListener('input', updateTotal);

function updateTotal() {
  const price = parseFloat(document.getElementById('price').value) || 0;
  const quantity = parseFloat(document.getElementById('quantity').value) || 0;
  const total = price * quantity;
  document.getElementById('item_total').value = total.toFixed(2);
}
</script>

</body>
</html>
