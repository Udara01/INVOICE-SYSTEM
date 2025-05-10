<!--DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Delete Items</h1>
  <form action="item/deleteItem" method="post">
    <label for="itemSelect">Select Item to Delete: </label>
    <select id="itemSelect" name="item_id" class="form-control mb-3">
      </*?php  foreach ($items as $item): ?>
        <option value="</*?= htmlspecialchars($item->id) ?>"></*?= htmlspecialchars($item->itemName) ?></option>
      </*?php endforeach; ?>
    </select> <br>

    <button type="submit">Delete Item</button>
  </form>

</body>
</html-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php $this->load->view('layouts/navbar'); ?>
  <div class="container mt-5">
    <div class="card p-4 shadow">
      <h3 class="mb-4">Delete Item</h3>
      <form action="/item/deleteItem" method="post">
        <div class="mb-3">
          <label class="form-label">Select Item</label>
          <select name="item_id" class="form-select">
            <?php foreach ($items as $item): ?>
            <option value="<?= htmlspecialchars($item->id) ?>">
              <?= htmlspecialchars($item->itemName) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-danger w-100">Delete Item</button>
      </form>
    </div>
  </div>
</body>
</html>
