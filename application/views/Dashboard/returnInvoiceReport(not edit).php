<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body>
  <a href="<?= base_url('Dashboard_controller/exportReturnInvoiceExcel') ?>" class="btn btn-success">Export as Excel</a>

    <a href="<?= base_url('Dashboard_controller/exportReturnInvoicePDF') ?>" class="btn btn-danger">Export as PDF</a>

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
        <td><?= htmlspecialchars($Return->original_invoice_no) ?></td>
        <td><?= htmlspecialchars($Return->customer_name) ?></td>
        <td><?= htmlspecialchars($Return->return_date) ?></td>
        <td><?= htmlspecialchars($Return->total_return_amount) ?></td>
        <td><?= htmlspecialchars($Return->reason) ?></td>
        <td><?= htmlspecialchars($Return->return_count) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>