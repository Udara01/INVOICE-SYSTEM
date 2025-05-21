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
 * @property Invoice_returns_model $Invoice_returns_model
 * @property CI_DB_query_builder|CI_DB_driver $db
 * 
 */

class Charts_controller extends CI_Controller {

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

/**
 * 
 * This invoice_chart method retrieves invoice summary data and loads the view to generate
 * a column chart showing customers based on their total invoice amounts.
 *
 * It supports optional filters to refine the data:
 * - Date range (from_date, to_date)
 * - Specific customer (customer_id)
 *
 * Data Sent to View:
 * - customers_total: Aggregated invoice amounts per customer (from model)
 * - customers: List of all customers (for filter dropdown)
 *
 * View - Dashboard/Charts/customerTotalAmount
 */
    public function invoice_chart() {

      $from_date = $this->input->get('from_date');
      $to_date = $this->input->get('to_date');
      $customer_id = $this->input->get('customer_id');

      $data['customers_total'] = $this->Customer_invoices_model->get_all_customers_invoice_summary($from_date, $to_date, $customer_id);
      $data['customers'] = $this->Customer_model->get_all_customers();

      $this->load->view('Dashboard/Charts/customerTotalAmount', $data);
    }


/**
 * 
 * This return_invoice_chart method retrieves return invoice summary data and loads the view to generate
 * a column chart displaying customers based on their total returned invoice amounts.
 *
 * It supports optional filters to refine the data:
 * - Date range (from_date, to_date)
 * - Specific customer (customer_id)
 *
 * Data Sent to View:
 * - Return_amounts: Aggregated return amounts per customer (from model)
 * - customers: List of all customers (for filter dropdown)
 *
 * View - Dashboard/Charts/returnInvoiceTotal
 */
    public function return_invoice_chart(){

      $from_date = $this->input->get('from_date');
      $to_date = $this->input->get('to_date');
      $customer_id = $this->input->get('customer_id');

      $data['Return_amounts'] = $this->Invoice_returns_model->get_all_return_invoice_summary($from_date, $to_date, $customer_id);
      $data['customers'] = $this->Customer_model->get_all_customers();

      $this->load->view('Dashboard/Charts/returnInvoiceTotal', $data);

    }

    
    public function total_invoice(){
      $data['Customer_counts'] = $this->Customer_invoices_model->customer_invoice_count();
      $data['customers'] = $this->Customer_model->get_all_customers();

      $this->load->view('Dashboard/Charts/totalInvoices', $data);
    }

    public function total_return_invoice(){
      $data['Return_count'] = $this->Invoice_returns_model->customer_return_invoice_count();
      $data['customers'] = $this->Customer_model->get_all_customers();

      $this->load->view('Dashboard/Charts/returnInvoicesCount', $data);
    }

}