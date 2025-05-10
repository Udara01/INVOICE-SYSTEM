<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php $this->load->view('layouts/navbar'); ?>

  <div class="container">

    <h2 class="mb-4">Create Invoice</h2>

    <form action="/invoice/create" method="post" class="mb-5">
      <div class="mb-3">
        <label for="customerName" class="form-label">Customer Name</label>
        <input type="text" name="customerName" class="form-control" placeholder="Enter customer name" required>
      </div>

      <div class="mb-3">
        <label for="itemSelect" class="form-label">Item Name</label>
        <select id="itemSelect" name="item_id" class="form-select" required>
          <?php foreach ($items as $item): ?> 
            <option 
              value="<?= htmlspecialchars($item->id) ?>"
              data-name="<?= htmlspecialchars($item->itemName) ?>"
              data-price="<?= htmlspecialchars($item->price) ?>"
              data-desc="<?= htmlspecialchars($item->description) ?>"  
            >
              <?= htmlspecialchars($item->itemName) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="itemPrice" class="form-label">Item Price(Rs. )</label>
        <input type="text" name="itemPrice" id="itemPrice" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label for="itemDescription" class="form-label">Item Description</label>
        <input type="text" name="itemDescription" id="itemDescription" class="form-control" readonly>
      </div>

      <button type="submit" class="btn btn-success">Save Invoice</button>
    </form>

    <h2>Invoice List</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>Invoice ID</th>
            <th>Customer Name</th>
            <th>Item Name</th>
            <th>Item Price (Rs.)</th>
            <th>Item Description</th>
            <th>Print</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($invoices as $invoice): ?>
            <tr>
              <td><?= htmlspecialchars($invoice->id) ?></td>
              <td><?= htmlspecialchars($invoice->customerName) ?></td>
              <td><?= htmlspecialchars($invoice->itemName) ?></td>
              <td>Rs. <?= htmlspecialchars($invoice->price) ?></td>
              <td><?= htmlspecialchars($invoice->description) ?></td>
              <td>
                <a href="<?= site_url('invoice/print/' . $invoice->id) ?>" class="btn btn-primary btn-sm" target="_blank">Print</a>
                
                <a href="<?= site_url('invoice/view/' . $invoice->id) ?>" class="btn btn-info btn-sm">View</a>
              </td>
              
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>

 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const itemSelect = document.getElementById('itemSelect');
    itemSelect.addEventListener('change', function () {
      const selected = this.options[this.selectedIndex];
      document.getElementById('itemPrice').value = 'Rs. ' + selected.dataset.price;
      document.getElementById('itemDescription').value = selected.dataset.desc;
    });

    
    itemSelect.dispatchEvent(new Event('change'));
  </script>
</body>
</html>
