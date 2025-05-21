<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Composer autoloader
/*require_once APPPATH . '../vendor/autoload.php';

class Upload extends CI_Controller {

    public function index() {
        $this->load->view('upload_form');
    }

    public function do_upload() {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

            // Path to service account file
            $serviceAccountFile = APPPATH . 'credentials.json';

            if (!file_exists($serviceAccountFile)) {
                echo " Service account file not found at: " . $serviceAccountFile;
                exit;
            }

            // Setup Google Client
            $client = new Google_Client();
            $client->setAuthConfig($serviceAccountFile);
            $client->addScope(Google_Service_Drive::DRIVE);
            $client->setAccessType('offline');

            $service = new Google_Service_Drive($client);

            // Create file metadata
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => $_FILES['file']['name'],
                'parents' => ['1zl3rO1Lr6DUP74Uy2FJlPj4PG3m_LzVV'] // Replace with your folder ID
            ]);

            $content = file_get_contents($_FILES['file']['tmp_name']);

            try {
                $file = $service->files->create($fileMetadata, [
                    'data' => $content,
                    'mimeType' => $_FILES['file']['type'],
                    'uploadType' => 'multipart'
                ]);

                echo " File uploaded successfully!<br>📄 File ID: " . $file->id;
            } catch (Exception $e) {
                echo " Upload failed: " . $e->getMessage();
            }

        } else {
            echo " No file uploaded or upload error.";
        }
    }
}
*/