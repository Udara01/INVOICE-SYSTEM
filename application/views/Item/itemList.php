<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <div class="mb-4">
      <h3>Items List</h3>
      <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
          <tr class="text-center">
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
          <tr>
            <td class="text-center"><?= htmlspecialchars($item->itemName) ?></td>
            <td class="text-center"><?= htmlspecialchars($item->category_name) ?></td>
            <td><?= htmlspecialchars($item->description) ?></td>
            <td class="text-center"><?= htmlspecialchars($item->stock) ?></td>
            <td class="text-end">Rs. <?= htmlspecialchars($item->price) ?></td>
            
            <td class="text-center">
        <form action="/item/deleteItem" method="post" style="display:inline;" onsubmit="return confirm('Are you sure?');">
          <input type="hidden" name="item_id" value="<?= $item->id ?>">
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
          </tr>
          <?php endforeach; ?>
          
        </tbody>
      </table>
    </div>
</div>
</body>
</html>

