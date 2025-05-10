<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */

class DBcheck extends CI_Controller {

    public function index()
    {
        $this->load->database();

        try {
            $query = $this->db->query('SELECT 1');
            if ($query) {
                echo "Database Connected Successfully!";
            } else {
                echo "Failed to Connect to Database.";
            }
        } catch (Exception $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
}
