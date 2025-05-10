<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Customer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
<?php $this->load->view('layouts/navbar'); ?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Customer</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="/add-customer">
              <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control">
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
              </div>

              <button type="submit" class="btn btn-success w-100 mb-2">Save Customer</button>

             
              <a href="/customerlist" class="btn btn-outline-secondary w-100">View Customer List</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-jxv5Opx1Nf9s+59G9Uq27eNYoRwYV3m+EkliPZJG8lnrTPbgr5DrtE0R3P+WzTkg" crossorigin="anonymous"></script>
</body>
</html>
