<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <table>
    <tr>
      <th>#</th>
      <th>Return Invoice No	</th>
      <th>Original Invoice No	</th>
      <th>Customer</th>
      <th>Return Date	</th>
      <th>Total Return Amount	</th>
      <th>Reason</th>
      <th>Items</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($Returns as $Return): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($Return->return_invoice_no) ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>