<?php
// Convert PHP array into JavaScript array
$chartData = [];

foreach ($customers_total as $row) {
    foreach($customers as $customer){
      if(($customer->id) == ($row->customer_id)){
        $chartData[] = [$customer->name, (float)$row->total_amount];
      }
}
}


?>

  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart(){
      // Pass PHP data to JS safely as JSON
    var data = google.visualization.arrayToDataTable([
      ['Customer', 'Total Amount'],
      ...<?php echo json_encode($chartData); ?>
    ]);


      var options = {
        title: 'Customer Total Invoice Amount',
        hAxis: { title: 'Customer' },
        vAxis: { title: 'Total Amount' },
        legend: { position: 'none' }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
<h2>Customer Invoice Totals</h2>

<form method="get" action="" class="row g-3 mb-4">
  <div class="col-md-3">
    <label class="form-label">From</label>
    <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">To</label>
    <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Customer</label>
    <select name="customer_id" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($customers as $customer): ?>
        <option value="<?= $customer->id ?>" <?= (($_GET['customer_id'] ?? '') == $customer->id) ? 'selected' : '' ?>>
          <?= htmlspecialchars($customer->name) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button type="submit" class="btn btn-primary me-2">Filter</button>
    <a href="<?= current_url() ?>" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-counterclockwise"></i> Reset
    </a>
  </div>
</form>

<!-- Chart -->
<div id="chart_div" style="width: 100%; height: 400px;"></div>
</body>
