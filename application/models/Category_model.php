<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function add_category($data){
    $this->db->insert('categories', $data);
  }

  public function get_CategoryList(){
    $this->db->select('*');
    $this->db->from('categories');
    $query = $this->db->get();
    return $query->result();
  }

  public function update_category($id, $data) {
    $this->db->where('id', $id);
    return $this->db->update('categories', $data);
  }

  public function delete_category($category_Id){
    $this->db->where('id', $category_Id);
    return $this->db->delete('categories');
    
  }
}