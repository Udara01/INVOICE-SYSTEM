<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Item_model extends CI_Model {
  public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

    
    public function add_item($data)
    {
        return $this->db->insert('items', $data); 
    }
/*
    public function showItems()
    {
        $query = $this->db->get('items'); // Get all items from the 'items' table
        return $query->result(); // returns array of objects
    }
*/

    public function showItems(){
        $this->db->select('items.*, categories.category_name');
        $this->db->from('items');
        $this->db->join('categories', 'categories.id = items.category_ID');
        $query = $this->db->get();
        return $query->result();
    }
    public function update_item($item_id, $data)
    {
        $this->db->where('id', $item_id); 
        return $this->db->update('items', $data); 
    }

    public function delete_item($item_id)
    {
        $this->db->where('id', $item_id); 
        return $this->db->delete('items'); 
    }


    public function reduceStock($item_id, $qty) {
    $this->db->set('stock', 'stock - ' . (int)$qty, FALSE);
    $this->db->where('id', $item_id);
    return $this->db->update('items');
}
public function getStockById($item_id) {
    $query = $this->db->get_where('items', ['id' => $item_id]);
    $row = $query->row();
    return $row ? (int)$row->stock : 0;
}


public function increase_stock($item_id, $quantity) {
    $this->db->set('stock', 'stock + ' . (int)$quantity, false);
    $this->db->where('id', $item_id);
    $this->db->update('items');
}



}