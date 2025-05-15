<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Return Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body >
<?php $this->load->view('layouts/navbar'); ?>

<div class="container py-4">
  <h1>Return Invoice</h1>

  
  <form method="POST" action="<?= site_url('ReturnInvoice_controller/create_return_invoice') ?>" class="mb-4">

    <input type="hidden" name="invoice_id" value="<?= $invoice->id ?>">
    <input type="hidden" name="return_invoice_no" value="<?= htmlspecialchars($invoiceReturnNo) ?>">

    <div class="mb-3">
      <label class="form-label">Return Invoice No</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($invoiceReturnNo) ?>" readonly>
    </div>

    <div class="mb-3">
      <label class="form-label">Customer</label>
      <select name="customer_id" class="form-select" required>
        <?php foreach ($customers as $c): ?>
          <option value="<?= $c->id ?>" <?= $invoice->customer_id == $c->id ? 'selected' : '' ?>>
            <?= $c->name ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Return Reason</label>
      <textarea class="form-control" name="reason" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Return Date</label>
      <input type="date" class="form-control" name="return_date" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Return Amount</label>
      <input type="text" class="form-control text-end" id="returnAmount" name="return_amount" readonly style="font-weight: bold;">
    </div>

   
    <h4>Return Items</h4>
    <table class="table table-bordered align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Item ID</th>
          <th>Item Name</th>
          <th>Description</th>
          <th>Unit Price</th>
          <th>Return Quantity</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($invoice_items as $index => $item): ?>
        <tr>
          <td>
            <?= $item->productID ?>
            <input type="hidden" name="returned_items[<?= $index ?>][item_id]" value="<?= $item->productID ?>">
          </td>
          <td><?= $item->itemName ?></td>
          <td><input type="text" name="returned_items[<?= $index ?>][description]" class="form-control" value="<?= $item->productDescription ?>"></td>
          <td><input type="number" name="returned_items[<?= $index ?>][unit_price]" class="form-control text-end price" step="0.01" value="<?= $item->price ?>"></td>
          <td><input type="number" name="returned_items[<?= $index ?>][quantity]" class="form-control text-end quantity" value="<?= $item->quantity ?>"></td>
          <td><input type="text" name="returned_items[<?= $index ?>][total]" class="form-control text-end total" readonly value="<?= number_format($item->price * $item->quantity, 2) ?>"></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <button type="submit" class="btn btn-success">Submit Return Invoice</button>
  </form>
</div>
 
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const rows = document.querySelectorAll('table tbody tr');
      const returnAmountInput = document.getElementById('returnAmount');

      const updateTotal = () => {
        let grandTotal = 0;

        rows.forEach(row => {
          const priceInput = row.querySelector('.price');
          const qtyInput = row.querySelector('.quantity');
          const totalInput = row.querySelector('.total');

          const price = parseFloat(priceInput?.value) || 0;
          const qty = parseFloat(qtyInput?.value) || 0;
          const rowTotal = price * qty;

          if (totalInput) {
            totalInput.value = rowTotal.toFixed(2);
          }

          grandTotal += rowTotal;
        });

        if (returnAmountInput) {
          returnAmountInput.value = grandTotal.toFixed(2);
        }
      };

      rows.forEach(row => {
        const priceInput = row.querySelector('.price');
        const qtyInput = row.querySelector('.quantity');

        priceInput?.addEventListener('input', updateTotal);
        qtyInput?.addEventListener('input', updateTotal);
      });

      updateTotal(); 
    });
  </script>
</body>
</html>
