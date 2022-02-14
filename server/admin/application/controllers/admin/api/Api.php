<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Api extends CI_Controller{

function lists(){
    $data = array(
        "fetch" => 1,
        "status" => $this->input->get('status'),
        "displayNumber" => $this->input->get('displayNumber'),
        "program_type" => $this->input->get('program_type'),
        "sessionid" => $this->input->get('sessionid'),
    );
$this->load->model('Api_model');
$this->Api_model->getLists($data);
}
function search(){
    $data = array(
        "fetch" => 1,
        "status" => $this->input->get('status'),
        "search" => $this->input->get('search'),
        "program_type" => $this->input->get('program_type'),
        "sessionid" => $this->input->get('sessionid'),
    );
$this->load->model('Api_model');
$this->Api_model->searchLists($data);
}

function getschools(){
    $data = array(
        "fetch" => 1,
        "school" => $this->input->get('schools'),
    );
$this->load->model('Api_model');
$this->Api_model->getSchools($data);
}

function paymentInfo(){
    $data = array(
        "fetch" => 1,
        "user_id" => $this->input->get('user_id'),
        "user_id_2" => $this->input->get('user_id_2'),
        "sessionid" => $this->input->get('sessionid'),
    );
$this->load->model('Api_model');
$this->Api_model->getPayment($data);
}

function approval(){
    if (isset($_COOKIE['userId'])) {
        $cookie = $_COOKIE['userId'];
    }else{
        $cookie = 0;
    }
    $data = array(
        "fetch" => 1,
        "user_id" => $this->input->get('user_id'),
        "sessionid" => $this->input->get('sessionid'),
        "status" => $this->input->get('status'),
        "adminid" => $cookie,
    );
$this->load->model('Api_model');
$this->Api_model->ApprovalStatus($data);
}


}