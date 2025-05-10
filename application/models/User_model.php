<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model {
  public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load the database library
    }

    // Method to insert user data into the database
    public function create_user($data)
    {
        return $this->db->insert('users', $data); // Insert into the 'users' table
    }

    public function get_user_by_username($username)
  {
    $query = $this->db->get_where('users', ['userName' => $username]);
    return $query->row(); // returns single row object or null
  }
}