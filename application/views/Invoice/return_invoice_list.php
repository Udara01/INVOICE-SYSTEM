<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Return Invoice List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php $this->load->view('layouts/navbar'); ?>

  <div class="container mt-5">
    <div class="card shadow p-4">
      <h2 class="mb-4 text-primary">All Return Invoices</h2>

      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <?= $this->session->flashdata('success') ?>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
          <thead class="table-light">
            <tr class="text-center">
              <th>Return Invoice No</th>
              <th>Original Invoice No</th>
              <th>Customer</th>
              <th>Return Date</th>
              <th>Total Return Amount</th>
              <th>Reason</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($return_invoices as $invoice): ?>
              <tr>
                <td class="text-center"><?= $invoice->return_invoice_no ?></td>
                <td class="text-center"><?= $invoice->invoiceNo ?></td>
                <td class="text-center"><?= $invoice->customer_name ?></td>
                <td class="text-center"><?= date('d M Y', strtotime($invoice->return_date)) ?></td>
                <td class="text-end">Rs. <?= number_format($invoice->total_return_amount, 2) ?></td>
                <td><?= htmlspecialchars($invoice->reason) ?></td>
                <td class="text-center">
                  <a href="<?= site_url('ReturnInvoice_controller/view_return_invoice/' . $invoice->id) ?>" class="btn btn-sm btn-outline-primary me-1">
                    View
                  </a>
                  <a href="<?= site_url('ReturnInvoice_controller/edit_return_invoice/' . $invoice->id) ?>" class="btn btn-sm btn-outline-warning me-1">
                    Edit
                  </a>
                  <a href="<?= site_url('ReturnInvoice_controller/delete_return_invoice/' . $invoice->id) ?>" class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Are you sure you want to delete this return invoice?');">
                    Delete
                  </a>
                </td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
