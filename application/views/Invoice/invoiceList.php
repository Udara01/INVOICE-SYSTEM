<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Invoices</h2>
    <a href="/invoiceform" class="btn btn-success">+ Add Invoice</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>Invoice No</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($invoices as $invoice): ?>
              <tr>
                <td><?= $invoice->invoiceNo ?></td>
                <td><?= $invoice->customer_name ?></td>
                <td>Rs. <?= number_format($invoice->total_amount, 2) ?></td>
                <td><?= date("d M Y", strtotime($invoice->created_at)) ?></td>
                <td>
                  <a href="<?= site_url('Customer_invoice/edit_invoice/' . $invoice->id) ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                  <a href="<?= site_url('Customer_invoice/delete_invoice/' . $invoice->id) ?>" class="btn btn-danger btn-sm me-1" onclick="return confirm('Delete this invoice?');">Delete</a>
                  <a href="<?= site_url('Customer_invoice/print_invoice/' . $invoice->id) ?>" class="btn btn-info btn-sm">View</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if (empty($invoices)): ?>
          <p class="text-center text-muted mt-3">No invoices found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

</body>
</html>
