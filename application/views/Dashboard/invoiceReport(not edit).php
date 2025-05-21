<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<a href="<?= base_url('Dashboard_controller/createInvoicesExcel') ?>" class="btn btn-success">Export to Excel</a>

<a href="<?= base_url('Dashboard_controller/exportInvoicesToPDF') ?>" class="btn btn-danger">Export to PDF</a>


<form method="get" action="">
  <label>From: <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>"></label>
  <label>To: <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>"></label>

  <label>Customer:
    <select name="customer_id">
      <option value="">-- All --</option>
      <?php foreach ($Customers as $customer): ?>
        <option value="<?= $customer->id ?>" <?= (($_GET['customer_id'] ?? '') == $customer->id) ? 'selected' : '' ?>>
          <?= htmlspecialchars($customer->name) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>Status:
    <select name="status">
      <option value="">-- All --</option>
      <option value="Paid" <?= (($_GET['status'] ?? '') == 'Paid') ? 'selected' : '' ?>>Paid</option>
      <option value="Unpaid" <?= (($_GET['status'] ?? '') == 'Unpaid') ? 'selected' : '' ?>>Unpaid</option>
    </select>
  </label>

  <button type="submit">Filter</button>
</form>


  <table>
    <tr>
      <th>#</th>
      <th>InvoiceID</th>
      <th>Date</th>
      <th>Customer</th>
      <th>Items</th>
      <th>Total (Rs.)</th>
      <th>Status</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($Invoices as $invoice): ?>
    <tr>
      <td><?= $i++  ?></td>
      <td><?= htmlspecialchars($invoice->invoiceNo) ?></td>
      <td><?= htmlspecialchars($invoice->created_at) ?></td>
      <td><?= htmlspecialchars($invoice->customer_name) ?></td>
      <td><?= htmlspecialchars($invoice->item_count) ?></td>

      <td><?= htmlspecialchars($invoice->total_amount) ?></td>
      <td><?= htmlspecialchars($invoice->status) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>


</body>
</html>