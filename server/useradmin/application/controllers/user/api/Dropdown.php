<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Dropdown extends CI_Controller{
    public function __construct()
    {
    parent::__construct();
    $this->load->database('default');
    }
function info(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/DropdownModel');
    $this->DropdownModel->getInfo($data);

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

function states(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
        "country_id" => $this->input->get('country_id'),
    );
    $this->load->model('api/DropdownModel');
    $this->DropdownModel->getStates($data);

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

function city(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
        "state_id" => $this->input->get('state_id'),
    );
    $this->load->model('api/DropdownModel');
    $this->DropdownModel->getCity($data);

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

function documents(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/DropdownModel');
    $this->DropdownModel->getDocuments($data);

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
// End of controller
}