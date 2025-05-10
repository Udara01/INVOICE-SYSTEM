<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	public function create_invoice($data){
		//return $this->db->insert('invoices', $data);
    $this->db->insert('invoices', $data);
    return $this->db->insert_id(); // This returns the actual inserted invoice ID

	}

  public function get_invoice_with_item($invoice_id) {
    $this->db->select('invoices.*, items.itemName, items.price, items.description');
    $this->db->from('invoices');
    $this->db->join('items', 'items.id = invoices.productID');
    $this->db->where('invoices.id', $invoice_id);
    return $this->db->get()->row();
  }

  public function get_all_invoices() {
    $this->db->select('invoices.*, items.itemName, items.price, items.description');
    $this->db->from('invoices');
    $this->db->join('items', 'items.id = invoices.productID');
    return $this->db->get()->result();
  }

  public function delete_invoice($invoice_id) {
    $this->db->where('id', $invoice_id);
    return $this->db->delete('invoices');
  }

  public function update_invoice($id, $data) {
    $this->db->where('id', $id);
    return $this->db->update('invoices', $data);
  }

}