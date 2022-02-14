<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Items extends CI_Controller{

function addCategory(){
    try {
    $this->form_validation->set_rules('category_name', 'Category name', 'required');
    $this->form_validation->set_rules('category_description', 'Description');
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
        "category_name" => $this->input->post('category_name'),
        "category_description" => $this->input->post('category_description'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );

    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('form/ItemModel');
$this->ItemModel->addCateg($data, $param);
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


function additem(){
    try {
    $this->form_validation->set_rules('category_id', 'Category id', 'required');
    $this->form_validation->set_rules('item_title', 'Title', 'required');
    $this->form_validation->set_rules('item_description', 'Description', 'required');
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
        "category_id" => $this->input->post('category_id'),
        "title" => $this->input->post('item_title'),
        "contents" => $this->input->post('item_description'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );

    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('form/ItemModel');
$this->ItemModel->addItem($data, $param);
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