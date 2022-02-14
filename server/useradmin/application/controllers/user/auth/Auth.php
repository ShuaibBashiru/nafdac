<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");

class Auth extends CI_Controller{
function signin(){
    try {
    if ($this->session->userdata('usersession')) {
        $response=array(
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => '',
            'msg' => 'Active session detected, please refresh and try again.',
            'classname' => 'alert-danger',
        );
        $this->session->sess_destroy();
        echo json_encode($response);
        die();

    }else{
        $this->form_validation->set_rules('userid', 'User ID', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run()==false) {
            $response=array( 
                'status' => 'formerror',
                'statusmsg' => 'error',
                'error' => array($this->form_validation->error_array()),
                'msg' => 'Please provide a valid login details.',
                'classname' => 'alert-danger',
            );
            echo json_encode($response);
            die();
            }else{
        $data = array(
            "userid" => $this->input->post('userid'),
            "password" => $this->input->post('password'),
        );
    $this->load->model('auth/SignInModel');
    $this->SignInModel->SignIn($data);
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