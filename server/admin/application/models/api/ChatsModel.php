<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class ChatsModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getCurrentChats($data){
    try{
    $sql = "SELECT t2.* FROM chats_tbl t1 INNER JOIN message_tbl t2 ON t1.chatSessionID=t2.chatSessionID WHERE t1.user_chat_id=? AND t1.chatSessionID=?";
    $res = $this->db->query($sql, array($data['userid'], $data['chatSessionID']));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Successfull',
            'classname' => 'alert-primary',
            'result' => $rows,  
        );
        echo json_encode($response);
        die();
    }else{
        $error = $this->db->error();
        $response=array(
            'status' => 'error processing',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => '',
            'result' => $error['message'],
            'error' => '',
        );
        echo json_encode($response);
        die();
} 
    } catch (Exception $e) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'msg' => 'Server error, kindly try again or report this error.',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
        );
        echo json_encode($response);
        die();
    }

}

function getChatsHistory($data){
    try{
    $sql = "SELECT t1.*, t2.surname, t2.firstname, t2.email_one FROM chats_tbl t1 INNER JOIN applicant_record t2 ON t1.user_chat_id=t2.email_one";
    $res = $this->db->query($sql);
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Successfull',
            'classname' => 'alert-primary',
            'result' => $rows,  
        );
        echo json_encode($response);
        die();
    }else{
        $error = $this->db->error();
        $response=array(
            'status' => 'error processing',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => '',
            'result' => $error['message'],
            'error' => '',
        );
        echo json_encode($response);
        die();
} 
    } catch (Exception $e) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'msg' => 'Server error, kindly try again or report this error.',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
        );
        echo json_encode($response);
        die();
    }

}
function getChatsCount($data){
    $pending = $this->getPending($data);
    $closed = $this->getClosed($data);
    $response=array(
        'status' => 'success',
        'statusmsg' => 'success',
        'msg' => 'Successfull',
        'classname' => 'alert-primary',
        'countPending' => $pending,  
        'countClosed' => $closed,  
    );
    echo json_encode($response);
    die();

}


function getPending($data){
    try{
    $sql = "SELECT * FROM chats_tbl WHERE status_id = 0";
    $res = $this->db->query($sql);
    if ($res->num_rows() > 0) {
        $rows=$res->result();
       return $rows;
    }else{
        $error = $this->db->error();
        return 0;
} 
    } catch (Exception $e) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'msg' => 'Server error, kindly try again or report this error.',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
        );
        echo json_encode($response);
        die();
    }

}

function getClosed($data){
    try{
    $sql = "SELECT * FROM chats_tbl WHERE status_id = 1";
    $res = $this->db->query($sql);
    if ($res->num_rows() > 0) {
        $rows=$res->result();
       return $rows;
    }else{
        $error = $this->db->error();
        return 0;
} 
    } catch (Exception $e) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'msg' => 'Server error, kindly try again or report this error.',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
        );
        echo json_encode($response);
        die();
    }

}


}