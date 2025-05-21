<?php

$chartData = [];

foreach($Customer_counts as $row){
  foreach($customers as $Customer){
    if($row->customer_id == $Customer->id)
    $chartData[] = [$Customer -> name, (float)$row->invoice_count];
  }
  
}

?>
<form method="get" class="row g-3 mb-4">
  <div class="col-md-4">
    <label class="form-label">From</label>
    <input type="date" name="from_date_3" value="<?= htmlspecialchars($_GET['from_date_3'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">To</label>
    <input type="date" name="to_date_3" value="<?= htmlspecialchars($_GET['to_date_3'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">Customer</label>
    <select name="customer_id_3" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($customers as $customer): ?>
        <option value="<?= $customer->id ?>" <?= (($_GET['customer_id_3'] ?? '') == $customer->id) ? 'selected' : '' ?>>
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
<script>
    //google.charts.load('current', {packages: ['corechart']});
    //google.charts.setOnLoadCallback(drawChart);

    function drawChartTotalInvoiceCount(){
      var data = google.visualization.arrayToDataTable([
        ['Customer', 'Invoice_Count'],
        ...<?php echo json_encode($chartData); ?>
      ]);

      var options = {
          title: 'Total Invoices',
          is3D: true,
        };

      var chart = new google.visualization.PieChart(document.getElementById('totalInvoiceChart'));

      chart.draw(data, options);

    }
</script>


  <div id="totalInvoiceChart" style="width: 700px; height: 400px;"></div>
