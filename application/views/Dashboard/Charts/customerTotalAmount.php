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

<form method="get" class="row g-3 mb-4">
  <div class="col-md-4">
    <label class="form-label">From</label>
    <input type="date" name="from_date_1" value="<?= htmlspecialchars($_GET['from_date_1'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">To</label>
    <input type="date" name="to_date_1" value="<?= htmlspecialchars($_GET['to_date_1'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">Customer</label>
    <select name="customer_id_1" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($customers as $customer): ?>
        <option value="<?= $customer->id ?>" <?= (($_GET['customer_id_1'] ?? '') == $customer->id) ? 'selected' : '' ?>>
          <?= htmlspecialchars($customer->name) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-12 text-end">
    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary">Reset</a>
  </div>
</form>

<div id="customer_chart_div" style="width: 100%; height: 400px;"></div>

<script>
  function drawCustomerTotalChart() {
    var data = google.visualization.arrayToDataTable([
      ['Customer', 'Total Amount'],
      ...<?= json_encode($chartData) ?>
    ]);
    var options = {
      title: 'Customer Total Invoice Amount',
      hAxis: { title: 'Customer' },
      vAxis: { title: 'Total Amount' },
      legend: { position: 'none' }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById('customer_chart_div'));
    chart.draw(data, options);
  }
</script>

