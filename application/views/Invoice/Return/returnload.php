<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Return Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .card-header {
      font-weight: bold;
      font-size: 1.2rem;
    }
    .table input {
      min-width: 100px;
    }
  </style>
</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container py-5">
  <h2 class="mb-4">Return Invoice</h2>

  <?php if (!isset($invoice)): ?>
    <!-- Select Customer and Invoice Form -->
    <div class="card mb-4">
      <div class="card-header bg-light">Select Customer and Invoice</div>
      <div class="card-body">
        <form id="loadInvoiceForm" method="get">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="customerSelect" class="form-label">Customer</label>
              <select class="form-select" name="customer_id" id="customerSelect" required>
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer): ?>
                  <option value="<?= $customer->id ?>"><?= htmlspecialchars($customer->name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="invoiceSelect" class="form-label">Invoice</label>
              <select class="form-select" name="invoice_id" id="invoiceSelect" required>
                <option value="">Select Invoice</option>
                <?php foreach ($invoices as $inv): ?>
                  <option value="<?= $inv->id ?>" data-customer-id="<?= $inv->customer_id ?>">
                    <?= htmlspecialchars($inv->invoiceNo) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <input type="hidden" name="invoice_id" id="selectedInvoice">
          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary" id="loadInvoiceBtn" disabled>Load Invoice</button>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($invoice)): ?>
    <!-- Return Invoice Form -->
    <form method="POST" action="<?= site_url('ReturnInvoice_controller/create_return_invoice') ?>">
      <input type="hidden" name="invoice_id" value="<?= $invoice->id ?>">
      <input type="hidden" name="return_invoice_no" value="<?= htmlspecialchars($invoiceReturnNo) ?>">

      <!-- Invoice Info -->
      <div class="card mb-4">
        <div class="card-header bg-light">Invoice Details</div>
        <div class="card-body row g-3">
          <div class="col-md-4">
            <label class="form-label">Return Invoice No</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($invoiceReturnNo) ?>" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-select" required>
              <?php foreach ($customers as $c): ?>
                <option value="<?= $c->id ?>" <?= $invoice->customer_id == $c->id ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c->name) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label">Return Date</label>
            <input type="date" class="form-control" name="return_date" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">Return Reason</label>
            <textarea class="form-control" name="reason" rows="3" required></textarea>
          </div>
        </div>
      </div>

      <!-- Return Items -->
      <div class="card mb-4">
        <div class="card-header bg-light">Return Items</div>
        <div class="card-body">
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
              <?php if (isset($invoice_items)): ?>
                <?php foreach ($invoice_items as $index => $item): ?>
                  <tr>
                    <td>
                      <?= $item->productID ?>
                      <input type="hidden" name="returned_items[<?= $index ?>][item_id]" value="<?= $item->productID ?>">
                    </td>
                    <td><?= htmlspecialchars($item->itemName) ?></td>
                    <td><input type="text" name="returned_items[<?= $index ?>][description]" class="form-control" value="<?= htmlspecialchars($item->productDescription) ?>"></td>
                    <td><input type="number" name="returned_items[<?= $index ?>][unit_price]" class="form-control text-end price" step="0.01" value="<?= htmlspecialchars($item->price) ?>"></td>
                    <td><input type="number" name="returned_items[<?= $index ?>][quantity]" class="form-control text-end quantity" value="<?= $item->quantity ?>"></td>
                    <td><input type="text" name="returned_items[<?= $index ?>][total]" class="form-control text-end total" readonly value="<?= number_format($item->price * $item->quantity, 2) ?>"></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>

          <div class="text-end">
            <label class="form-label fw-bold">Total Return Amount</label>
            <input type="text" class="form-control text-end fw-bold" id="returnAmount" name="return_amount" readonly style="max-width: 200px; display: inline-block;">
          </div>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-success">Submit Return Invoice</button>
      </div>
    </form>
  <?php endif; ?>
</div>

<script>
// Dynamic Total Calculation
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

      if (totalInput) totalInput.value = rowTotal.toFixed(2);
      grandTotal += rowTotal;
    });
    if (returnAmountInput) returnAmountInput.value = grandTotal.toFixed(2);
  };

  rows.forEach(row => {
    row.querySelector('.price')?.addEventListener('input', updateTotal);
    row.querySelector('.quantity')?.addEventListener('input', updateTotal);
  });

  updateTotal();
});

// Filter invoices by selected customer
const customerSelect = document.getElementById('customerSelect');
const invoiceSelect = document.getElementById('invoiceSelect');
const selectedInvoice = document.getElementById('selectedInvoice');
const loadInvoiceForm = document.getElementById('loadInvoiceForm');
const loadInvoiceBtn = document.getElementById('loadInvoiceBtn');

if (customerSelect && invoiceSelect && loadInvoiceForm) {
  customerSelect.addEventListener('change', function () {
    const selectedCustomerId = this.value;
    Array.from(invoiceSelect.options).forEach(option => {
      const optionCustomerId = option.getAttribute('data-customer-id');
      option.style.display = (!option.value || optionCustomerId === selectedCustomerId) ? 'block' : 'none';
    });
    invoiceSelect.value = '';
    selectedInvoice.value = '';
    loadInvoiceBtn.disabled = true;
  });

  invoiceSelect.addEventListener('change', function () {
    const invoiceId = this.value;
    selectedInvoice.value = invoiceId;
    if (invoiceId) {
      loadInvoiceForm.action = `<?= base_url('ReturnInvoice_controller/load_return_Invoice') ?>/${invoiceId}`;
      loadInvoiceBtn.disabled = false;
    } else {
      loadInvoiceForm.action = '#';
      loadInvoiceBtn.disabled = true;
    }
  });
}
</script>

</body>
</html>
