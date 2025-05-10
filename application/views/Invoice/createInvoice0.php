<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Create Invoice</h1>

  <form action="invoice/create" method="post">
    <label for="customerName">customerName</label>
    <input type="text" name="customerName" placeholder="customerName">

    <label>Item Name</label>
    <select id="itemSelect" name="item_id">
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

    <label for="itemPrice">Item Price: </label>
    <input type="text" name="itemPrice" id="itemPrice" readonly>

    <label for="itemDescription">Item Description: </label>
    <input type="text" name="itemDescription" id="itemDescription" readonly>


    <button type="submit">Save Invoice</button>
  </form>




  <h1>Invoice list</h1>
  <table>
    <tr>
      <th>Invoice ID</th>
      <th>Customer Name</th>
      <th>Item Name</th>
      <th>Item Price</th>
      <th>Item Description</th>
      <th>Print Invoice</th>
    </tr>
    <?php foreach ($invoices as $invoice): ?>
    <tr>
      <td><?= htmlspecialchars($invoice->id) ?></td>
      <td><?= htmlspecialchars($invoice->customerName) ?></td>
      <td><?= htmlspecialchars($invoice->itemName) ?></td>
      <td><?= htmlspecialchars($invoice->price) ?></td>
      <td><?= htmlspecialchars($invoice->description) ?></td>
      <td><a href="<?= site_url('invoice/print/' . $invoice->id) ?>" target="_blank">Print</a></td>
      </tr>
    <?php endforeach; ?>

    </table>







  <script type="text/javascript">
    document.getElementById('itemSelect').addEventListener('change', function(){
      var selected = this.options[this.selectedIndex];
      //document.getElementById('itemName').value = selected.dataset.name;
      document.getElementById('itemPrice').value = selected.dataset.price;
      document.getElementById('itemDescription').value = selected.dataset.desc;
      
    });
            document.getElementById('itemSelect').dispatchEvent(new Event('change'));

  </script>
</body>
</html>