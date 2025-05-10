<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Invoice</title>
  <style>
    .item-row { margin-bottom: 15px; border: 1px solid #ccc; padding: 10px; }
  </style>
</head>
<body>
  <h1>Create Invoice</h1>
  <form method="POST" action="/submit_invoice">

    <label for="InvoiceNo">Invoice No</label>
    <input type="text" name="invoiceNo" value="<?= isset($invoiceNo) ? htmlspecialchars($invoiceNo) : '' ?>" placeholder="Invoice No" required readonly> <br>

    <label for="customer_id">Customer Name</label>
<select name="customer_id" id="customerSelect" required>
  <option value="">Select Customer</option>
  <?php foreach ($customers as $cust): ?>
    <option 
  value="<?= $cust->id ?>" 
  data-address="<?= htmlspecialchars($cust->address) ?>"
>
  <?= htmlspecialchars($cust->name) ?>
</option>
  <?php endforeach; ?>
</select>

<a href="/customer">Add New Customer</a> <br><br>
<label for="customerAddress">Customer Address</label>
<input type="text" name="customerAddress" id="customerAddress" placeholder="Customer Address" required> <br>



    <div id="items-container">
      <div class="item-row">
        <label>Item</label>
        <select class="itemSelect" name="item_id[]" required>
          <?php foreach ($items as $item): ?> 
            <option 
              value="<?= htmlspecialchars($item->id) ?>"
              data-price="<?= htmlspecialchars($item->price) ?>"
              data-desc="<?= htmlspecialchars($item->description) ?>"  
            >
              <?= htmlspecialchars($item->itemName) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label>Price</label>
        <input type="text" name="itemPrice[]" readonly>

        <label>Description</label>
        <input type="text" name="itemDescription[]" readonly>

        <label>Quantity</label>
        <input type="number" name="itemQuantity[]" min="1" required>

        <button type="button" onclick="removeItem(this)">Remove</button>
      </div>
    </div>

    <button type="button" onclick="addItem()">Add More Item</button><br><br>

    <label>Total Quantity: </label>
    <span id="totalQuantity">0</span><br>

    <label>Total Amount: </label>
    <span id="totalAmount">0.00</span><br><br>

    <button type="submit">Submit Invoice</button>
  </form>

  <script>

document.getElementById('customerSelect').addEventListener('change', function () {
  const selected = this.options[this.selectedIndex];
  const address = selected.dataset.address || '';
  document.getElementById('customerAddress').value = address;
});


  // Function to update price and description based on selected item
  function updateItemDetails(selectElement) {
    const selected = selectElement.options[selectElement.selectedIndex];
    const row = selectElement.closest('.item-row');
    row.querySelector('input[name="itemPrice[]"]').value = selected.dataset.price;
    row.querySelector('input[name="itemDescription[]"]').value = selected.dataset.desc;
    calculateTotals();
  }

  function addItem() {
    const container = document.getElementById('items-container');
    const lastRow = container.querySelectorAll('.item-row')[container.querySelectorAll('.item-row').length - 1];

    const quantityInput = lastRow.querySelector('input[name="itemQuantity[]"]');
    const itemSelect = lastRow.querySelector('select');
    
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

    const newRow = lastRow.cloneNode(true);

    // Reset values in the new row
    const newSelect = newRow.querySelector('select');
    newSelect.selectedIndex = 0;
    newRow.querySelector('input[name="itemPrice[]"]').value = '';
    newRow.querySelector('input[name="itemDescription[]"]').value = '';
    newRow.querySelector('input[name="itemQuantity[]"]').value = '';

    container.appendChild(newRow);
    
    // Attach event to new quantity input
    newRow.querySelector('input[name="itemQuantity[]"]').addEventListener('input', calculateTotals);

    // Add event listener to the new select element
    newSelect.addEventListener('change', function() {
      updateItemDetails(this);
    });

    

    // Ensure price and description are updated for the new row
    updateItemDetails(newSelect);  // Manually trigger the update for the new row
  }

  // Add event listeners to all existing select elements
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize all existing select elements
    const selects = document.querySelectorAll('.itemSelect');
    selects.forEach(select => {
      // Add event listener
      select.addEventListener('change', function() {
        updateItemDetails(this);
      });
      document.querySelectorAll('input[name="itemQuantity[]"]').forEach(input => {
  input.addEventListener('input', calculateTotals);
});

      // Initialize the first row
      updateItemDetails(select);
    });
  });

  function removeItem(button) {
    const container = document.getElementById('items-container');
    const rows = container.querySelectorAll('.item-row');
    
    if (rows.length > 1) {
      button.closest('.item-row').remove();
    } else {
      alert("You need at least one item in the invoice.");
    }
  }

  document.querySelector('form').addEventListener('submit', function (e) {
    const quantities = document.querySelectorAll('input[name="itemQuantity[]"]');
    for (let i = 0; i < quantities.length; i++) {
      if (!quantities[i].value || parseInt(quantities[i].value) <= 0) {
        alert("Please enter a valid quantity for all items.");
        e.preventDefault(); // Stop form submission
        return;
      }
    }
  });


  // Function to calculate total quantity and amount
  function calculateTotals() {
  const rows = document.querySelectorAll('.item-row');
  let totalQty = 0;
  let totalAmt = 0;

  rows.forEach(row => {
    const qty = parseInt(row.querySelector('input[name="itemQuantity[]"]').value) || 0;
    const price = parseFloat(row.querySelector('input[name="itemPrice[]"]').value) || 0;

    totalQty += qty;
    totalAmt += qty * price;
  });

  document.getElementById('totalQuantity').innerText = totalQty;
  document.getElementById('totalAmount').innerText = totalAmt.toFixed(2);
}

</script>


</body>
</html>
