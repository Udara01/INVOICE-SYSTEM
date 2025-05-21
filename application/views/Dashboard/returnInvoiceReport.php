<?php
$query_string = http_build_query($_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Return Invoice Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-color: #4e73df;
      --secondary-color: #1cc88a;
      --danger-color: #e74a3b;
      --warning-color: #f6c23e;
      --dark-color: #5a5c69;
    }
    
    body {
      background-color: #f8f9fc;
      font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      padding: 20px;
    }
    
    .report-container {
      max-width: 1400px;
      margin: 0 auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      padding: 25px;
    }
    
    .report-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      border-bottom: 1px solid #e3e6f0;
      padding-bottom: 15px;
    }
    
    .report-title {
      color: var(--dark-color);
      font-weight: 700;
      margin: 0;
    }
    
    .export-buttons .btn {
      margin-left: 10px;
    }
    
    .filter-section {
      background-color: #f8f9fc;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 25px;
    }
    
    .filter-form {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      align-items: end;
    }
    
    .filter-group {
      margin-bottom: 0;
    }
    
    .filter-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: var(--dark-color);
      font-size: 0.9rem;
    }
    
    .filter-group input,
    .filter-group select {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #d1d3e2;
      border-radius: 4px;
      font-size: 0.9rem;
    }
    
    .filter-actions {
      display: flex;
      gap: 10px;
    }
    
    .table-container {
      overflow-x: auto;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    
    th {
      background-color: var(--primary-color);
      color: white;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      position: sticky;
      top: 0;
    }
    
    td {
      padding: 12px 15px;
      border-bottom: 1px solid #e3e6f0;
    }
    
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    
    tr:hover {
      background-color: #f1f1f1;
    }
    
    .text-right {
      text-align: right;
    }
    
    .text-center {
      text-align: center;
    }
    
    .reason-cell {
      max-width: 250px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .badge-return {
      background-color: var(--danger-color);
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 0.8rem;
    }
    
    @media (max-width: 768px) {
      .filter-form {
        grid-template-columns: 1fr;
      }
      
      .report-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
      
      .export-buttons {
        width: 100%;
        display: flex;
        justify-content: space-between;
      }
      
      .export-buttons .btn {
        margin-left: 0;
        flex: 1;
        margin: 0 5px;
      }
      
      .reason-cell {
        max-width: 150px;
      }
    }
  </style>
</head>
<body>
  
  <div class="report-container">
    <div class="report-header">
      <h1 class="report-title">Return Invoice Report</h1>
      <div class="export-buttons">
        <a href="<?= base_url('Dashboard_controller/exportReturnInvoiceExcel?' .$query_string) ?>" class="btn btn-success">
          <i class="bi bi-file-earmark-excel"></i> Export as Excel
        </a>
        <a href="<?= base_url('Dashboard_controller/exportReturnInvoicePDF?' .$query_string) ?>" class="btn btn-danger">
          <i class="bi bi-file-earmark-pdf"></i> Export as PDF
        </a>
      </div>
    </div>
    
    <div class="filter-section">
      <form method="get" action="" class="filter-form">
        <div class="filter-group">
          <label>From Date</label>
          <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>" class="form-control">
        </div>
        
        <div class="filter-group">
          <label>To Date</label>
          <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>" class="form-control">
        </div>
        
        <div class="filter-group">
          <label>Customer</label>
          <select name="customer_id" class="form-select">
            <option value="">All Customers</option>
            <?php foreach ($Customers as $customer): ?>
              <option value="<?= $customer->id ?>" <?= (($_GET['customer_id'] ?? '') == $customer->id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($customer->name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="filter-group">
          <label>Return Invoice No</label>
          <input type="text" name="invoice_no" value="<?= htmlspecialchars($_GET['invoice_no'] ?? '') ?>" class="form-control" placeholder="Enter invoice number">
        </div>
        
        <div class="filter-group filter-actions">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-funnel"></i> Filter
          </button>
          <a href="<?= current_url() ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
          </a>
        </div>
      </form>
    </div>
    
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Return Invoice No</th>
            <th>Original Invoice No</th>
            <th>Customer</th>
            <th>Return Date</th>
            <th class="text-right">Total Amount (Rs.)</th>
            <th>Reason</th>
            <th class="text-center">Items</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($Returns) > 0): ?>
            <?php $i = 1; ?>
            <?php foreach ($Returns as $Return): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td>
                <span class="badge-return"><?= htmlspecialchars($Return->return_invoice_no) ?></span>
              </td>
              <td><?= htmlspecialchars($Return->original_invoice_no) ?></td>
              <td><?= htmlspecialchars($Return->customer_name) ?></td>
              <td><?= date('M d, Y', strtotime($Return->return_date)) ?></td>
              <td class="text-right"><?= number_format($Return->total_return_amount, 2) ?></td>
              <td class="reason-cell" title="<?= htmlspecialchars($Return->reason) ?>">
                <?= htmlspecialchars($Return->reason) ?>
              </td>
              <td class="text-center"><?= htmlspecialchars($Return->return_count) ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">No return invoices found matching your criteria</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>