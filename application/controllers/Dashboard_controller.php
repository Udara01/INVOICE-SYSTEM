<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property Item_model $Item_model
 * @property Invoice_model $Invoice_model
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_output $output
 * @property CI_Router $router
 * @property Invoice_items_model $Invoice_items_model
 * @property Customer_invoices_model $Customer_invoices_model
 * @property Customer_model $Customer_model
 * @property Invoice_return_model $Invoice_returns_model
 * @property CI_DB_query_builder|CI_DB_driver $db
 * 
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Dashboard_controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_model');
        $this->load->model('Item_model');
        $this->load->model('Customer_invoices_model');
        $this->load->model('Invoice_items_model');
        $this->load->model('Customer_model'); 
        $this->load->model('Invoice_returns_model');
        $this->load->library('form_validation');
    }


    public function index(){

        $data['Invoices'] = $this->Customer_invoices_model->GetAllInvoices();


        $this->load->view('Dashboard/page', $data);
    }

    public function showInvoice(){

    $data['Invoices'] = $this->Customer_invoices_model->GetAllInvoices();
    $this->load->view('Dashboard/invoiceReport', $data);
    }


public function downloadExcel(){
    // Turn off output buffering to prevent unwanted output
    ob_end_clean();

    $spreadsheet = new Spreadsheet(); // Create new Spreadsheet object

    $sheet = $spreadsheet->getActiveSheet();

    // manually set table data value
    $sheet->setCellValue('A1', 'Gipsy Danger'); 
    $sheet->setCellValue('A2', 'Gipsy Avenger');
    $sheet->setCellValue('A3', 'Striker Eureka');

    $writer = new Xlsx($spreadsheet);// instantiate Xlsx

    $filename = 'list-of-jaegers';// set filename for excel file to be exported

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');// generate excel file
    header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');// download file 
    exit;
}


public function createInvoicesExcel(){
    // Get all invoice data from the model
    $invoices = $this->Customer_invoices_model->GetAllInvoices();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

     // Set column headers
    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Invoice No');
    $sheet->setCellValue('C1', 'Date');
    $sheet->setCellValue('D1', 'Customer');
    $sheet->setCellValue('E1', 'Items');
    $sheet->setCellValue('F1', 'Total (Rs.)');
    $sheet->setCellValue('G1', 'Status');


    // Fill data
    $row = 2;
    $i = 1;
    foreach ($invoices as $invoice) {
        $sheet->setCellValue("A$row", $i++);
        $sheet->setCellValue("B$row", $invoice->invoiceNo);
        $sheet->setCellValue("C$row", $invoice->created_at);
        $sheet->setCellValue("D$row", $invoice->customer_name);
        $sheet->setCellValue("E$row", $invoice->item_count);
        $sheet->setCellValue("F$row", $invoice->total_amount);
        $sheet->setCellValue("G$row", $invoice->status);
        $row++;
    }

    
    $filename = 'Invoices_Report_' . date('Ymd_His') . '.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

}

    public function exportInvoicesToPDF() {
    $this->load->model('Customer_invoices_model');
    $invoices = $this->Customer_invoices_model->GetAllInvoices();

    // Prepare HTML
    $html = '<h2>Invoice Report</h2><table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th><th>Invoice ID</th><th>Date</th><th>Customer</th><th>Items</th><th>Total (Rs.)</th><th>Status</th>
            </tr>
        </thead><tbody>';
    
    $i = 1;
    foreach ($invoices as $invoice) {
        $html .= '<tr>
            <td>' . $i++ . '</td>
            <td>' . $invoice->invoiceNo . '</td>
            <td>' . $invoice->created_at . '</td>
            <td>' . $invoice->customer_name . '</td>
            <td>' . $invoice->item_count . '</td>
            <td>' . $invoice->total_amount . '</td>
            <td>' . $invoice->status . '</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    // Generate PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("invoices.pdf", array("Attachment" => 1));
}

    public function showReturnInvoice(){

        $data['Returns'] = $this->Invoice_returns_model->GetAllReturnInvoices();

        $this->load->view('Dashboard/returnInvoiceReport', $data);
    }

}