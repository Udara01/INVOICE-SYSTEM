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
 * @property CI_DB_query_builder|CI_DB_driver $db
 * 
 */

class Customer_invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_model');
        $this->load->model('Item_model');
        $this->load->model('Customer_invoices_model');
        $this->load->model('Invoice_items_model');
        $this->load->model('Customer_model'); 
        $this->load->library('form_validation');
    }

/**
 * This index method is used to load the 'createInvoice1' view with the '$data' array.
 * 
 * The following data is prepared and passed to the view as an array
 * **'invoiceNo' - The next invoice number, which is generated based on the last invoice in the database.
 * **'items'- A list of all available items fetched from the Item_model, It  use to select Items to add the Invoice.
 * **'customers'- A list of all customers fetched from the Customer_model, when creating the Invoice can select the the customer.
 * 
 * all data sendto the view as an arrays.
 * 
 */
    public function index() {
      // Fetch the last invoice number from the database
      $last_invoice = $this->Customer_invoices_model->getLastInvoiceNo(); 
      $next_invoice_number = $this->generateInvoiceNumber($last_invoice);
      
      $data['invoiceNo'] = $next_invoice_number;

      $data['items'] = $this->Item_model->showItems(); // Fetch all items from the database

      $data['customers'] = $this->Customer_model->get_all_customers();

      $this->load->view('Invoice/createInvoice1', $data); // Load the view and pass the items data
    }


    public function add_customer() {
      $data = [
        'name' => $this->input->post('name'),
        'address' => $this->input->post('address'),
        'phone' => $this->input->post('phone')
      ];
      $id = $this->Customer_model->add_customer($data);
      echo json_encode(['id' => $id, 'name' => $data['name']]);
    }

/**
 * This is a method for generate new Invoice number based on the last saved invoice on the database
 * 
 * in the index method it called to this method which pass the last invoice number saved on the database.
 * based on that this method create new number 
 */
    private function generateInvoiceNumber($last_invoice) {
      // Check if there's a last invoice number
      if (empty($last_invoice)) {
          return 'INV-0001';
      }

      preg_match('/(\d+)/', $last_invoice, $matches);

      $last_number = (int) $matches[0];
      $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT); 
      return 'INV-' . $new_number;
  }


/*
  public function Create_Invoice() {
    $invoice_No = $this->input->post('invoiceNo');
    $customer_id = $this->input->post('customer_id');
    $item_ids = $this->input->post('item_id');
    $quantities = $this->input->post('itemQuantity');
    $total_amount = $this->input->post('totalAmount');
    $user_id = $this->session->userdata('user_id'); 

    // safety check to avoid null user ID
    if (!$user_id) {
        
        show_error('User not logged in.');
        return;
    }

    $invoice_data = [
        'invoiceNo'     => $invoice_No,
        'customer_id'   => $customer_id,
        'created_at'    => date('Y-m-d H:i:s'),
        'total_amount'  => $total_amount,
        'created_by'    => $user_id, 

    ];

    // Insert invoice
    $this->Customer_invoices_model->Add_Customer($invoice_data);
    $invoice_id = $this->db->insert_id(); 

    // Insert invoice items
for ($i = 0; $i < count($item_ids); $i++) {
    $item_id = $item_ids[$i];
    $quantity = $quantities[$i];

    
    $item_data = [
        'invoice_ID' => $invoice_id,
        'invoiceNo'  => $invoice_No,
        'productID'  => $item_id,
        'quantity'   => $quantity,
        'productDescription' => $this->input->post('itemDescription')[$i],
    ];
    
    // 1. Add to invoice_items
    $this->Invoice_items_model->Add_invoiceItems($item_data);

    // 2. Reduce stock from items table
    $this->Item_model->reduceStock($item_id, $quantity);
}

    // Redirect to print preview
    redirect('Customer_invoice/print_invoice/' . $invoice_id);
}
*/

/**
 * this is the method for Create new Invoice.
 * 
 * user send data from the Invoice/createInvoice1. 
 * This method handles the form submission from 'createInvoice1' view to create a new invoice.
 * 
 * process.
 * 1. Retrieves invoice, customer, item, and total data from the form.
 * 2. Validates that the user is logged in.
 * 3. Checks if the stock is available for each item.
 * 4. Inserts invoice data into the 'customer_invoices' table.
 * 5. Inserts each invoice item into 'invoice_items' and updates item stock.
 * 6. Redirects to the invoice print page.
 */
public function Create_Invoice() {
  // Step 1 - Get posted form data
    $invoice_No = $this->input->post('invoiceNo');
    $customer_id = $this->input->post('customer_id');
    $item_ids = $this->input->post('item_id');
    $quantities = $this->input->post('itemQuantity');
    $price = $this->input->post('itemPrice');
    $total_amount = $this->input->post('totalAmount');
    $user_id = $this->session->userdata('user_id');

    // Step 2 - Ensure the user is logged in
    if (!$user_id) {
        show_error('User not logged in.');
        return;
    }

    // Step 3: Check stock for each item
    for ($i = 0; $i < count($item_ids); $i++) {
        $item_id = $item_ids[$i];
        $quantity = $quantities[$i];

        $current_stock = $this->Item_model->getStockById($item_id);
        if ($current_stock < $quantity) {
            // Set error message with item ID or name
            $this->session->set_flashdata('error', 'Not enough stock for item ID ' . $item_id . '. Available: ' . $current_stock);
            redirect('Customer_invoice');
            return;
        }
    }

    // Step 4: Insert invoice data into the database
    $invoice_data = [
        'invoiceNo'     => $invoice_No,
        'customer_id'   => $customer_id,
        'created_at'    => date('Y-m-d H:i:s'),
        'total_amount'  => $total_amount,
        'created_by'    => $user_id,
    ];
    $invoice_id = $this->Customer_invoices_model->Add_Customer($invoice_data);


    // Step 5: Insert each invoice item and reduce stock
    for ($i = 0; $i < count($item_ids); $i++) {
        $item_id = $item_ids[$i];
        $quantity = $quantities[$i];

        $item_data = [
            'invoice_ID' => $invoice_id,
            'invoiceNo'  => $invoice_No,
            'productID'  => $item_id,
            'quantity'   => $quantity,
            'price' => $price[$i],
            'productDescription' => $this->input->post('itemDescription')[$i],
        ];

        $this->Invoice_items_model->Add_invoiceItems($item_data);
        $this->Item_model->reduceStock($item_id, $quantity);
    }

    // Step 6: Redirect to print invoice page
    redirect('Customer_invoice/print_invoice/' . $invoice_id);
}

  public function print_invoice($id) {
    $invoice = $this->Customer_invoices_model->getInvoiceWithDetails($id);
    if (!$invoice) {
      show_error("Invoice with ID $id not found.");
  }
    $invoice_items = $this->Customer_invoices_model->getInvoiceItems($id);
    $all_items = $this->Item_model->showItems(); // Fetch all item data
    $customers = $this->Customer_model->get_all_customers(); 
  
  
    $this->load->view('Invoice/print_invoice', [
        'invoice' => $invoice,
        'invoice_items' => $invoice_items,
        'all_items' => $all_items, 
        'customers' => $customers,
    ]);
    //$this->load->view('Invoice/print_invoice', $data); 
  }


  public function invoice_list() {
    $data['invoices'] = $this->Customer_invoices_model->get_all_invoices();
    $this->load->view('Invoice/invoiceList', $data);
}

/*
public function edit_invoice($id){
  $invoice = $this->Customer_invoices_model->getInvoiceById($id);
   // Load the edit view and pass the invoice data to it
   $this->load->view('Invoice/edit_invoice', ['invoice' => $invoice]);
}
*/

public function edit_invoice($id) {
  //$invoice = $this->Customer_invoices_model->getInvoiceById($id);
  $invoice = $this->Customer_invoices_model->getInvoiceWithDetails($id);
  $invoice_items = $this->Customer_invoices_model->getInvoiceItems($id);
  $all_items = $this->Item_model->showItems(); // Fetch all item data
  $customers = $this->Customer_model->get_all_customers(); 


  $this->load->view('Invoice/edit_invoice', [
      'invoice' => $invoice,
      'invoice_items' => $invoice_items,
      'all_items' => $all_items, 
      'customers' => $customers,
  ]);
}

public function add_invoice_item($invoice_id) {
  $data = [
      'invoice_ID' => $invoice_id,
      'productID' => $this->input->post('productID'),
      'productDescription' => $this->input->post('description'),
      'quantity' => $this->input->post('quantity'),
      'price' => $this->input->post('price'),
      'invoiceNo' => $this->Customer_invoices_model->getInvoiceById($invoice_id)->invoiceNo,
      
  ];

  $this->db->insert('invoice_items', $data);

  // Recalculate total and update invoice
  $total = $this->Invoice_items_model->getTotalByInvoiceId($invoice_id);
  $this->Customer_invoices_model->updateTotalAmount($invoice_id, $total);

  redirect('Customer_invoice/edit_invoice/' . $invoice_id);
}

public function update_invoice($id) {
  //$user_id = $this->session->userdata('user_id'); 
  $data = [
      'invoiceNo'    => $this->input->post('invoiceNo'),
      'customer_id'  => $this->input->post('customer_id'),
      'total_amount' => $this->input->post('total_amount'),
      'updated_by'   => $this->session->userdata('user_id'),  
      'updated_at'   => date('Y-m-d H:i:s')
  ];

  $this->Customer_invoices_model->update_invoice($id, $data);

    // Recalculate total and update invoice
    $total = $this->Invoice_items_model->getTotalByInvoiceId($id);
    $this->Customer_invoices_model->updateTotalAmount($id, $total);

  redirect('Customer_invoice/edit_invoice/' . $id);
}





public function delete_invoice_item($item_id, $invoice_id) {
  $this->Invoice_items_model->deleteInvoiceItemById($item_id);

   //Recalculate total and update invoice
   $total = $this->Invoice_items_model->getTotalByInvoiceId($invoice_id);
   $this->Customer_invoices_model->updateTotalAmount($invoice_id, $total);
  redirect('Customer_invoice/edit_invoice/' . $invoice_id);
}


public function delete_invoice($invoice_id)
{
    $result = $this->Customer_invoices_model->delete_invoice_with_items($invoice_id);

    // Feedback message
    if ($result) {
        $this->session->set_flashdata('success', 'Invoice deleted successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to delete invoice.');
    }

    redirect('Customer_invoice/invoice_list');
}


public function update_invoice_item($item_id, $invoice_id)
  {

      $data = [
          'productDescription' => $this->input->post('productDescription'),
          'quantity'    => $this->input->post('quantity'),
      ];

      $this->Invoice_items_model->update_invoice_item($item_id, $data);

      $this->session->set_flashdata('success', 'Invoice item updated successfully.');
      redirect('Customer_invoice/edit_invoice/' . $invoice_id);
  }



    
  }