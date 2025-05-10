<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>customers</title>
</head>
<body>
  <?php foreach ($customers as $customer); ?>
  <h1>Customer List</h1>
</body>
  <table>
    
      <tr>
      <th>Customer ID</th>
      <th>Customer Name</th>
      <th>Customer Address</th>
      <th>Customer Phone</th>
      <th>Action</th>
    </tr>
    <?php foreach ($customers as $customer): ?>
    <tr>
      <form action="<?= site_url('Customer_controller/update_Customer/' . $customer->id) ?>" method="post">
      <td><?= htmlspecialchars($customer->id) ?></td>
      <td><input type="text" name="customer_name" value="<?= htmlspecialchars($customer->name) ?>"> </td>
      <td><input type="text" name="customer_address" value="<?= htmlspecialchars($customer->address) ?>"></td>
      <td><input type="text" name="customer_phone" value="<?= htmlspecialchars($customer->phone) ?>"></td>
      <td>
        <button type="submit">Update</button>
      </td>
      </form>
    </tr>
    <?php endforeach; ?>
    
  </table>

  
</body>
</html>