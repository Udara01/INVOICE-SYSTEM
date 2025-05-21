<?php
//date_default_timezone_set('Asia/Colombo');
//echo date('F j, Y, g:i a');

$total_invoices = 0;
foreach($Customer_counts as $row){
  $total_invoices = $row->invoice_count + $total_invoices;
}


$total_returns = 0;
foreach($Return_count as $row){
    $total_returns = $row->return_invoice_count + $total_returns;
  }


$total_sales = 0;
foreach ($customers_total as $row) {
  $total_sales = $total_sales + $row->total_amount;
  }

$total_return_amount = 0;
  foreach ($Return_amounts as $row){
    $total_return_amount = $total_return_amount +  $row->total_return_amount;
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-color: #4e73df;
      --secondary-color: #1cc88a;
      --danger-color: #e74a3b;
      --warning-color: #f6c23e;
      --dark-color: #5a5c69;
      --light-bg: #f8f9fc;
    }
    
    body {
      background-color: var(--light-bg);
      font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    
    .card {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
    }
    
    .card:hover {
      box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    }
    
    .card-header {
      background-color: var(--light-bg);
      border-bottom: 1px solid #e3e6f0;
      padding: 1rem 1.5rem;
      font-weight: 600;
      color: var(--dark-color);
      border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    
    .dashboard-card {
      border-left: 0.35rem solid;
      transition: transform 0.3s;
      height: 100%;
    }
    
    .dashboard-card.primary {
      border-left-color: var(--primary-color);
    }
    
    .dashboard-card.success {
      border-left-color: var(--secondary-color);
    }
    
    .dashboard-card.warning {
      border-left-color: var(--warning-color);
    }
    
    .dashboard-card.danger {
      border-left-color: var(--danger-color);
    }
    
    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--dark-color);
    }
    
    .stat-label {
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #858796;
    }
    
    .summary-card {
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    
    .summary-table-container {
      flex-grow: 1;
      overflow: hidden;
    }
    
    .summary-table {
      max-height: 200px;
      overflow-y: auto;
      margin-bottom: 0;
    }
    
    .summary-table table {
      margin-bottom: 0;
      width: 100%;
    }
    
    .summary-table th {
      position: sticky;
      top: 0;
      background-color: white;
      z-index: 1;
    }
    
    .view-full-report {
      border-top: 1px solid #e3e6f0;
      padding: 0.75rem;
      text-align: center;
      background-color: var(--light-bg);
      border-radius: 0 0 0.5rem 0.5rem;
    }
    
    .compact-row {
      font-size: 0.9rem;
    }
    
    .compact-row td {
      padding: 0.5rem 1rem;
    }
    
    .invoice-number {
      font-weight: 600;
      color: var(--primary-color);
    }
    
    .total-amount {
      font-weight: 600;
      text-align: right;
    }
    
    .status-badge {
      font-size: 0.75rem;
      padding: 0.25rem 0.5rem;
    }
    
    .empty-state {
      padding: 1.5rem;
      text-align: center;
      color: #6c757d;
    }
    
    .hover-effect:hover {
      background-color: rgba(78, 115, 223, 0.05);
      cursor: pointer;
    }
    
    @media (max-width: 768px) {
      .stat-value {
        font-size: 1.25rem;
      }
      
      .compact-row {
        font-size: 0.85rem;
      }
    }
  </style>

  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
      drawCustomerTotalChart();
      drawReturnTotalChart();
      drawChartTotalInvoiceCount();
      drawChartTotalReturnInvoiceCount();
    }
  </script>
</head>
<body>
  <?php $this->load->view('layouts/navbar'); ?>
  
  <div class="container-fluid py-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard Overview</h1>
      <div class="d-none d-sm-inline-block">
        <span class="badge bg-light text-dark">
          <i class="bi bi-clock me-1"></i> Server Time: <?= date('F j, Y, g:i a') ?>
        </span>
      </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
      <div class="col-xl-3 col-md-6">
        <div class="card dashboard-card primary h-100">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="stat-label text-primary">Total Sales</div>
                <div class="stat-value">Rs. <?= number_format($total_sales ?? 0, 2) ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-currency-dollar fs-1 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3 col-md-6">
        <div class="card dashboard-card success h-100">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="stat-label text-success">Total Invoices</div>
                <div class="stat-value"><?= $total_invoices ?? 0 ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-receipt fs-1 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3 col-md-6">
        <div class="card dashboard-card warning h-100">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="stat-label text-warning">Return Invoice Amount</div>
                <div class="stat-value">
                  Rs. <?= number_format($total_return_amount ?? 0, 2) ?>
                </div>
              </div>
              <div class="col-auto">
                <i class="bi bi-arrow-counterclockwise fs-1 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card dashboard-card danger h-100">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="stat-label text-danger">Total Returns</div>
                <div class="stat-value"><?= $total_returns ?? 0 ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-arrow-return-left fs-1 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    

    <div class="row">
      <!-- Customer Total Amount Chart -->
      <div class="col-lg-6 mb-4">
        <div class="card">
          <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="bi bi-bar-chart-line me-2"></i>Customer Total Amount Chart
            </h6>
          </div>
          <div class="card-body">
            <?php $this->load->view('Dashboard/Charts/customerTotalAmount'); ?>
          </div>
        </div>
      </div>

      <!-- Return Invoice Total Chart -->
      <div class="col-lg-6 mb-4">
        <div class="card">
          <div class="card-header">
            <h6 class="m-0 font-weight-bold text-success">
              <i class="bi bi-bar-chart-line me-2"></i>Return Invoice Total Chart
            </h6>
          </div>
          <div class="card-body">
            <?php $this->load->view('Dashboard/Charts/returnInvoiceTotal'); ?>
          </div>
        </div>
      </div>
    </div>



    <div class="row">
      <!-- Customer Total Invoice Count Chart -->
      <div class="col-lg-6 mb-4">
        <div class="card">
          <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="bi bi-pie-chart me-2"></i>Customer Total Invoice Count Chart
            </h6>
          </div>
          <div class="card-body">
            <?php $this->load->view('Dashboard/Charts/totalInvoices'); ?>
          
          </div>
        </div>
      </div>

      <!-- Return Invoice Count Total Chart -->
      <div class="col-lg-6 mb-4">
        <div class="card">
          <div class="card-header">
            <h6 class="m-0 font-weight-bold text-success">
              <i class="bi bi-pie-chart me-2"></i>Total Return Invoice Count Chart
            </h6>
          </div>
          <div class="card-body">
            <?php $this->load->view('Dashboard/Charts/returnInvoicesCount'); ?>
          </div>
        </div>
      </div>
    </div>




    <!-- Reports Row -->
    <div class="row g-4">
      <!-- Invoice Report Summary -->
      <div class="col-lg-6">
        <div class="card summary-card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="bi bi-receipt me-2"></i>Recent Invoices
            </h6>
            <div>
              <a href="<?= base_url('Dashboard_controller/createInvoicesExcel') ?>" class="btn btn-sm btn-outline-success" title="Export Excel">
                <i class="bi bi-file-earmark-excel"></i>
              </a>
              <a href="<?= base_url('Dashboard_controller/exportInvoicesToPDF') ?>" class="btn btn-sm btn-outline-danger" title="Export PDF">
                <i class="bi bi-file-earmark-pdf"></i>
              </a>
            </div>
          </div>
          <div class="summary-table-container">
            <div class="summary-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Invoice No</th>
                    <th class="text-end">Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($Invoices) > 0): ?>
                    <?php $i = 1; foreach ($Invoices as $invoice): if ($i > 5) break; ?>
                    <tr class="compact-row hover-effect" onclick="window.open('<?= base_url('dashboard/invoice') ?>', '_blank')">
                      <td><?= $i++ ?></td>
                      <td class="invoice-number"><?= htmlspecialchars($invoice->invoiceNo) ?></td>
                      <td class="total-amount"><?= number_format($invoice->total_amount, 2) ?></td>
                      <td>
                        <span class="badge rounded-pill status-badge <?= $invoice->status == 'Paid' ? 'bg-success' : 'bg-danger' ?>">
                          <?= htmlspecialchars($invoice->status) ?>
                        </span>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="empty-state">No invoices found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="view-full-report">
            <a href="<?= base_url('dashboard/invoice') ?>" class="btn btn-link" target="_blank">
              <i class="bi bi-arrow-right-circle me-1"></i> View Full Invoice Report
            </a>
          </div>
        </div>
      </div>
      
      <!-- Return Invoice Report Summary -->
      <div class="col-lg-6">
        <div class="card summary-card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="bi bi-arrow-return-left me-2"></i>Recent Returns
            </h6>
            <div>
              <a href="<?= base_url('Dashboard_controller/exportReturnInvoiceExcel') ?>" class="btn btn-sm btn-outline-success" title="Export Excel">
                <i class="bi bi-file-earmark-excel"></i>
              </a>
              <a href="<?= base_url('Dashboard_controller/exportReturnInvoicePDF') ?>" class="btn btn-sm btn-outline-danger" title="Export PDF">
                <i class="bi bi-file-earmark-pdf"></i>
              </a>
            </div>
          </div>
          <div class="summary-table-container">
            <div class="summary-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Return No</th>
                    <th class="text-end">Amount</th>
                    <th>Original Inv.</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($Returns) > 0): ?>
                    <?php $i = 1; foreach ($Returns as $Return): if ($i > 5) break; ?>
                    <tr class="compact-row hover-effect" onclick="window.open('<?= base_url('dashboard/returnInv') ?>', '_blank')">
                      <td><?= $i++ ?></td>
                      <td class="invoice-number"><?= htmlspecialchars($Return->return_invoice_no) ?></td>
                      <td class="total-amount"><?= number_format($Return->total_return_amount, 2) ?></td>
                      <td><?= htmlspecialchars($Return->original_invoice_no) ?></td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="empty-state">No return invoices found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="view-full-report">
            <a href="<?= base_url('dashboard/returnInv') ?>" class="btn btn-link" target="_blank">
              <i class="bi bi-arrow-right-circle me-1"></i> View Full Return Report
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>



  
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    
    document.querySelectorAll('.hover-effect').forEach(row => {
      row.addEventListener('click', (e) => {
        
        if (!e.target.closest('a') && !e.target.closest('button')) {
          const link = row.closest('.card').querySelector('.view-full-report a');
          if (link) {
            window.open(link.href, '_blank');
          }
        }
      });
    });
  </script>
</body>
</html>