<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<h1>Items</h1>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Description</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item->itemName) ?></td>
          <td><?= htmlspecialchars($item->price) ?></td>
          <td><?= htmlspecialchars($item->description) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>


  <h1>update Item</h1>

  <form action="/item/updateItem" method="post">
    <label for="itemName">Item Name: </label>
    <select id="itemSelect" name="item_id" class="form-control mb-3">
            <?php foreach ($items as $item): ?>
            <option 
            value="<?= htmlspecialchars($item->id) ?>"
            data-name = "<?= htmlspecialchars($item->itemName) ?>"
            data-price="<?= htmlspecialchars($item->price) ?>"
            data-desc="<?= htmlspecialchars($item->description) ?>"
            >
            <?= htmlspecialchars($item->itemName) ?></option>
            <?php endforeach; ?>
        </select> <br>
    
    <label for="itemName">Item Name: </label>
    <input type="text" name="itemName" id="itemName" placeholder="Item Name" required> <br>

    <label for="itemPrice">Item Price: </label>
    <input type="number" name="itemPrice" id="itemPrice" step="0.01" placeholder="Item Price" required> <br>

    <label for="itemDescription">Item Description: </label>
    <textarea name="itemDescription" id="itemDescription" placeholder="Item Description" required></textarea> <br>

    <button type="submit">Update Item</button>
  </form>

  <script>
       
       
        document.getElementById('itemSelect').addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            document.getElementById('itemName').value = selected.dataset.name;
            document.getElementById('itemPrice').value = selected.dataset.price;
            document.getElementById('itemDescription').value = selected.dataset.desc;
        });

        
        document.getElementById('itemSelect').dispatchEvent(new Event('change'));
    </script>
</body>
</html>