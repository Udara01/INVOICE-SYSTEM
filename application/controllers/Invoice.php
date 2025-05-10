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
 */

class Invoice extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
  
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
  
        // Only block access if user tries to access 'Landing', not 'index'
        $current_method = $this->router->fetch_method();
        if ($current_method === 'Landing' && !$this->session->userdata('logged_in')) {
            redirect('land');
        }
    }
    
	public function index(){
      if (!$this->session->userdata('logged_in')) {
        redirect('land');
      }

      $this->load->model('Item_model'); // Load the Item_model
      $this->load->model('Invoice_model'); // Load the Invoice_model

      $data['items'] = $this->Item_model->showItems(); // Get all items from the model
      $data['invoices'] = $this->Invoice_model->get_all_invoices(); // Get all invoices from the model
    
      $this->load->view('Invoice/createInvoice', $data); // Pass the invoices to the view
	}

/*
  public function ItemList()
    {
        $this->load->model('Item_model'); // Load the Item_model
        $data['items'] = $this->Item_model->showItems(); // Get all items from the model
        $this->load->view('Item/updateItem', $data); // Pass the items to the view
    }
*/

	public function Create_Invoice(){
		$customer_name = $this->input->post('customerName');
		$item_id = $this->input->post('item_id');


		$this->load->model('Invoice_model');

		$data = array(
			'customerName' => $customer_name,
			'productID' => $item_id
		);

    /*
		if($this->Invoice_model->create_invoice($data)){
			echo "Invoice Created Successfully";
		}
		else{
			echo "Error in Invoice Createted";
		}*/


    $invoice_id = $this->Invoice_model->create_invoice($data);

    if ($invoice_id) {
        redirect('invoice/print/' . $invoice_id);
    } else {
        echo "Error in Invoice Created";
    }
	}

  public function print($invoice_id) {
    $this->load->model('Invoice_model');
    $data['invoice'] = $this->Invoice_model->get_invoice_with_item($invoice_id);

    if (!$data['invoice']) {
        show_error('Invoice not found');
    }

    $this->load->view('Invoice/printInvoice', $data);
  }

  public function view($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('land');
          }

        $this->load->model('Invoice_model');
        $this->load->model('Item_model');

        $invoice = $this->Invoice_model->get_invoice_with_item($id);
        $items = $this->Item_model->showItems();

        if (!$invoice) {
            show_404();
        }

        $this->load->view('Invoice/editInvoice', ['invoice' => $invoice, 'items' => $items]);
    }
  


    public function delete($id)
        {
        $this->load->model('Invoice_model');

        if ($this->Invoice_model->delete_invoice($id)) {
            
            redirect('invoice');
        } else {
            echo "Failed to delete invoice.";
        }
        }   

    public function update($id)
    {
        $this->load->model('Invoice_model');

        $data = [
            'customerName' => $this->input->post('customerName'),
            'productID' => $this->input->post('item_id')
        ];

        if ($this->Invoice_model->update_invoice($id, $data)) {
            redirect('invoice/view/' . $id);
        } else {
            echo "Failed to update invoice.";
        }
    }

}


