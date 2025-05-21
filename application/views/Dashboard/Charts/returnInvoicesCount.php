<?php
  $chartData = [];

  foreach($Return_count as $row){
    foreach($customers as $customer){
      if($row->customer_id == $customer->id){
        $chartData[] = [$customer->name, (float)$row->return_invoice_count];
      }
    }
  }
?>

<form method="get" class="row g-3 mb-4">
  <div class="col-md-4">
    <label class="form-label">From</label>
    <input type="date" name="from_date_4" value="<?= htmlspecialchars($_GET['from_date_4'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">To</label>
    <input type="date" name="to_date_4" value="<?= htmlspecialchars($_GET['to_date_4'] ?? '') ?>" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">Customer</label>
    <select name="customer_id_4" class="form-select">
      <option value="">-- All --</option>
      <?php foreach ($customers as $customer): ?>
        <option value="<?= $customer->id ?>" <?= (($_GET['customer_id_4'] ?? '') == $customer->id) ? 'selected' : '' ?>>
          <?= htmlspecialchars($customer->name) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-12 text-end">
    <button type="submit" class="btn btn-success">Filter</button>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary">Reset</a>
  </div>
</form>

<script>
  //google.charts.load('current', {packages: ['corechart']});
  //google.charts.setOnLoadCallback(drawChart);

  function drawChartTotalReturnInvoiceCount(){
    var data = google.visualization.arrayToDataTable([
        ['Customer', 'Return_Invoice_Count'],
        ...<?php echo json_encode($chartData); ?>
      ]);

      var options = {
          title: 'Total Return Invoices',
          is3D: true,
        };

      var chart = new google.visualization.PieChart(document.getElementById('TotalReturnChart'));

      chart.draw(data, options);

    }
</script>

  <div id="TotalReturnChart" style="width: 700px; height: 400px;"></div>

  