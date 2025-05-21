<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
  <?php $this->load->view('layouts/navbar'); ?>


  <h1>Dashboard</h1>

  
 <dic class="card">
    <?php $this->load->view('Dashboard/invoiceReport'); ?>
  </dic>

  <dic class="card">
    <?php $this->load->view('Dashboard/returnInvoiceReport'); ?>
  </dic>


</body>
</html>