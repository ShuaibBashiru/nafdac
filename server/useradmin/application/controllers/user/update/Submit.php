<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Submit extends CI_Controller{

function update(){
    try {
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
        "applicant_number" => $this->input->post('userid'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $update = array(
        "date_modified" =>  date("Y-m-d"),
        "time_modified" =>  date("h:s:i"),
        "modified_by" => 0,
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('update/SubmitModel');
$this->SubmitModel->update($data, $param, $update);

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