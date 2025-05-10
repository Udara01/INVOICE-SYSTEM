<!--DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Home Page</h1>

  <?php /* $this->load->view('Item/updateItem', ['items' => $items]); */?>

  <a href="http://localhost:8000/additem">Add Item</a> <br>
  <a href="http://localhost:8000/deleteItem">Delete Item</a> <br>

</body>
</html-->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php $this->load->view('layouts/navbar'); ?>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1>Home Page</h1>
      <div>
        <a href="/additem" class="btn btn-success me-2">Add Item</a>
        <a href="/updateItem" class="btn btn-primary">Update Item</a>
      </div>
    </div>
    <?php if (validation_errors()): ?>
          <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>
    <?php /*$this->load->view('Item/updateItem', ['items' => $items]);*/ ?>
    <?php $this->load->view('Item/itemList', ['items' => $items]); ?>
  </div>
</body>
</html>
