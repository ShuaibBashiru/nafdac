<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Academic extends CI_Controller{
  
function update(){
    
    try {
    $this->form_validation->set_rules('olevel', 'Olevel', 'required');
    $this->form_validation->set_rules('otherOlevel', 'Other olevel');
    $this->form_validation->set_rules('higher_school', 'Higher school');
    $this->form_validation->set_rules('degree', 'Degree');
    $this->form_validation->set_rules('grade', 'Grade');
    $this->form_validation->set_rules('yearOfGraduation', 'Year of Graduation');
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
        "olevelName" => strtoupper($this->input->post('olevel')),
        "otherOlevelName" =>  strtoupper($this->input->post('otherOlevel')),
        "higherInstitution" => ucfirst(strtolower($this->input->post('higher_school'))),
        "degree" => $this->input->post('degree'),
        "grade" => $this->input->post('grade'),
        "yearOfGraduation" => $this->input->post('yearOfGraduation'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
        "date_modified" =>  date("Y-m-d"),
        "time_modified" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $update = array(
        "olevelName" => strtoupper($this->input->post('olevel')),
        "otherOlevelName" =>  strtoupper($this->input->post('otherOlevel')),
        "higherInstitution" => ucfirst(strtolower($this->input->post('higher_school'))),
        "degree" => $this->input->post('degree'),
        "grade" => $this->input->post('grade'),
        "yearOfGraduation" => $this->input->post('yearOfGraduation'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
        "date_modified" =>  date("Y-m-d"),
        "time_modified" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('update/AcademicModel');
$this->AcademicModel->update($data, $param, $update);

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