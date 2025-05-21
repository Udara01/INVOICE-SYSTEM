<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_invoices_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function Add_Customer($invoice_data){
    $this->db->insert('customer_invoices', $invoice_data);
    return $this->db->insert_id(); 
  }
  public function getLastInvoiceNo() {
    $this->db->select('invoiceNo');
    $this->db->from('customer_invoices');
    $this->db->order_by('id', 'DESC'); // Get the most recent invoice
    $this->db->limit(1);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->invoiceNo;
    } else {
        return null;
    }
}

public function getInvoiceByNo($invoiceNo) {
  $this->db->where('invoiceNo', $invoiceNo);
  $query = $this->db->get('customer_invoices'); 
  return $query->row(); 
}


public function get_all_invoices() {
  return $this->db->select('customer_invoices.*, customers.name AS customer_name')
                  ->from('customer_invoices')
                  ->join('customers', 'customers.id = customer_invoices.customer_id')
                  ->order_by('customer_invoices.created_at', 'DESC')
                  ->get()
                  ->result();
}



public function getInvoiceById($id) {
  return $this->db->get_where('customer_invoices', ['id' => $id])->row();
}



public function getInvoiceItems($invoice_id) {
  $this->db->select('invoice_items.*, items.itemName, items.description');
  $this->db->from('invoice_items');
  $this->db->join('customer_invoices', 'customer_invoices.id = invoice_items.invoice_ID');
  $this->db->join('items', 'items.id = invoice_items.productID');
  $this->db->where('invoice_items.invoice_ID', $invoice_id);
  $query = $this->db->get();
  return $query->result();
}


public function getInvoiceWithDetails($invoice_id) {
    $this->db->select('ci.*, 
                       c.name AS customer_name,
                        c.address AS customer_address, 
                        c.phone AS customer_phone,
                       u1.userName AS created_by_name, 
                       u2.userName AS updated_by_name');
    $this->db->from('customer_invoices ci');
    $this->db->join('customers c', 'ci.customer_id = c.id', 'left');
    $this->db->join('users u1', 'ci.created_by = u1.id', 'left');
    $this->db->join('users u2', 'ci.updated_by = u2.id', 'left');
    $this->db->where('ci.id', $invoice_id);
    return $this->db->get()->row();  
}

public function update_invoice($id, $data) {
  $this->db->where('id', $id);
  return $this->db->update('customer_invoices', $data);
}

public function updateTotalAmount($invoice_id, $total) {
  $this->db->where('id', $invoice_id);
  $this->db->update('customer_invoices', ['total_amount' => $total]);
}


public function delete_invoice_with_items($invoice_id)
{
    // Delete related invoice items
    $this->db->where('invoice_ID', $invoice_id);
    $this->db->delete('invoice_items');

    // Delete the invoice
    $this->db->where('id', $invoice_id);
    return $this->db->delete('customer_invoices');
}


//this is mysql stored procedure write on the db to get the all invoices details
  /*
USE qbl_test;

DELIMITER  //

create procedure GetAllInvoices()
begin
	select
		ci.id,
        ci.invoiceNo,
        ci.created_at,
        ci.total_amount,
        ci.customer_id,
        c.name as customer_name,
        COUNT(ii.id) as item_count,
        ci.status
        
    from customer_invoices ci
    join customers c on c.id = ci.customer_id 
    left join invoice_items ii on ii.invoice_ID = ci.id
    group by ci.id
    order by ci.created_at desc;
end //

DELIMITER ;
*/
/*public function GetAllInvoices(){
  $query = $this->db->query("CALL GetAllInvoices()");

  return $query->result();
  }*/

/*
  public function GetAllInvoices() {
    $query = $this->db->query("CALL GetAllInvoices()");
    $result = $query->result();

    // Clear result set for the next stored procedure
    mysqli_next_result($this->db->conn_id); 
    return $result;
}
*/

//when applying the filter option used dynamic queries in PHP. it's more accurate 
public function GetAllInvoices($from_date = null, $to_date = null, $customer_id = null, $status = null) {
    $this->db->select('ci.id, ci.invoiceNo, ci.created_at, ci.total_amount, ci.customer_id, c.name as customer_name, COUNT(ii.id) as item_count, ci.status');
    $this->db->from('customer_invoices ci');
    $this->db->join('customers c', 'c.id = ci.customer_id');
    $this->db->join('invoice_items ii', 'ii.invoice_ID = ci.id', 'left');

    // Apply filters
    if (!empty($from_date)) {
        $this->db->where('ci.created_at >=', $from_date);
    }

    if (!empty($to_date)) {
        $this->db->where('ci.created_at <=', $to_date);
    }

    if (!empty($customer_id)) {
        $this->db->where('ci.customer_id', $customer_id);
    }

    if (!empty($status)) {
        $this->db->where('ci.status', $status);
    }

    $this->db->group_by('ci.id');
    $this->db->order_by('ci.created_at', 'DESC');

    $query = $this->db->get();
    return $query->result();
  }


/**
 * Retrieves the total invoice amount for each customer, with optional filters
 * based on customer ID and a date range.
 *
 * used Filters:
 * - $from_date: (optional) Start date to filter invoices by creation date.
 * - $to_date: (optional) End date to filter invoices by creation date.
 * - $customer_id: (optional) Specific customer ID to filter by.
 *
 * as a output it return
 * - An array of objects, each containing:
 *   - customer_id
 *   - total_amount (sum of all invoices for the customer within the filters)
 */
public function get_all_customers_invoice_summary($from_date = null, $to_date = null, $customer_id=null) {
    $this->db->select('customer_id, SUM(total_amount) AS total_amount');
    //
    $this->db->from('customer_invoices');


        // Apply customer filter
    if(!empty($customer_id)){
      $this->db->where('customer_id', $customer_id);
    }

    // Apply date range filters
    if(!empty($from_date)){
      $this->db->where('created_at >=', $from_date);
    }
    if (!empty($to_date)) {
        $this->db->where('created_at <=', $to_date);
    }

    $this->db->group_by('customer_id');
    $query = $this->db->get();

    return $query->result();
}

  public function customer_invoice_count($from_date = null, $to_date = null, $customer_id=null){
    $this->db->select('customer_id, COUNT(*) AS invoice_count');
    $this->db->from('customer_invoices');

    if(!empty($customer_id)){
      $this->db->where('customer_id', $customer_id);
    }

    // Apply date range filters
    if(!empty($from_date)){
      $this->db->where('created_at >=', $from_date);
    }
    if (!empty($to_date)) {
        $this->db->where('created_at <=', $to_date);
    }

    
    $this->db->group_by('customer_id');
    $query = $this->db->get();

    return $query->result();
  }

}