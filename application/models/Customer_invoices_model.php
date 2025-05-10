<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_invoices_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function Add_Customer($invoice_data){
    $this->db->insert('customer_invoices', $invoice_data);
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
  $query = $this->db->get('customer_invoices'); // replace with your actual invoice table name
  return $query->row(); // returns a single row as object
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

/*
public function getInvoiceItems($invoice_id) {
  $this->db->select('invoice_items.*, productDescription, quantity');
  $this->db->from('invoice_items');
  $this->db->join('customer_invoices', 'customer_invoices.id = invoice_items.invoice_ID');
  $this->db->where('invoice_items.invoice_ID', $invoice_id);
  $query = $this->db->get();
  return $query->result(); // This will return the list of invoice items
}*/


public function getInvoiceItems($invoice_id) {
  $this->db->select('invoice_items.*, items.itemName, items.price, items.description');
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
    return $this->db->get()->row();  // Use ->row() to return a single invoice object
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


}