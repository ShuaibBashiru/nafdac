<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Products extends CI_Controller{

    function preview(){
        try {
        $this->form_validation->set_rules('userid', 'userid', 'required|trim');
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
                $dir = "./userassets/temporary";
                if (!is_dir($dir)) {
                    mkdir($dir);
                }
                $getFileName = explode(".", $_FILES['fileupload']['name']);
                $ext = strtolower(end($getFileName));
                $namefile = date("y").(int)microtime(true).round(0,9);
                $filename = $namefile.'.'.$ext;
                $filepath =  $dir.'/'.$filename;
    
                $config['upload_path'] = $dir;
                $config['allowed_types'] = 'csv|xlsx';
                $config['max_size'] = '20000';
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('fileupload')) {

                $data = array(
                    "filepath" =>  $filepath,
                    "filename" =>  $filename,
                );

                $this->load->model('getExcel/Extract');
                $this->Extract->getFile($data);

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


    function upload(){
    try {
    $this->form_validation->set_rules('filename', 'filename to upload', 'required');
    $this->form_validation->set_rules('userid', 'userid', 'required|trim');
    $this->form_validation->set_rules('company_id', 'company id', 'required|trim');
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
            // $userid = $this->input->post('userid');
            // $this->load->model('auth/CheckSession');
            // $this->CheckSession->isSession($userid);
            $dir = "./userassets/temporary/";
            $filepath = $dir.$this->input->post('filename');

            $this->load->model('getExcel/Extract');
            $rows = $this->Extract->getUploaded($filepath);

            $data = array(
                "company_id" => $this->input->post('company_id'),
                "categ" =>  $this->input->post('filename'),
                "date_created" =>  date("Y-m-d"),
                "time_created" =>  date("h:s:i"),
                "created_by" => 0,
                "rows" => $rows,
            );
               
            $param = array(
                "userid" => $this->input->post('userid'),
            );

            $this->load->model('upload/ProductsModel');
            $this->ProductsModel->upload($data, $param);

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