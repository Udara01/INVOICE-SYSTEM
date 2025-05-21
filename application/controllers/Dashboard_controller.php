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


  public function index() {

/**
 * this from_date. to_date and customer names are used as a filters in the get_all_customers_invoice_summary method
 * 
 * it create a column chart which show the customer with their total invoice amounts 
 */
    // For customer total invoice chart
    $from_date_1 = $this->input->get('from_date_1');
    $to_date_1 = $this->input->get('to_date_1');
    $customer_id_1 = $this->input->get('customer_id_1');

    $data['customers_total'] = $this->Customer_invoices_model->get_all_customers_invoice_summary($from_date_1, $to_date_1, $customer_id_1);


    $data['Invoices'] = $this->Customer_invoices_model->GetAllInvoices();
    $data['Returns'] = $this->Invoice_returns_model->GetAllReturnInvoicesFilter();
    $data['customers'] = $this->Customer_model->get_all_customers();

    
    // For return invoice chart
    $from_date_2 = $this->input->get('from_date_2');
    $to_date_2 = $this->input->get('to_date_2');
    $customer_id_2 = $this->input->get('customer_id_2');

    $data['Return_amounts'] = $this->Invoice_returns_model->get_all_return_invoice_summary($from_date_2, $to_date_2, $customer_id_2);


     // For invoice Count
    $from_date_3 = $this->input->get('from_date_3');
    $to_date_3 = $this->input->get('to_date_3');
    $customer_id_3 = $this->input->get('customer_id_3');

    $data['Customer_counts'] = $this->Customer_invoices_model->customer_invoice_count($from_date_3, $to_date_3, $customer_id_3);


    // For invoice Count
    $from_date_4 = $this->input->get('from_date_4');
    $to_date_4 = $this->input->get('to_date_4');
    $customer_id_4 = $this->input->get('customer_id_4');

    $data['Return_count'] = $this->Invoice_returns_model->customer_return_invoice_count($from_date_4, $to_date_4, $customer_id_4);

    $this->load->view('Dashboard/page', $data);
}

/*
 //This for the get Invoices from the using stored procedures
  public function showInvoice(){

    $data['Invoices'] = $this->Customer_invoices_model->GetAllInvoices();
    $this->load->view('Dashboard/invoiceReport', $data);
    }
*/

/**
 * this method use to display all invoices created on the customer_invoice table.
 * 
 * It also allows filtering invoices based on the following criteria:
 * - Date range (from_date to to_date)
 * - Customer name (customer_id)
 * - Payment status (status)
 * 
 * The filtered or full list of invoices is passed to the 'invoiceReport' view,
 * along with customer data for filter dropdowns. 
 */
    public function showInvoice() {
    // Get filter inputs
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $customer_id = $this->input->get('customer_id');
    $status = $this->input->get('status');

    // Pass them to the model
    $data['Invoices'] = $this->Customer_invoices_model->GetAllInvoices($from_date, $to_date, $customer_id, $status);

    // Load customers for the filter dropdown
    $data['Customers'] = $this->Customer_model->get_all_customers();

    // Pass filters back to view (optional if needed)
    $data['filters'] = $_GET;

    $this->load->view('Dashboard/invoiceReport', $data);
    }


/*
//this is use to display all return invoices on the returnInvoiceReport view without filters
    public function showReturnInvoice(){

        $data['Returns'] = $this->Invoice_returns_model->GetAllReturnInvoices();

        $this->load->view('Dashboard/returnInvoiceReport', $data);
    }
*/


/**
 * this method use to display all return invoices created on the invoice_return table.
 * 
 * same as showInvoice method use filters in here.
 * 
 */
    public function showReturnInvoice(){

        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $customer_id = $this->input->get('customer_id');        
        $invoice_number = $this->input->get('invoice_no');

        $data['Returns'] = $this->Invoice_returns_model->GetAllReturnInvoicesFilter($from_date, $to_date, $customer_id, $invoice_number);

       $data['Customers'] = $this->Customer_model->get_all_customers();

       $data['filters'] = $_GET;

       $this->load->view('Dashboard/returnInvoiceReport', $data);
    }


/** 
 *This is an test excel file crete for the check the function work. not use for the actual code
 *  
*/    
public function downloadExcel(){
    
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



/**
 * createInvoicesExcel
 *
 * This method generates an Excel report of all invoices using data
 * retrieved from the database, typically via SQL stored procedures.
 *
 * It fetches all invoice records, formats them into an Excel spreadsheet,
 * and initiates a file download in the browser with appropriate headers.
 *
 * The generated report includes the following columns:
 * - Serial number
 * - Invoice number
 * - Date
 * - Customer name
 * - Number of items
 * - Total amount
 * - Payment status
 *
 * Output: Excel (.xlsx) file named with a timestamp.
 * This commented because create another method with filter options
 */
/*
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
*/

/*public function exportInvoicesToPDF() {
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
*/

public function createInvoicesExcel() {
    //1st Get filter values from URL (GET parameters)
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $customer_id = $this->input->get('customer_id');
    $status = $this->input->get('status');

    // Pass those filters to the model function
    $invoices = $this->Customer_invoices_model->GetAllInvoices($from_date, $to_date, $customer_id, $status);

    //Generate Excel file
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Invoice No');
    $sheet->setCellValue('C1', 'Date');
    $sheet->setCellValue('D1', 'Customer');
    $sheet->setCellValue('E1', 'Items');
    $sheet->setCellValue('F1', 'Total (Rs.)');
    $sheet->setCellValue('G1', 'Status');

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
    //Get filter values from GET
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $customer_id = $this->input->get('customer_id');
    $status = $this->input->get('status');

    //Fetch filtered data from model
    $this->load->model('Customer_invoices_model');
    $invoices = $this->Customer_invoices_model->GetAllInvoices($from_date, $to_date, $customer_id, $status);

    //Build HTML for PDF
    $html = '<h2 style="text-align:center;">Invoice Report</h2>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice No</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total (Rs.)</th>
                <th>Status</th>
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

    //Generate and stream the PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("Invoices_Report_" . date('Ymd_His') . ".pdf", array("Attachment" => true));
}


/*
    public function exportReturnInvoiceExcel(){

        $Returns = $this->Invoice_returns_model->GetAllReturnInvoices();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Return_Invoice_No');
        $sheet->setCellValue('C1', 'Invoice_No');
        $sheet->setCellValue('D1', 'Customer');
        $sheet->setCellValue('E1', 'Return_Date');
        $sheet->setCellValue('F1', 'Return Amount');
        $sheet->setCellValue('G1', 'Reason');
        $sheet->setCellValue('H1', 'Items');


        $row = 2;
        $i =1;

        foreach($Returns as $Return){
            $sheet->setCellValue("A$row", $i++);
            $sheet->setCellValue("B$row", $Return->return_invoice_no);
            $sheet->setCellValue("C$row", $Return->original_invoice_no);
            $sheet->setCellValue("D$row", $Return->customer_name);
            $sheet->setCellValue("E$row", $Return->return_date);
            $sheet->setCellValue("F$row", $Return->total_return_amount);
            $sheet->setCellValue("G$row", $Return->reason);
            $sheet->setCellValue("H$row", $Return->return_count);
            $row++;
        }

        $filename = 'Return_INV_Report_' .date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
*/


public function exportReturnInvoiceExcel(){

    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $customer_id = $this->input->get('customer_id');        
    $invoice_number = $this->input->get('invoice_no');

    $Returns = $this->Invoice_returns_model->GetAllReturnInvoicesFilter($from_date, $to_date, $customer_id, $invoice_number);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

     $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Return_Invoice_No');
    $sheet->setCellValue('C1', 'Invoice_No');
    $sheet->setCellValue('D1', 'Customer');
    $sheet->setCellValue('E1', 'Return_Date');
    $sheet->setCellValue('F1', 'Return Amount');
    $sheet->setCellValue('G1', 'Reason');
    $sheet->setCellValue('H1', 'Items');


    $row = 2;
    $i =1;

    foreach($Returns as $Return){
        $sheet->setCellValue("A$row", $i++);
        $sheet->setCellValue("B$row", $Return->return_invoice_no);
        $sheet->setCellValue("C$row", $Return->original_invoice_no);
        $sheet->setCellValue("D$row", $Return->customer_name);
        $sheet->setCellValue("E$row", $Return->return_date);
        $sheet->setCellValue("F$row", $Return->total_return_amount);
        $sheet->setCellValue("G$row", $Return->reason);
        $sheet->setCellValue("H$row", $Return->return_count);
        $row++;
    }

    $filename = 'Return_INV_Report_' .date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

}

    public function exportReturnInvoicePDF(){

        $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $customer_id = $this->input->get('customer_id');        
    $invoice_number = $this->input->get('invoice_no');

    $Returns = $this->Invoice_returns_model->GetAllReturnInvoicesFilter($from_date, $to_date, $customer_id, $invoice_number);


       // $Returns = $this->Invoice_returns_model->GetAllReturnInvoices();

        // Prepare HTML
        $html = '<h2>Return Invoice Report</h2><table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Return_Invoice_No</th>
                    <th>Invoice_No</th>
                    <th>Customer</th>
                    <th>Return_Date</th>
                    <th>Return Amount</th>
                    <th>Reason</th>
                    <th>Items</th>
                </tr>
            </thead><tbody>';
        
        $i = 1;
        foreach ($Returns as $Return) {
            $html .= '<tr>
                <td>' . $i++ . '</td>
                <td>' . $Return->return_invoice_no . '</td>
                <td>' . $Return->original_invoice_no . '</td>
                <td>' . $Return->customer_name . '</td>
                <td>' . $Return->return_date . '</td>
                <td>' . $Return->total_return_amount . '</td>
                <td>' . $Return->reason . '</td>
                <td>' . $Return->return_count . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        // Generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Return_INV.pdf", array("Attachment" => 1));
        }

}       