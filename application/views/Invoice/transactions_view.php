<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Transactions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>


<div class="container my-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white text-center">
      <h3 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Customer Transactions</h3>
    </div>

    <div class="card-body">
      <?php if (!empty($transactions)): ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light text-center">
              <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Date</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transactions as $t): ?>
                <tr>
                  <td class="text-center">
                    <?php if ($t->type === 'invoice'): ?>
                      <a href="<?= site_url('Customer_invoice/print_invoice/' . $t->id) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-file-earmark-text"></i> #<?= $t->id ?>
                      </a>
                    <?php elseif ($t->type === 'return_invoice'): ?>
                      <a href="<?= site_url('ReturnInvoice_controller/view_return_invoice/' . $t->id) ?>" target="_blank" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> #<?= $t->id ?>
                      </a>
                    <?php else: ?>
                      <span class="text-muted">#<?= $t->id ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($t->type === 'invoice'): ?>
                      <span class="badge bg-success text-uppercase"><?= $t->type ?></span>
                    <?php elseif ($t->type === 'return_invoice'): ?>
                      <span class="badge bg-danger text-uppercase"><?= $t->type ?></span>
                    <?php else: ?>
                      <span class="badge bg-secondary text-uppercase"><?= $t->type ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center"><?= date('d M Y', strtotime($t->date)) ?></td>
                  <td class="text-end fw-bold text-primary">Rs. <?= number_format($t->total, 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">
          <i class="bi bi-info-circle-fill me-2"></i>No transactions found for this customer.
        </div>
      <?php endif; ?>

      <div class="text-center mt-4">
        <a href="<?= site_url('invoicelist') ?>" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left-circle me-1"></i>Back to Invoice List
        </a>
      </div>
    </div>
  </div>
</div>


</body>
</html>
