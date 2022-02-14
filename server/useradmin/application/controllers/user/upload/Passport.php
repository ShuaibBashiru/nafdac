<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Passport extends CI_Controller{

function update(){
    try {
    // $this->form_validation->set_rules('fileupload', 'File upload', 'required');
    $this->form_validation->set_rules('userid', 'userid', 'required');
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
            $dir = "./userassets/passports/";

            $getFileName = explode(".", $_FILES['fileupload']['name']);
            $ext = strtolower(end($getFileName));
            $filename = strtolower($this->input->post('userid')).'.'.$ext;
            $filenameNoExt = strtolower($this->input->post('userid'));
            $config['upload_path'] = $dir;
            $config['allowed_types'] = 'png';
            $config['max_size'] = '151';
            $config['file_name'] = $filename;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('fileupload')) {
                // $image = imagecreatefrompng($dir.$filename);
                // imagejpeg($image, $dir.$filenameNoExt.'.jpg', 100); // 0 = worst / smaller file, 100 = better / bigger file 
                // imagedestroy($image);
                // unlink($dir.$filename);
                $data = array(
                    "applicant_number" => $this->input->post('userid'),
                    "passport_name" => $filename,
                    "date_created" =>  date("Y-m-d"),
                    "time_created" =>  date("h:s:i"),
                    "created_by" => 0,
                );

                $update = array(
                    "passport_name" => $filename,
                    "date_modified" =>  date("Y-m-d"),
                    "time_modified" =>  date("h:s:i"),
                    "created_by" => 0,
                );


                $param = array(
                    "userid" => $this->input->post('userid'),
                );
                $this->load->model('upload/PassportModel');
                $this->PassportModel->update($data, $param, $update);
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

    