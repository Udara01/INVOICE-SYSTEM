<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

  public function get_all_customers() {
    return $this->db->get('customers')->result();
  }

  public function add_customer($data) {
    $this->db->insert('customers', $data);
    return $this->db->insert_id();
  }

  
  public function get_customer($customer_id) {
    $this->db->where('id', $customer_id); 
    $query = $this->db->get('customers'); 
    return $query->row(); 
}

public function update_customer($customer_id, $post_data) {
    // Validate the input data
    $this->form_validation->set_data($post_data);
    $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
    $this->form_validation->set_rules('customer_address', 'Customer Address', 'required');
    $this->form_validation->set_rules('customer_phone', 'Customer Phone', 'required|regex_match[/^[0-9]{10}$/]'); 

    if ($this->form_validation->run() === FALSE) {
        return FALSE; // Validation failed
    }
    
  $data = [
    'name' => $post_data['customer_name'],
    'address' => $post_data['customer_address'],
    'phone' => $post_data['customer_phone'],
  ];

    $this->db->where('id', $customer_id); 
    return $this->db->update('customers', $data); 
  }

  public function delete_customer($customer_id){
    $this->db->where('id', $customer_id);
    return $this->db->delete('customers');
  }

  public function get_all_transactions_by_customer($customer_id)
{
    // Invoices
    $this->db->select('id, "invoice" as type, created_at as date, total_amount as total')
             ->from('customer_invoices')
             ->where('customer_id', $customer_id);
    $invoice_query = $this->db->get_compiled_select();

    // Return Invoices
    $this->db->select('id, "return_invoice" as type, return_date as date, total_return_amount as total')
             ->from('invoice_returns')
             ->where('customer_id', $customer_id);
    $return_query = $this->db->get_compiled_select();

    // Combine them
    $query = $this->db->query($invoice_query . ' UNION ALL ' . $return_query . ' ORDER BY date DESC');

    return $query->result();
}

public function get_all_invoices() {
    return $this->db->select('id, invoiceNo, customer_id')->from('customer_invoices')->get()->result();
}

public function get_all_valid_invoices_for_return() {
    $this->db->select('ci.id, ci.invoiceNo, ci.customer_id');
    $this->db->from('customer_invoices ci');
    $this->db->join('invoice_returns ir', 'ci.id = ir.original_invoice_id', 'left');
    $this->db->where('ir.original_invoice_id IS NULL');
    return $this->db->get()->result();
}




}
