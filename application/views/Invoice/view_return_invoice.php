<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Return Invoice Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f4f4f4;
    }
    h1, h3 {
      color: #333;
    }
    .invoice-container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    .actions {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }
    .btn {
      padding: 10px 20px;
      background-color: #007bff;
      border: none;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #0056b3;
    }

    @media print {
      .actions {
        display: none;
      }
      body {
        background-color: white;
      }
    }
  </style>
</head>
<body>

<div class="invoice-container">
  <h1>Return Invoice Details</h1>

    <div>
      <h3>Return Invoice: <?= $return_invoice->return_invoice_no ?></h3>
      <p><strong>Original Invoice No:</strong> <?= $return_invoice->invoiceNo ?></p>
      <p><strong>Invoice Data:</strong> <?= $return_invoice->created_at ?></p>
      <p><strong>Customer:</strong> <?= $return_invoice->customer_name ?></p>
      <p><strong>Reason:</strong> <?= $return_invoice->reason ?></p>
      <p><strong>Return Date:</strong> <?= $return_invoice->return_date ?></p>
      <p><strong>Total Return Amount:</strong> <?= number_format($return_invoice->total_return_amount, 2) ?></p>
    </div>


  <h3>Returned Items</h3>
  <table>
    <thead>
      <tr class="text-center">
        <th class="text-center">Item Name</th>
        <th class="text-center">Quantity</th>
        <th class="text-center">Unit Price</th>
        <th class="text-center">Total</th>
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

  <div class="actions">
    <a href="<?= site_url('returnInvoices/list') ?>" class="btn">Back to Invoice List</a>
    <button onclick="window.print()" class="btn">Print</button>
  </div>
</div>

</body>
</html>
