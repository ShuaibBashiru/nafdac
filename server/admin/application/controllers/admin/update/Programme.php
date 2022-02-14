<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Programme extends CI_Controller{

function update(){
    try {
    $this->form_validation->set_rules('programme', 'Programme', 'required');
    $this->form_validation->set_rules('duration', 'Duration', 'required');
    $this->form_validation->set_rules('destination', 'Destination', 'required');
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
        "programme_id" => $this->input->post('programme'),
        "programme_duration" => $this->input->post('duration'),
        "programme_destination" => $this->input->post('destination'),
        "date_modified" =>  date("d-m-Y"),
        "time_modified" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('update/ProgramModel');
$this->ProgramModel->update($data, $param);

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