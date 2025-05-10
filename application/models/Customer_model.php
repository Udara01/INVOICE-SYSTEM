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

}
