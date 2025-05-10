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
 * 
 */


class Customer_controller extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Invoice_model');
    $this->load->model('Item_model');
    $this->load->model('Customer_invoices_model');
    $this->load->model('Invoice_items_model');
    $this->load->model('Customer_model'); 
    $this->load->library('form_validation');
  }

  public function index() {
      
    $this->load->view('Customer/newCustomer');
  }

  public function add_customer() {
    $data = [
      'name' => $this->input->post('name'),
      'address' => $this->input->post('address'),
      'phone' => $this->input->post('phone')
    ];
    $this->Customer_model->add_customer($data);
    
  }

  public function Customer_list(){

    $data['customers'] = $this->Customer_model->get_all_customers();

    $this->load->view('Customer/customerList', $data);
  }

  public function update_Customer($id){
    /*
    $customer_name = $this->input->post('customer_name');
    $customer_address = $this->input->post('customer_address');
    $customer_phone = $this->input->post('customer_phone');

    $data = [
      'name' => $customer_name,
      'address' => $customer_address,
      'phone' => $customer_phone,
    ];

    $this->Customer_model->update_customer($id, $data);
*/
    $this->Customer_model->update_customer($id, $this->input->post());

    //Redirect back to the customer list after update
    redirect('Customer_controller/Customer_list');
  }

  public function delete_customer($id){
    
    $this->Customer_model->delete_customer($id);
    redirect('Customer_controller/Customer_list');
  }

}