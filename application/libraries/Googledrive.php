<?php
require_once FCPATH . 'vendor/autoload.php'; 

use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_DriveFile;


class Googledrive {

    protected $client;
    protected $service;

    public function __construct() {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(APPPATH . 'credentials.json');
        $this->client->addScope(Google_Service_Drive::DRIVE);
        $this->service = new Google_Service_Drive($this->client);
    }

public function upload($filename, $filepath, $folderId = null) {
    $fileMetadata = new Google_Service_Drive_DriveFile([
        'name' => $filename,
        'parents' => [$folderId]
    ]);

    $content = file_get_contents($filepath);

    $file = $this->service->files->create($fileMetadata, [
        'data' => $content,
        'mimeType' => mime_content_type($filepath),
        'uploadType' => 'multipart',
        'fields' => 'id'
    ]);

    return $file->id;
}

}