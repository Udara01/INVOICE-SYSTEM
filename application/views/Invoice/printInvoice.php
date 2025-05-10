<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <style>
    :root {
      --primary-color: #4a6baf;
      --secondary-color: #f8f9fa;
      --accent-color: #e9ecef;
      --text-color: #212529;
      --border-color: #dee2e6;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: var(--text-color);
      max-width: 800px;
      margin: 0 auto;
      padding: 2rem;
      background-color: white;
    }
    
    .invoice-container {
      border: 1px solid var(--border-color);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    .invoice-header {
      background-color: var(--primary-color);
      color: white;
      padding: 1.5rem;
      text-align: center;
    }
    
    .invoice-header h2 {
      margin: 0;
      font-size: 1.8rem;
    }
    
    .invoice-details {
      display: flex;
      justify-content: space-between;
      background-color: var(--secondary-color);
      padding: 1rem 1.5rem;
      border-bottom: 1px solid var(--border-color);
    }
    
    .invoice-body {
      padding: 1.5rem;
    }
    
    .invoice-item {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 1rem;
      padding: 1rem 0;
      border-bottom: 1px solid var(--accent-color);
    }
    
    .invoice-item:last-child {
      border-bottom: none;
    }
    
    .invoice-item-header {
      font-weight: bold;
      background-color: var(--accent-color);
      padding: 0.75rem 1rem;
    }
    
    .invoice-total {
      text-align: right;
      margin-top: 2rem;
      font-size: 1.2rem;
      font-weight: bold;
    }
    
    .invoice-footer {
      text-align: center;
      padding: 1rem;
      background-color: var(--secondary-color);
      font-size: 0.9rem;
      color: #6c757d;
    }
    
    button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 1.5rem;
      transition: background-color 0.3s;
    }
    
    button:hover {
      background-color: #3a5a9f;
    }
    
    @media print {
      button { display: none; }
      body {
        padding: 0;
      }
      .invoice-container {
        box-shadow: none;
        border: none;
      }
    }
    
    
    .customer-info, .item-info {
      margin-bottom: 1.5rem;
    }
    
    .info-label {
      font-weight: bold;
      color: var(--primary-color);
      display: inline-block;
      min-width: 120px;
    }
  </style>
</head>
<body>
  <div class="invoice-container">
    <div class="invoice-header">
      <h2>INVOICE</h2>
    </div>
    
    <div class="invoice-details">
      <div>
        <strong>Invoice Date:</strong> <?= date('F j, Y') ?>
      </div>
      <div>
        <strong>Invoice ID:</strong> <?= $invoice->id ?>
      </div>
    </div>
    
    <div class="invoice-body">
      <div class="customer-info">
        <h3>Customer Information</h3>
        <p><span class="info-label">Name:</span> <?= $invoice->customerName ?></p>
      </div>
      
      <div class="item-info">
        <h3>Item Details</h3>
        <div class="invoice-item-header invoice-item">
          <div>Description</div>
          <div>Item</div>
          <div>Price</div>
        </div>
        <div class="invoice-item">
          <div><?= $invoice->description ?></div>
          <div><?= $invoice->itemName ?></div>
          <div>RS. <?= number_format($invoice->price, 2) ?></div>
        </div>
      </div>
      
      <div class="invoice-total">
        <p>Total Amount: <strong>RS. <?= number_format($invoice->price, 2) ?></strong></p>
      </div>
    </div>
    
    <div class="invoice-footer">
      <p>Thank you for your business!</p>
      <p>If you have any questions about this invoice, please contact us.</p>
    </div>
  </div>

  <center>
    <button onclick="window.print()">Print Invoice</button>
  </center>
</body>
</html>