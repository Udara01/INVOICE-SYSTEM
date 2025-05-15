<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Item_model $Item_model
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 * @property CI_Category_model $Category_model
 */

class Items extends CI_Controller {
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
    
    public function index()
    {
        
        $this->load->view('Item/addItem');
    }

    public function addItem()
    {

        $this->load->library('form_validation'); //validate form using validation library

        // validation rules for the add item form
        $this->form_validation->set_rules('itemName', 'Item Name', 'required|min_length[3]');
        $this->form_validation->set_rules('itemDescription', 'Item Description', 'required|min_length[5]');
        $this->form_validation->set_rules('itemPrice', 'Item Price', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, reload the form with error messages
            $this->load->view('/Item/addItem');
        }
        else{
            $item_name = $this->input->post('itemName');                   
            $item_description = $this->input->post('itemDescription');
            $item_price = $this->input->post('itemPrice');
            $item_categoryID =  $this->input->post('category_ID');
            $item_stock = $this->input->post('stock');

        /* echo "Item Name: " . $item_name . "<br>";
            echo "Item Description: " . $item_description . "<br>";
            echo "Item Price: " . $item_price . "<br>";*/

            $this->load->model('Item_model'); // Load the Item_model
            $data = array(
                'itemName' => $item_name,
                'price' => $item_price,
                'description' => $item_description,
                'stock' => $item_stock,
                'category_ID' => $item_categoryID
            );

            if ($this->Item_model->add_item($data)) {
                //echo "Item added successfully!";
                redirect('app/home');
            } else {
                echo "Failed to add item.";
            }
        }

    }

    public function ItemList()
    {
        $this->load->model('Item_model'); 
        $data['items'] = $this->Item_model->showItems(); // Get all items from the model
        $this->load->view('Item/itemList', $data); // Pass the items to the view
    }


    public function UpdateList(){

        $data['items'] = $this->Item_model->showItems(); // Get all items from the model
        $data['categories'] = $this->Category_model->get_CategoryList();
        $this->load->view('Item/updateItem', $data); // Pass the items to the view
    }
    
    public function UpdateItem()
    {
        $this->load->library('form_validation');
        $this->load->model('Item_model');

        $this->form_validation->set_rules('itemName', 'Item Name', 'required|min_length[3]');
        $this->form_validation->set_rules('itemDescription', 'Item Description', 'required|min_length[5]');
        $this->form_validation->set_rules('itemPrice', 'Item Price', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $data['items'] = $this->Item_model->showItems();
            $this->load->view('home', $data);


        } else {
        $item_name = $this->input->post('itemName');
        $item_price = $this->input->post('itemPrice');
        $item_description = $this->input->post('itemDescription');
        $item_id = $this->input->post('item_id'); 
        $item_stock = $this->input->post('itemStock');
        $item_categoryID =  $this->input->post('itemCategory');

        $this->load->model('Item_model'); 

        $data = array(
          'itemName' => $item_name,
          'price' => $item_price,
          'description' => $item_description,
          'stock' => $item_stock,
          'category_ID' => $item_categoryID
        );

        if ($this->Item_model->update_item($item_id, $data)) {
            //echo "Item updated successfully!";
            redirect('app/home');
        } else {
            echo "Failed to update item.";
    
       }
    }
  }
    
    public function deleteItem()
    {
        $item_id = $this->input->post('item_id');
        $this->load->model('Item_model');
    
        if ($this->Item_model->delete_item($item_id)) {
            //echo "Item deleted successfully!";
            redirect('app/home');
        } else {
            echo "Failed to delete item.";
        }
    }

    public function showDeleteItemForm()
    {
        $this->load->model('Item_model'); // Load the Item_model
        $data['items'] = $this->Item_model->showItems(); // Get all items from the model
        $this->load->view('Item/deleteItem', $data); // Pass the items to the view
    }


    public function show_categories(){
        $data['categories'] = $this->Category_model->get_CategoryList();

        $this->load->view('Item/addItem', $data);
    }

}