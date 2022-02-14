<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Attachment extends CI_Controller{

function update(){
    try {
    $this->form_validation->set_rules('othername', 'Other name');
    $this->form_validation->set_rules('dob', 'Day of Birth', 'required|numeric');
    $this->form_validation->set_rules('mob', 'Month of Birth', 'required|numeric');
    $this->form_validation->set_rules('yob', 'Year of Birth', 'required|numeric');
    $this->form_validation->set_rules('gender', 'gender', 'required|numeric');
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
        "othername" => $this->input->post('othername'),
        "genderID" => ucfirst(strtolower($this->input->post('gender'))),
        "dob" => $this->input->post('dob'),
        "mob" => $this->input->post('mob'),
        "yob" => $this->input->post('yob'),
        "date_modified" =>  date("Y-m-d"),
        "time_modified" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('update/AttachmentModel');
$this->AttachmentModel->update($data, $param);

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