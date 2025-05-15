<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class returned_items_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_return_invoice_items($data) {
        $this->db->insert('returned_items', $data);
        return $this->db->insert_id();
    }

    // fetch items related to a return invoice
    public function get_items_by_invoice($return_invoice_id) {
        $this->db->select('ri.*, i.itemName, i.price');
        $this->db->from('returned_items ri');
        $this->db->join('items i', 'ri.item_id = i.id');
        $this->db->where('ri.return_invoice_id', $return_invoice_id);
        return $this->db->get()->result();
    }

    public function delete_items_by_invoice($return_invoice_id) {
    $this->db->where('return_invoice_id', $return_invoice_id);
    $this->db->delete('returned_items');
}

public function reverse_stock_by_invoice($return_invoice_id) {
    $items = $this->get_items_by_invoice($return_invoice_id);
    foreach ($items as $item) {
        $this->Item_model->reduceStock($item->item_id, $item->quantity);
    }
}

}
