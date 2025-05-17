<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Return Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php $this->load->view('layouts/navbar'); ?>

  <div class="container mt-5">
    <div class="card shadow p-4">
      <h2 class="text-primary mb-4">Edit Return Invoice</h2>

      <form method="post" action="<?= site_url('ReturnInvoice_controller/update_return_invoice/' . $return_invoice->id) ?>">
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Return Invoice No</label>
            <input type="text" class="form-control" value="<?= $return_invoice->return_invoice_no ?>" readonly>
          </div>
          <div class="col-md-4">
            <label class="form-label">Return Date</label>
            <input type="date" class="form-control" name="return_date" value="<?= $return_invoice->return_date ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
              <?php foreach ($customers as $customer): ?>
                <option value="<?= $customer->id ?>" <?= $customer->id == $return_invoice->customer_id ? 'selected' : '' ?>>
                  <?= htmlspecialchars($customer->name) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Reason</label>
          <textarea name="reason" class="form-control" rows="2"><?= htmlspecialchars($return_invoice->reason) ?></textarea>
        </div>

        <table class="table table-bordered" id="itemsTable">
          <thead>
            <tr class="table-light text-center">
              <th>Item</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($returned_items as $index => $item): ?>
              <tr>
                <td>
                  <select name="returned_items[<?= $index ?>][item_id]" class="form-control" required>
                    <?php foreach ($all_items as $i): ?>
                      <option value="<?= $i->id ?>" <?= $i->id == $item->item_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($i->itemName) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td>
                  <input type="number" name="returned_items[<?= $index ?>][quantity]" class="form-control quantity" min="1"
                         value="<?= $item->quantity ?>" required>
                </td>
                <td>
                  <input type="number" name="returned_items[<?= $index ?>][unit_price]" class="form-control unit-price" min="0"
                         value="<?= $item->unit_price ?>" step="0.01" required>
                </td>
                <td>
                  <input type="number" name="returned_items[<?= $index ?>][total]" class="form-control total" 
                         value="<?= $item->total ?>" step="0.01" readonly>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="mb-3 text-end">
          <button type="button" id="addItem" class="btn btn-outline-success btn-sm">Add Item</button>
        </div>

        <div class="mb-3 text-end">
          <label class="form-label fw-bold">Total Return Amount (Rs.):</label>
          <input type="number" name="return_amount" id="totalReturnAmount" class="form-control d-inline w-25" readonly>
        </div>

        <input type="hidden" name="invoice_id" value="<?= $return_invoice->original_invoice_id ?>">

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Update Return Invoice</button>
        </div>
      </form>
    </div>
  </div>

  <script>

     const itemsData = <?= $items_json ?>;

  function updatePrice(selectElement) {
    const itemId = selectElement.value;
    const row = selectElement.closest('tr');
    const priceInput = row.querySelector('.unit-price');

    if (itemsData[itemId]) {
      priceInput.value = parseFloat(itemsData[itemId].price).toFixed(2);
    }
  }

  
    function calculateTotals() {
      let totalAmount = 0;
      document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
        const qty = parseFloat(row.querySelector('.quantity').value) || 0;
        const price = parseFloat(row.querySelector('.unit-price').value) || 0;
        const total = qty * price;
        row.querySelector('.total').value = total.toFixed(2);
        totalAmount += total;
      });
      document.getElementById('totalReturnAmount').value = totalAmount.toFixed(2);
    }

    document.addEventListener('input', function (e) {
      if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
        calculateTotals();
      }
    });

    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
        calculateTotals();
      }
    });

    document.getElementById('addItem').addEventListener('click', function () {
const rowCount = document.querySelectorAll('#itemsTable tbody tr').length;
const newRow = `
  <tr>
    <td>
      <select name="returned_items[${rowCount}][item_id]" class="form-control" onchange="updatePrice(this)" required>
        <option value="">Select Item</option>
        <?php foreach ($all_items as $item): ?>
          <option value="<?= $item->id ?>"><?= htmlspecialchars($item->itemName) ?></option>
        <?php endforeach; ?>
      </select>
    </td>
    <td>
      <input type="number" name="returned_items[${rowCount}][quantity]" class="form-control quantity" min="1" required>
    </td>
    <td>
      <input type="number" name="returned_items[${rowCount}][unit_price]" class="form-control unit-price" min="0" step="0.01" required>
    </td>
    <td>
      <input type="number" name="returned_items[${rowCount}][total]" class="form-control total" step="0.01" readonly>
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
    </td>
  </tr>
`;
document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', newRow);

    });

    window.onload = calculateTotals;
  </script>
</body>
</html>
