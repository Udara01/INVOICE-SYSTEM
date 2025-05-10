<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - <?= $invoice->invoiceNo ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
@media print {
  .no-print {
    display: none !important;
  }
}
</style>

<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container mt-5">
  <h2 class="mb-4">Invoice Details</h2>

  <?php if (isset($invoice)): ?>
  <div class="card mb-4">
    <div class="card-body">
      <p><strong>Invoice No:</strong> <?= $invoice->invoiceNo ?></p>
      <p><strong>Customer:</strong> <?= $invoice->customer_name ?></p>
      <p><strong>Customer Address:</strong> <?= $invoice->customer_address ?></p>
      <p><strong>Customer Phone:</strong> <?= $invoice->customer_phone ?></p>

      <p><strong>Total Amount:</strong> <?= number_format($invoice->total_amount, 2) ?></p>
      <p><strong>Created By:</strong> <?= $invoice->created_by_name ?> | <strong>At:</strong> <?= $invoice->created_at ?></p>
      <p><strong>Updated By:</strong> <?= $invoice->updated_by_name ?> | <strong>At:</strong> <?= $invoice->updated_at ?></p>
    </div>
  </div>

  <h4 class="mb-3">Invoice Items</h4>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr class="text-center">
        <th>Item Name</th>
        <th>Description</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($invoice_items as $item): ?>
      <tr>
        <td class="text-center"><?= $item->itemName ?></td>
        <td><?= $item->productDescription ?></td>
        <td class="text-end"><?= number_format($item->price, 2) ?></td>
        <td class="text-end"><?= $item->quantity ?></td>
        <td class="text-end"><?= number_format($item->price * $item->quantity, 2) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot class="bg-light">
      <tr>
        <td colspan="3" class="text-center fw-bold">Total</td>
        <td class="text-end fw-bold"><?= number_format(array_sum(array_column($invoice_items, 'quantity')), 2) ?></td>
        <td class="text-end fw-bold"><?= number_format(array_reduce($invoice_items, fn($sum, $i) => $sum + ($i->price * $i->quantity), 0), 2) ?></td>
      </tr>
    </tfoot>
  </table>

  <?php else: ?>
    <p class="alert alert-warning">Invoice not found!</p>
  <?php endif; ?>
</div>
<center>
    <button class="no-print" onclick="window.print()">Print Invoice</button>
</center>

</body>
</html>
