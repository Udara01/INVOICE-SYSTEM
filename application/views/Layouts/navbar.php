<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/app/home">Item</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/additem">Add Item</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/updateItem">Update Item</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/deleteItem">Delete Item</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/categoryadd">Manage Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/invoice">Invoice</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/invoicelist">Invoice List</a>
        </li>

        <li class="nav-item">
        <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
