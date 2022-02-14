<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Chats extends CI_Controller{

function currentChat(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
        "chatSessionID" => $this->input->get('chatSessionID'),
    );
    $this->load->model('api/ChatsModel');
    $this->ChatsModel->getCurrentChats($data);

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


function chatHistory(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/ChatsModel');
    $this->ChatsModel->getChatsHistory($data);

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


function counts(){
    try {
    $data = array(
        "userid" => $this->input->get('userid'),
    );
    $this->load->model('api/ChatsModel');
    $this->ChatsModel->getChatsCount($data);

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