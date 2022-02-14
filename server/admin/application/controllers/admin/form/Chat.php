<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Chat extends CI_Controller{

function newchat(){
    try {
    $this->form_validation->set_rules('chatMessage', 'Message', 'required');
    $this->form_validation->set_rules('chatSessionID', 'Chat Session ID', 'required');
    $this->form_validation->set_rules('attendant_id', 'Attendant ID', 'required');
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
    $chats = array(
        "user_chat_id" => $this->input->post('userid'),
        "attendant_id" => $this->input->post('attendant_id'),
        "chatSessionID" => $this->input->post('chatSessionID'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );
    $message = array(
        "chatSessionID" => $this->input->post('chatSessionID'),
        "attendant_id" => $this->input->post('attendant_id'),
        "response_text" => $this->input->post('chatMessage'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );
    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('form/ChatModel');
$this->ChatModel->update($chats, $message, $param);

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

function closechat(){
    try {
    $this->form_validation->set_rules('chatSessionID', 'Chat Session ID', 'required');
    $this->form_validation->set_rules('attendant_id', 'Attendant ID', 'required');
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
    $update = array(
        "attendant_id" => $this->input->post('attendant_id'),
        "status_id" => 1,
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );
    $param = array(
        "userid" => $this->input->post('userid'),
        "chatSessionID" => $this->input->post('chatSessionID'),

    );
$this->load->model('form/ChatModel');
$this->ChatModel->closeChat($update, $param);

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