<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploaded_files_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function save_file_data($data){
      return $this->db->insert('uploaded_files', $data);
    }

    public function get_file_date(){
      return $this->db->get('uploaded_files')->result();
    }

}