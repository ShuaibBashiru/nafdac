<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Sponsor extends CI_Controller{

function update(){
    try {
    $this->form_validation->set_rules('sponsorName', 'Sponsor Name', 'required');
    $this->form_validation->set_rules('sponsorPhone', 'Sponsor Phone', 'required');
    $this->form_validation->set_rules('sponsorEmail', 'Sponsor Email', 'required');
    $this->form_validation->set_rules('sponsorOccupation', 'Sponsor Occupation', 'required');
    $this->form_validation->set_rules('sponsorRelationship', 'Sponsor Relationship', 'required');
    $this->form_validation->set_rules('sponsorAddress', 'Sponsor Address', 'required');
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
        "sponsorName" => ucfirst(strtolower($this->input->post('sponsorName'))),
        "sponsorPhone" => $this->input->post('sponsorPhone'),
        "sponsorEmail" => $this->input->post('sponsorEmail'),
        "sponsorOccupation" => ucfirst(strtolower($this->input->post('sponsorOccupation'))),
        "sponsorRelationship" => ucfirst(strtolower($this->input->post('sponsorRelationship'))),
        "sponsorAddress" => $this->input->post('sponsorAddress'),
        "date_modified" =>  date("Y-m-d"),
        "time_modified" =>  date("h:s:i"),
        "created_by" => 0,
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('update/SponsorModel');
$this->SponsorModel->update($data, $param);

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