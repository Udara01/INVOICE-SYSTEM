<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invoice Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .table thead th {
      vertical-align: middle;
    }

    .btn-sm i {
      margin-right: 4px;
    }

    .empty-message {
      font-size: 1.1rem;
      padding: 20px;
      background: #f8f9fa;
      border-radius: 8px;
    }

    .card {
      border-radius: 12px;
    }
  </style>
</head>
<body>
  <?php $this->load->view('layouts/navbar'); ?>

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0"><i class="bi bi-receipt-cutoff me-2 text-primary"></i>Invoices</h2>
      <a href="/invoiceform" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Invoice
      </a>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark text-center">
              <tr>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($invoices)): ?>
                <?php foreach ($invoices as $invoice): ?>
                  <tr>
                    <td class="text-center">#<?= $invoice->invoiceNo ?></td>
                    <td>
                      <a href="<?= site_url('Customer_controller/customer_transactions/' . $invoice->customer_id) ?>" 
                         class="text-decoration-none fw-semibold text-primary">
                        <i class="bi bi-person-circle me-1"></i><?= $invoice->customer_name ?>
                      </a>
                    </td>
                    <td class="text-end">Rs. <?= number_format($invoice->total_amount, 2) ?></td>
                    <td class="text-center"><?= date("d M Y", strtotime($invoice->created_at)) ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('Customer_invoice/edit_invoice/' . $invoice->id) ?>" class="btn btn-warning btn-sm me-1">
                        <i class="bi bi-pencil-square"></i>Edit
                      </a>
                      <a href="<?= site_url('Customer_invoice/delete_invoice/' . $invoice->id) ?>" 
                         class="btn btn-danger btn-sm me-1" 
                         onclick="return confirm('Delete this invoice?');">
                        <i class="bi bi-trash3"></i>Delete
                      </a>
                      <a href="<?= site_url('Customer_invoice/print_invoice/' . $invoice->id) ?>" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i>View
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center empty-message text-muted">
                    <i class="bi bi-folder-x fs-4 d-block mb-2"></i>
                    No invoices found.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
