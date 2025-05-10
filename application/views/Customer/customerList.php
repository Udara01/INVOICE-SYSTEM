<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    table input {
      min-width: 150px;
    }
  </style>
</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Customer List</h4>
    </div>
    <div class="card-body">
      <?php if (!empty($customers)): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Action</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
              <form action="<?= site_url('Customer_controller/update_Customer/' . $customer->id) ?>" method="post">
                <td class="text-center"><?= htmlspecialchars($customer->id) ?></td>
                <td><input type="text" name="customer_name" class="form-control" value="<?= htmlspecialchars($customer->name) ?>"></td>
                <td><input type="text" name="customer_address" class="form-control" value="<?= htmlspecialchars($customer->address) ?>"></td>
                <td><input type="text" name="customer_phone" class="form-control" value="<?= htmlspecialchars($customer->phone) ?>"></td>
                <td class="text-center">
                  <button type="submit" class="btn btn-success btn-sm">Update</button>
                </td>
              </form>
              <td class="text-center">
                <form action="<?= site_url('Customer_controller/delete_Customer/' . $customer->id) ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <div class="alert alert-warning">No customers found.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
