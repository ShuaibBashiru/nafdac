<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Account extends CI_Controller{

    function addnew(){
    try {
    $this->form_validation->set_rules('surname', 'Surname', 'required');
    $this->form_validation->set_rules('firstname', 'Firstname', 'required');
    $this->form_validation->set_rules('email', 'Email address', 'required|valid_email');
    $this->form_validation->set_rules('phoneCode', 'Phone code', 'required');
    $this->form_validation->set_rules('phone', 'Phone number', 'required|numeric');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run()==false) {
        $response=array( 
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => array($this->form_validation->error_array()),
            'msg' => 'Please provide a valid information.',
            'classname' => 'alert-danger',
        );
        echo json_encode($response);
        die();
        }else{
    $data = array(
        "applicant_number" => 'N'.date("y").(int)microtime(true),
        "surname" => ucfirst(strtolower($this->input->post('surname'))),
        "firstname" => ucfirst(strtolower($this->input->post('firstname'))),
        "email_one" => $this->input->post('email'),
        "phoneCode" => $this->input->post('phoneCode'),
        "phone_one" => $this->input->post('phone'),
        "pwd_auth" => $this->input->post('password'),
        "pwd_auth_hash" => md5($this->input->post('password')),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
        "created_by" => 0,
    );
$this->load->model('form/AccountModel');
$this->AccountModel->AddNew($data);

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