<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Contact extends CI_Controller{

function update(){
    try {
    $this->form_validation->set_rules('country', 'Country', 'required|numeric');
    $this->form_validation->set_rules('state', 'State', 'required|numeric');
    $this->form_validation->set_rules('city', 'City', 'required|numeric');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('userid', 'userid', 'required');
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
            $userid = $this->input->post('userid');
            $this->load->model('auth/CheckSession');
            $this->CheckSession->isSession($userid);
    $data = array(
        "country_id" => $this->input->post('country'),
        "state_id" => $this->input->post('state'),
        "city_id" => $this->input->post('city'),
        "address_one" => $this->input->post('address'),
        "date_modified" =>  date("Y-m-d"),
        "time_modified" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('update/ContactModel');
$this->ContactModel->update($data, $param);

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