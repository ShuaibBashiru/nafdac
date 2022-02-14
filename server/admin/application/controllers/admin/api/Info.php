<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Info extends CI_Controller{

function biodata(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/BiodataModel');
    $this->BiodataModel->getInfo($data);

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

function academic(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/AcademicModel');
    $this->AcademicModel->getInfo($data);

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

function document(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/DocumentModel');
    $this->DocumentModel->getInfo($data);

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
function applicationstatus(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/ApplicationStatusModel');
    $this->ApplicationStatusModel->getInfo($data);

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
function applicationdata(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/ApplicationDataModel');
    $this->ApplicationDataModel->getInfo($data);

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