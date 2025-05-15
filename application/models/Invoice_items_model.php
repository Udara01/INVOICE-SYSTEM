<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_items_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function Add_invoiceItems($item_data){

    $this->db->insert('invoice_items', $item_data);
  }

  public function getItemsByInvoiceNo($invoiceNo) {
    $this->db->select('ii.*, i.itemName as item_name, i.price as item_price, i.description');

    $this->db->from('invoice_items ii');
    $this->db->join('items i', 'ii.productID = i.id');
    $this->db->where('ii.invoiceNo', $invoiceNo);
    $query = $this->db->get();
    return $query->result();
}
/*
 // Get raw items by invoice number (no joins)
 public function getRawItemsByInvoiceNo($invoiceNo) {
  return $this->db->get_where('invoice_items', ['invoiceNo' => $invoiceNo])->result();
}

// Delete all items by invoice number
public function deleteItemsByInvoiceNo($invoiceNo) {
  $this->db->delete('invoice_items', ['invoiceNo' => $invoiceNo]);
}*/

public function deleteInvoiceItemById($item_id) {
  return $this->db->delete('invoice_items', ['id' => $item_id]);
}


public function getTotalByInvoiceId($invoice_id) {
  $this->db->select('SUM(quantity * price) AS total');
  $this->db->from('invoice_items');
  $this->db->where('invoice_ID', $invoice_id);
  $query = $this->db->get();
  return $query->row()->total ?? 0;
}


public function update_invoice_item($item_id, $data)
{
    $this->db->where('id', $item_id);
    return $this->db->update('invoice_items', $data);
}

}