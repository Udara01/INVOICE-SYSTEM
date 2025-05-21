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
 * @property returned_items_model $returned_items_model
 * 
 */


class ReturnInvoice_controller extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Invoice_model');
    $this->load->model('Item_model');
    $this->load->model('Customer_invoices_model');
    $this->load->model('Invoice_items_model');
    $this->load->model('Customer_model'); 
    $this->load->model('Invoice_returns_model');
    $this->load->model('returned_items_model');
    $this->load->library('form_validation');
  }

  public function index() {
    $this->load->model('Invoice_returns_model');
    $data['return_invoices'] = $this->Invoice_returns_model->get_all_return_invoices();

    $this->load->view('Invoice/return_invoice_list', $data);
}


 

public function return_Invoice($id) {
    $invoice = $this->Customer_invoices_model->getInvoiceWithDetails($id);
    $invoice_items = $this->Customer_invoices_model->getInvoiceItems($id);
    $all_items = $this->Item_model->showItems();
    $customers = $this->Customer_model->get_all_customers();

    // Generate next return invoice number
    $last_return = $this->Invoice_returns_model->getLastReturnInvoiceNo(); 
    $next_invoice_number = $this->generateReturnInvoiceNumber($last_return);

    $this->load->view('Invoice/return_invoice', [
        'invoice' => $invoice,
        'invoice_items' => $invoice_items,
        'all_items' => $all_items, 
        'customers' => $customers,
        'invoiceReturnNo' => $next_invoice_number, 
    ]);
}



  private function generateReturnInvoiceNumber($last_return) {
      // Check if there's a last invoice number
      if (empty($last_return)) {
          return 'INV-RU-0001';
      }
      preg_match('/(\d+)/', $last_return, $matches);

      $last_number = (int) $matches[0];
      $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT); 
      return 'INV-RU-' . $new_number;
  }

/*
  public function create_return_invoice(){
    $return_invoice_no = $this->input->post('return_invoice_no');
    $customer_id = $this->input->post('customer_id');
    $invoice_id = $this->input->post('invoice_id');
    $reason = $this->input->post('reason');
    $return_data = $this->input->post('return_data');
    $return_amount = $this->input->post('return_amount');

    // Prepare data for the return invoice
    $data = array(
        'return_invoice_no' => $return_invoice_no,
        'customer_id' => $customer_id,
        'original_invoice_id' => $invoice_id,
        'reason' => $reason,
        'return_date' => $return_data,
        'total_return_amount' => $return_amount,
    );

$return_invoice_id = $this->Invoice_returns_model->create_return_invoice($data);

if ($return_invoice_id) {
    $returned_items = $this->input->post('returned_items');
    if (!empty($returned_items)) {
        $this->insert_returned_items($return_invoice_id, $returned_items);
    }
    redirect('ReturnInvoice_controller/return_Invoice/' . $invoice_id );
} else {
    echo "Error creating return invoice.";
}

  }
*/

 public function create_return_invoice() {
        $invoice_id = $this->input->post('invoice_id');
        $customer_id = $this->input->post('customer_id');
        $reason = $this->input->post('reason');
        $return_date = $this->input->post('return_date');
        $return_amount = $this->input->post('return_amount');
        $return_invoice_no = $this->input->post('return_invoice_no');
        $returned_items = $this->input->post('returned_items');

        // Prepare return invoice data
        $return_invoice_data = [
            'original_invoice_id' => $invoice_id,
            'customer_id' => $customer_id,
            'reason' => $reason,
            'return_date' => $return_date,
            'total_return_amount' => $return_amount,
            'return_invoice_no' => $return_invoice_no,
        ];

        // Save return invoice record using the model
        $return_invoice_id = $this->Invoice_returns_model->create_return_invoice($return_invoice_data);

        // Save returned items using the model and update stock
        foreach ($returned_items as $item) {
            $returned_item_data = [
                'return_invoice_id' => $return_invoice_id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['total'],
            ];

            // Save returned item
            $this->returned_items_model->add_return_invoice_items($returned_item_data);

            // Update stock: add back the returned quantity
            $this->db->set('stock', 'stock + ' . (int)$item['quantity'], FALSE);
            $this->db->where('id', $item['item_id']);
            $this->db->update('items');
        }

        $this->session->set_flashdata('success', 'Return invoice created and stock updated successfully.');
        redirect('ReturnInvoice_controller/view_return_invoice/' . $return_invoice_id);
    }

    public function view_return_invoice($return_invoice_id) {
        // Fetch the return invoice details using the ID
        $return_invoice = $this->Invoice_returns_model->get_invoice_by_id($return_invoice_id);

        // Fetch the returned items related to the return invoice
        $returned_items = $this->returned_items_model->get_items_by_invoice($return_invoice_id);

        // Pass the data to the view
        $data['return_invoice'] = $return_invoice;
        $data['returned_items'] = $returned_items;

        $this->load->view('Invoice/view_return_invoice', $data);
    }


public function return_invoice_entry($invoice_id) {
    $existing_return = $this->Invoice_returns_model->check_Return_InvExist($invoice_id);

    if ($existing_return) {
        // Redirect to the existing return invoice view
        redirect('ReturnInvoice_controller/view_return_invoice/' . $existing_return->id);
    } else {
        // Redirect to create a new return invoice
        redirect('ReturnInvoice_controller/return_Invoice/' . $invoice_id);
    }
}


public function delete_return_invoice($return_invoice_id) {
    // Reverse stock
    $this->returned_items_model->reverse_stock_by_invoice($return_invoice_id);

    // Delete items and invoice
    $this->returned_items_model->delete_items_by_invoice($return_invoice_id);
    $this->Invoice_returns_model->delete_invoice($return_invoice_id);

    $this->session->set_flashdata('success', 'Return invoice deleted successfully.');
    redirect('ReturnInvoice_controller/index');
}



public function edit_return_invoice($return_invoice_id) {
    $data['return_invoice'] = $this->Invoice_returns_model->get_invoice_by_id($return_invoice_id);
    $data['returned_items'] = $this->returned_items_model->get_items_by_invoice($return_invoice_id);
    //$data['all_items'] = $this->Item_model->showItems();
    $all_items = $this->Item_model->showItems();
    $data['all_items'] = $all_items;
    $data['items_json'] = json_encode(array_column($all_items, null, 'id')); // key = item_id
    $data['customers'] = $this->Customer_model->get_all_customers();

    $this->load->view('Invoice/edit_return_invoice', $data);
}


public function update_return_invoice($return_invoice_id) {
    $invoice_id = $this->input->post('invoice_id');
    $customer_id = $this->input->post('customer_id');
    $reason = $this->input->post('reason');
    $return_date = $this->input->post('return_date');
    $return_amount = $this->input->post('return_amount');
    $returned_items = $this->input->post('returned_items');

    // Reverse old stock
    $this->returned_items_model->reverse_stock_by_invoice($return_invoice_id);

    // Update invoice
    $this->Invoice_returns_model->update_invoice($return_invoice_id, [
        'original_invoice_id' => $invoice_id,
        'customer_id' => $customer_id,
        'reason' => $reason,
        'return_date' => $return_date,
        'total_return_amount' => $return_amount
    ]);

    // Delete old items
    $this->returned_items_model->delete_items_by_invoice($return_invoice_id);

    // Insert new returned items and update stock
    foreach ($returned_items as $item) {
        $this->returned_items_model->add_return_invoice_items([
            'return_invoice_id' => $return_invoice_id,
            'item_id' => $item['item_id'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'total' => $item['total'],
        ]);

        $this->Item_model->increase_stock($item['item_id'], $item['quantity']);
    }

    $this->session->set_flashdata('success', 'Return invoice updated successfully.');
    redirect('ReturnInvoice_controller/view_return_invoice/' . $return_invoice_id);
}

/**
 * this is the method for load customers form tha database to view
 * 
 * 
 */

public function view_load_page() {
    $data['customers'] = $this->Customer_model->get_all_customers();
    $data['invoices'] = $this->Customer_model->get_all_valid_invoices_for_return(); // filtered
    $this->load->view('Invoice/Return/returnload', $data);
}


public function load_return_Invoice($id) {
    $invoice = $this->Customer_invoices_model->getInvoiceWithDetails($id);
    $invoice_items = $this->Customer_invoices_model->getInvoiceItems($id);
    $all_items = $this->Item_model->showItems();
    $customers = $this->Customer_model->get_all_customers();

    // Generate next return invoice number
    $last_return = $this->Invoice_returns_model->getLastReturnInvoiceNo(); 
    $next_invoice_number = $this->generateReturnInvoiceNumber($last_return);

    $this->load->view('Invoice/Return/returnload', [
        'invoice' => $invoice,
        'invoice_items' => $invoice_items,
        'all_items' => $all_items, 
        'customers' => $customers,
        'invoiceReturnNo' => $next_invoice_number, 
    ]);
}

}
  