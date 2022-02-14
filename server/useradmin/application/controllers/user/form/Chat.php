<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Chat extends CI_Controller{

    
function newchat(){
    try {
    $this->form_validation->set_rules('chatMessage', 'Message', 'required');
    $this->form_validation->set_rules('chatSessionID', 'Chat Session ID', 'required');
    $this->form_validation->set_rules('userid', 'userid', 'required');
    if ($this->form_validation->run()==false) {
        $response=array(
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => array($this->form_validation->error_array()),
            'msg' => 'Your username is required.',
            'classname' => 'alert-danger',
        );
        echo json_encode($response);
        die();
        }else{
    $chats = array(
        "user_chat_id" => $this->input->post('userid'),
        "attendant_id" => 0,
        "chatSessionID" => $this->input->post('chatSessionID'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );
    $message = array(
        "chatSessionID" => $this->input->post('chatSessionID'),
        "attendant_id" => 0,
        "message_text" => $this->input->post('chatMessage'),
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



function replyChat(){
    try {
    $this->form_validation->set_rules('chatMessage', 'Message', 'required');
    $this->form_validation->set_rules('chatSessionID', 'Chat Session ID', 'required');
    $this->form_validation->set_rules('userid', 'userid', 'required');
    if ($this->form_validation->run()==false) {

        $response=array(
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => array($this->form_validation->error_array()),
            'msg' => 'Your username is required.',
            'classname' => 'alert-danger',
        );
        

        echo json_encode($response);
        die();
        }else{
    $chats = array(
        "user_chat_id" => $this->input->post('userid'),
        "attendant_id" => 1,
        "chatSessionID" => $this->input->post('chatSessionID'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );
    $message = array(
        "chatSessionID" => $this->input->post('chatSessionID'),
        "attendant_id" => 1,
        "response_text" => $this->input->post('chatMessage'),
        "date_created" =>  date("Y-m-d"),
        "time_created" =>  date("h:s:i"),
    );

    $param = array(
        "userid" => $this->input->post('userid'),
    );
$this->load->model('form/ChatModel');
$this->ChatModel->autoResponse($chats, $message, $param);
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