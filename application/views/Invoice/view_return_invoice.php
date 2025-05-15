<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Return Invoice Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  @media print {
    .no-print {
      display: none !important;
    }
  }
</style>

</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container my-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h2 class="mb-0">Return Invoice Details</h2>
    </div>
    <div class="card-body">
      <div class="mb-4">
        <h4 class="text-secondary">Return Invoice: <?= $return_invoice->return_invoice_no ?></h4>
        <p><strong>Original Invoice No:</strong> <?= $return_invoice->invoiceNo ?></p>
        <p><strong>Invoice Date:</strong> <?= $return_invoice->created_at ?></p>
        <p><strong>Customer:</strong> 
          <a href="<?= site_url('Customer_controller/customer_transactions/' . $return_invoice->customer_id) ?>" 
            class="text-decoration-none text-primary">
            <?= $return_invoice->customer_name ?>
          </a>
        </p>
        <p><strong>Reason:</strong> <?= $return_invoice->reason ?></p>
        <p><strong>Return Date:</strong> <?= $return_invoice->return_date ?></p>
        <p><strong>Total Return Amount:</strong> 
          <span class="text-success fw-bold">Rs. <?= number_format($return_invoice->total_return_amount, 2) ?></span>
        </p>
      </div>

      <h4 class="mt-4">Returned Items</h4>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Unit Price (Rs. )</th>
              <th>Total (Rs. )</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($returned_items as $item): ?>
            <tr>
              <td><?= $item->itemName ?></td>
              <td class="text-end"><?= $item->quantity ?></td>
              <td class="text-end"><?= number_format($item->unit_price, 2) ?></td>
              <td class="text-end"><?= number_format($item->total, 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="mt-4 d-flex justify-content-between no-print">
        <a href="<?= site_url('returnInvoices/list') ?>" class="btn btn-secondary">Back to Invoice List</a>
        <button onclick="window.print()" class="btn btn-success">Print</button>
      </div>

    </div>
  </div>
</div>

</body>

</html>
