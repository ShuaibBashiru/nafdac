<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Fileupload extends CI_Controller{

    function update(){
    try {
    // $this->form_validation->set_rules('fileupload', 'File upload', 'required');
    $this->form_validation->set_rules('userid', 'userid', 'required');
    $this->form_validation->set_rules('document_id', 'Document id', 'required');
    $this->form_validation->set_rules('name_specified', 'Name specfied');
    if ($this->form_validation->run()==false) {
        $response=array( 
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => array($this->form_validation->error_array()),
            'msg' => 'Please provide a valid file to upload.',
            'classname' => 'alert-danger',
        );
        echo json_encode($response);
        die();
        }else{
            $userid = $this->input->post('userid');
            $this->load->model('auth/CheckSession');
            $this->CheckSession->isSession($userid);
            
            $foldername = strtolower($this->input->post('userid'));
            $dir = "./userassets/documents/".$foldername;

            if (!is_dir($dir)) {
                mkdir($dir);
            }
            $getFileName = explode(".", $_FILES['fileupload']['name']);
            $ext = strtolower(end($getFileName));
            $namefile = date("y").(int)microtime(true).round(0,9);
            $filename = $namefile.'.'.$ext;

            $config['upload_path'] = $dir;
            $config['allowed_types'] = 'png|jpg|pdf';
            $config['max_size'] = '310';
            $config['file_name'] = $filename;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('fileupload')) {
                $data = array(
                    "applicant_number" => $this->input->post('userid'),
                    "document_id" => $this->input->post('document_id'),
                    "file_upload_name" => $filename,
                    "name_specified" => $this->input->post('name_specified'),
                    "date_created" =>  date("Y-m-d"),
                    "time_created" =>  date("h:s:i"),
                    "created_by" => 0,
                );
                $update = array(
                    "document_id" => $this->input->post('document_id'),
                    "file_upload_name" => $filename,
                    "name_specified" => $this->input->post('name_specified'),
                    "date_modified" =>  date("Y-m-d"),
                    "time_modified" =>  date("h:s:i"),
                    "created_by" => 0,
                );
                $param = array(
                    "userid" => $this->input->post('userid'),
                );
                $this->load->model('upload/FileUploadModel');
                $this->FileUploadModel->update($data, $param, $update);
            }else{
                $response=array( 
                    'status' => 'errorform',
                    'statusmsg' => 'error',
                    'error' => 'file error',
                    'msg' => 'Unacceptable file format or exceed the required details, please see the requirements and try again',
                    'classname' => 'alert-danger',
                );
                echo json_encode($response);
                die();
            }

        }
        } catch (Exception $e) {
            $response=array( 
                'status' => 'errorform',
                'statusmsg' => 'error',
                'error' => array($e->getMessage()),
                'msg' => 'Server error, kindly try again or report this error.',
                'classname' => 'alert-danger',
            );
            echo json_encode($response);
            die();
        }
        }
        }