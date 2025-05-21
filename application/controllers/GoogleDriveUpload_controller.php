<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property Item_model $Item_model
 * @property Invoice_model $Invoice_model
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_output $output
 * @property CI_Router $router
 * @property Invoice_items_model $Invoice_items_model
 * @property Customer_invoices_model $Customer_invoices_model
 * @property Customer_model $Customer_model
 * @property Invoice_returns_model $Invoice_returns_model
 * @property Uploaded_files_model $Uploaded_files_model
 * @property CI_DB_query_builder|CI_DB_driver $db
 * @property CI_Upload $upload
 * @property GoogleDrive $googledrive
 * 
 */

class GoogleDriveUpload_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_model');
        $this->load->model('Item_model');
        $this->load->model('Customer_invoices_model');
        $this->load->model('Invoice_items_model');
        $this->load->model('Customer_model'); 
        $this->load->model('Invoice_returns_model');
        $this->load->model('Uploaded_files_model');
        $this->load->library('form_validation');
        $this->load->library('Googledrive');
        $this->load->helper(array('form', 'url'));
    }


    public function index(){
      $this->load->view('Drive/upload');
    }

    // Handle file upload and send to Google Drive
    public function do_upload() {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = '*'; 
        $config['max_size']      = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('Drive/upload', $error);

        } else {
            $data = $this->upload->data();

            // Google Drive upload
            $filename = $data['file_name'];
            $filepath = $data['full_path'];
            $folderId = '1zl3rO1Lr6DUP74Uy2FJlPj4PG3m_LzVV'; // Replace with actual folder ID

            $fileId = $this->googledrive->upload($filename, $filepath, $folderId);

            // Optional: save $fileId and file name to DB if needed
            $driveLink = "https://drive.google.com/file/d/{$fileId}/view";
            $mimeType = mime_content_type($filepath);

            $data = [
                'file_name' => $filename,
                'mime_type' => $mimeType,
                'file_id'   => $fileId,
                'drive_link' => $driveLink,
            ];


            $this->Uploaded_files_model->save_file_data($data);

/*
            $this->load->view('Drive/upload_success', [
                'fileId' => $fileId,
                'driveLink' => $driveLink,
            ]);*/

            // Set success message
              $this->session->set_flashdata('success', 'File uploaded successfully to Google Drive.');
              redirect('GoogleDriveUpload_controller/list_uploads');

        }
    }


    public function list_uploads() {
      $data['files'] = $this->Uploaded_files_model->get_file_date();
      $this->load->view('Drive/list_files', $data);
    }

}