<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Upload_files extends CI_Controller {

    public function __construct(){

        parent::__construct();
   
        // Load model
        $this->load->model('File');
     }

	public function index()
	{
        $data = array();
        $errorUploadType = $statusMsg = '';

        if ($this->input->post('fileSubmit')) {
            if (!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0) {
                $filesCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $filesCount; $i ++) {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    $config = array(
                        'upload_path' => "./uploads/",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => TRUE,
                        'max_size' => "100048000" // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        // 'max_height' => "768",
                        // 'max_width' => "1024"
                    );

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $fileData = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
                    } else {
                        $errorUploadType .= $_FILES['file']['name'] . ' | ';
                    }
                }

                $errorUploadType = !empty($errorUploadType) ? '<br/>File Type Error: ' . trim($errorUploadType, ' | ') : '';
                if (!empty($uploadData)) {
                    $insert = $this->File->insert($uploadData);
                    $statusMsg = $insert ? 'Files uploaded successfully!' . $errorUploadType : 'Some problem occured, try again.';
                } else {
                    $statusMsg = 'Sorry, there was an error uploading your file.' . $errorUploadType;
                }
            } else {
                $statusMsg = 'Please select image files to upload.';
            }
        }

        $data['files'] = $this->File->getRows();
        $data['statusMsg'] = $statusMsg;

		$this->load->view('upload_files', $data);
	}
}
