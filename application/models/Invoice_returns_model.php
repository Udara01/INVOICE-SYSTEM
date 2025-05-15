<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_returns_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getLastReturnInvoiceNo() {
        $this->db->select('return_invoice_no');
        $this->db->from('invoice_returns');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->return_invoice_no;
        } else {
            return null;
        }
    }

    public function create_return_invoice($data) {
        $this->db->insert('invoice_returns', $data);
        return $this->db->insert_id(); 
    }

    //fetch return invoice by ID
public function get_invoice_by_id($return_invoice_id) {
    $this->db->select('ir.*, ci.invoiceNo, ci.created_at, c.name as customer_name');
    $this->db->from('invoice_returns ir');
    $this->db->join('customer_invoices ci', 'ir.original_invoice_id = ci.id', 'left');
    $this->db->join('customers c', 'ir.customer_id = c.id', 'left');
    $this->db->where('ir.id', $return_invoice_id);
    return $this->db->get()->row();
}



public function get_all_return_invoices() {
    $this->db->select('ir.*, ci.invoiceNo, c.name as customer_name');
    $this->db->from('invoice_returns ir');
    $this->db->join('customer_invoices ci', 'ir.original_invoice_id = ci.id', 'left');
    $this->db->join('customers c', 'ir.customer_id = c.id', 'left');
    $this->db->order_by('ir.return_date', 'DESC');

    return $this->db->get()->result();
}

// In application/models/Invoice_returns_model.php
public function get_return_invoice_by_original_invoice_id($invoice_id) {
    $this->db->where('original_invoice_id', $invoice_id);
    return $this->db->get('invoice_returns')->row(); // returns null if not found
}

public function update_invoice($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('invoice_returns', $data);
}

public function delete_invoice($id) {
    $this->db->where('id', $id);
    $this->db->delete('invoice_returns');
}

}
