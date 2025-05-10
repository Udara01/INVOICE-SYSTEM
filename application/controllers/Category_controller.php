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
 * @property Category_model $Category_model
 * 
 */


class Category_controller extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Invoice_model');
    $this->load->model('Item_model');
    $this->load->model('Customer_invoices_model');
    $this->load->model('Invoice_items_model');
    $this->load->model('Customer_model'); 
    $this->load->model('Category_model');
    $this->load->library('form_validation');
  }


  public function add_category_form() {
      
    $this->load->view('Category/add_category');
  }

  public function create_category() {
    $category_name = $this->input->post('categoryName');
    $category_description = $this->input->post('categoryDescription');

    $data = [

      'category_name' => $category_name,
      'categoryDescription' => $category_description,
    ];

    $this->Category_model->add_category($data);

    redirect('categoryadd');
  }


  public function get_categories(){

    $data['categories'] = $this->Category_model->get_CategoryList();

    $this->load->view('Category/add_category', $data);
  }

  public function update_category($id){
    $category_name = $this->input->post('category_name');
    $category_description = $this->input->post('category_description');

    $data = [
      'category_name' => $category_name,
      'categoryDescription' => $category_description,
    ];

    $this->Category_model->update_category($id, $data);

    redirect('categoryadd');
  }

  public function delete_category($id){

    $this->Category_model->delete_category($id);
    redirect('categoryadd');
  }
  
}