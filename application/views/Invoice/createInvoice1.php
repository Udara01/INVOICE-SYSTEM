<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous"></head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container mt-5">
  <h1 class="mb-4">Create Invoice</h1>

  <form method="POST" action="/submit_invoice">

  <div class="row mb-3">
    <div class="col md-4">
      <label class="form-label">Invoice No</label>
      <input type="text" class="form-control" name="invoiceNo" value="<?= isset($invoiceNo) ? htmlspecialchars($invoiceNo) : '' ?>" placeholder="Invoice No" readonly required>
    </div>

    <div class="col md-4">
      <label class="form-label">Customer Name</label>
        <select class="form-select" name="customer_id" id="customerSelect" required>
          <option value="">Select Customer</option>
            <?php foreach ($customers as $cust): ?>
            <option value="<?= $cust->id ?>" data-address="<?= htmlspecialchars($cust->address) ?>">
              <?= htmlspecialchars($cust->name) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2 align-self-end">
      <a href="/customer" class="btn btn-outline-primary">Add New Customer</a>
    </div>

    <div class="row justify-content-between">
  <div class="col-md-5">
    <label class="form-label">Customer Address</label>
    <textarea class="form-control" name="customerAddress" id="customerAddress" rows="2" placeholder="Customer Address" required></textarea>
  </div>

  <div class="col-md-5">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" name="invoiceDate" value="<?= date('Y-m-d') ?>" required>
  </div>
</div>
      
    </div>

    <div id="items-container">
      <div class="item-row card p-3 mb-3">
        <div class="row g-3 align-items-end">
          <div class="col-md-2">
            <label class="form-label">Item</label>
            <select class="form-select itemSelect" name="item_id[]" required>
              <option value="">Select Item</option>
              <?php foreach ($items as $item): ?> 
                <option 
                  value="<?= htmlspecialchars($item->id) ?>"
                  data-price="<?= htmlspecialchars($item->price) ?>"
                  data-desc="<?= htmlspecialchars($item->description) ?>">
                  <?= htmlspecialchars($item->itemName) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="col-md-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="itemDescription[]" readonly>
          </div>

          <div class="col-md-2">
            <label class="form-label">Price</label>
            <input type="text" class="form-control" name="itemPrice[]">
          </div>

          <div class="col-md-2">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" name="itemQuantity[]" min="1" required>
          </div>

          <div class="col-md-2">
            <label class="form-label">Total</label>
            <input type="text" class="form-control" name="itemTotal[]" readonly>
          </div>

          <div class="col-md-1">
            <label class="form-label">&nbsp;</label>
            <button type="button" class="btn btn-outline-danger btn-sm w-100 mb-1" onclick="removeItem(this)">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>


    <button type="button" class="btn btn-secondary mb-3" onclick="addItem()">Add More Item</button>

    <div class="mb-3">
      <label class="form-label">Total Quantity:</label>
      <span id="totalQuantity" class="fw-bold">0</span>
    </div>
    <div class="mb-4">
      <label class="form-label">Total Amount:</label>
      <span id="totalAmount" class="fw-bold">0.00</span> 
      <input type="hidden" name="totalAmount" id="hiddenTotalAmount" value="0.00">
    </div>

    <button type="submit" class="btn btn-success">Submit Invoice</button>
  </form>
</div>

<script>
// Auto-fill the customer address when a customer is selected
document.getElementById('customerSelect').addEventListener('change', function () {
  const selected = this.options[this.selectedIndex];
  const address = selected.dataset.address || '';
  document.getElementById('customerAddress').value = address;
});

// Populate item price and description based on selected item
function updateItemDetails(selectElement) {
  const selected = selectElement.options[selectElement.selectedIndex];
  const row = selectElement.closest('.item-row');
  row.querySelector('input[name="itemPrice[]"]').value = selected.dataset.price || '';
  row.querySelector('input[name="itemDescription[]"]').value = selected.dataset.desc || '';
  calculateTotals();
}

// Clone a new item row with blank fields
function addItem() {
  const container = document.getElementById('items-container');
  const lastRow = container.querySelector('.item-row:last-of-type');
  const quantityInput = lastRow.querySelector('input[name="itemQuantity[]"]');
  const itemSelect = lastRow.querySelector('select');

  // Validation before cloning
  if (!quantityInput.value || parseInt(quantityInput.value) <= 0) {
    alert("Please enter a valid quantity before adding a new item.");
    quantityInput.focus();
    return;
  }

  if (!itemSelect.value) {
    alert("Please select an item before adding a new one.");
    itemSelect.focus();
    return;
  }

  // Clone and reset new row
  const newRow = lastRow.cloneNode(true);
  const newSelect = newRow.querySelector('select');
  newSelect.selectedIndex = 0;
  newRow.querySelector('input[name="itemPrice[]"]').value = '';
  newRow.querySelector('input[name="itemDescription[]"]').value = '';
  newRow.querySelector('input[name="itemQuantity[]"]').value = '';

  container.appendChild(newRow);

  newSelect.addEventListener('change', function() {
    updateItemDetails(this);
  });

  newRow.querySelector('input[name="itemQuantity[]"]').addEventListener('input', calculateTotals);
}

document.addEventListener('DOMContentLoaded', function() {
  const selects = document.querySelectorAll('.itemSelect');
  selects.forEach(select => {
    select.addEventListener('change', function() {
      updateItemDetails(this);
    });
  });

  document.querySelectorAll('input[name="itemQuantity[]"]').forEach(input => {
    input.addEventListener('input', calculateTotals);
  });

  selects.forEach(select => updateItemDetails(select));
});

function removeItem(button) {
  const container = document.getElementById('items-container');
  const rows = container.querySelectorAll('.item-row');
  if (rows.length > 1) {
    button.closest('.item-row').remove();
    calculateTotals();
  } else {
    alert("You need at least one item in the invoice.");
  }
}

document.querySelector('form').addEventListener('submit', function (e) {
  calculateTotals();
  const quantities = document.querySelectorAll('input[name="itemQuantity[]"]');
  for (let i = 0; i < quantities.length; i++) {
    if (!quantities[i].value || parseInt(quantities[i].value) <= 0) {
      alert("Please enter a valid quantity for all items.");
      e.preventDefault();
      return;
    }
  }
});

function calculateItemTotal(){
  let itemTotal = 0;
  
}

function calculateTotals() {
  const rows = document.querySelectorAll('.item-row');
  let totalQty = 0;
  let totalAmt = 0;

  rows.forEach(row => {
    const qtyInput = row.querySelector('input[name="itemQuantity[]"]');
    const priceInput = row.querySelector('input[name="itemPrice[]"]');
    const totalInput = row.querySelector('input[name="itemTotal[]"]');

    const qty = parseInt(qtyInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    const itemTotal = qty * price;

    totalInput.value = itemTotal.toFixed(2);

    totalQty += qty;
    totalAmt += itemTotal;
  });

  document.getElementById('totalQuantity').innerText = totalQty;
  document.getElementById('totalAmount').innerText = totalAmt.toFixed(2);
  document.getElementById('hiddenTotalAmount').value = totalAmt.toFixed(2); 
}

</script>

</body>
</html>
