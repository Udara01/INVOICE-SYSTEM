<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
      .navbar-nav .nav-link {
        transition: all 0.3s ease;
      }

      .navbar-nav .nav-link:hover,
      .navbar-nav .nav-link:focus {
        color: #ffc107 !important;
        transform: scale(1.05);
      }

      .navbar-brand:hover {
        color: #0dcaf0 !important;
      }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top mb-4">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="/app/home">
      <i class="bi bi-box-seam me-2"></i>Item Manager
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/additem"><i class="bi bi-plus-square me-1"></i>Add Item</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/updateItem"><i class="bi bi-pencil-square me-1"></i>Update Item</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/deleteItem"><i class="bi bi-trash3 me-1"></i>Delete Item</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/categoryadd"><i class="bi bi-tags me-1"></i>Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/invoice"><i class="bi bi-receipt me-1"></i>Invoice</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/invoicelist"><i class="bi bi-list-ul me-1"></i>Invoice List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/returnInvoices/list"><i class="bi bi-arrow-counterclockwise me-1"></i>Return Invoices</a>
        </li>
        <li class="nav-item ms-lg-3 mt-1">
          <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm d-flex align-items-center">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>