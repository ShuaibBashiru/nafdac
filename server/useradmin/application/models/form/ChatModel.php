<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class ChatModel extends CI_Model{

public function __construct(){
parent::__construct();
$this->load->database('default');
}

function update($chats, $message, $param){
    try{
    $sql = "SELECT id FROM chats_tbl WHERE user_chat_id=? AND chatSessionID=?";
    $res = $this->db->query($sql, array($param['userid'], $chats['chatSessionID']));
    if ($res->num_rows() > 0) {
        $this->db->insert('message_tbl', $message);
            if ($this->db->affected_rows() > 0) {
                $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => '',
                    'classname' => 'alert-primary',
                    'result' => '',  
                    'redirect' => '',
                );
                echo json_encode($response);
                die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
         // If not found, insert
    } else{
        $this->db->insert('chats_tbl', $chats);
         if ($this->db->affected_rows() > 0) {
            $this->db->insert('message_tbl', $message);
            if ($this->db->affected_rows() > 0) {
                $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => '',
                    'classname' => 'alert-primary',
                    'result' => '',  
                    'redirect' => '',
                );
                echo json_encode($response);
                die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
        }
            
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
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


function autoResponse($chats, $message, $param){
    try{
        $exp = explode(' ', $message['response_text']);
        $numexp = count($exp);
        if ($numexp > 1 AND ($exp[0]!='i' OR $exp[1]!='have')) {
            $text0 = $exp[0];
            $text1 = $exp[1];
            $text3 = $exp[2];
        }if ($numexp > 1 AND ($exp[0]=='i' OR $exp[1]=='have')) {
            $text0 = end($exp);
            $text1 = $exp[1];
            $text3 = $exp[0];

        }else{
           $text0 = end($exp);
           $text1 = $exp[1];
           $text3 = $exp[0];
        }
    $sql = "SELECT * FROM chats_bot_tbl WHERE title like ? OR (contents like ? OR contents like ? OR contents like ? OR contents like ?) LIMIT 1";
    $search1 = $message['response_text'];
    $res = $this->db->query($sql, array('%'.$search1.'%', '%'.$search1.'%', $search1.'%', '%'.$search1, $search1));
    if ($res->num_rows() > 0) {
        $result = $res->row();
        $newmessage = array(
            "chatSessionID" => $chats['chatSessionID'],
            "attendant_id" => 1,
            "response_text" => $result->contents,
            "date_created" =>  date("Y-m-d"),
            "time_created" =>  date("h:s:i"),
        );
        $this->db->insert('message_tbl', $newmessage);
            if ($this->db->affected_rows() > 0) {
            $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => '',
                    'classname' => 'alert-primary',
                    'result' => '',  
                    'redirect' => '',
                );
                echo json_encode($response);
                die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
         // If not found, insert
    } else{
        $newmessage = array(
            "chatSessionID" => $chats['chatSessionID'],
            "attendant_id" => 1,
            "response_text" => "Oops! i do not understand your search, try another.",
            "date_created" =>  date("Y-m-d"),
            "time_created" =>  date("h:s:i"),
        );

        $this->db->insert('message_tbl', $newmessage);
            if ($this->db->affected_rows() > 0) {
            $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => '',
                    'classname' => 'alert-primary',
                    'result' => '',  
                    'redirect' => '',
                );
                echo json_encode($response);
                die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }

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


function closeChat($update, $param){
    try{
    $sql = "SELECT id FROM chats_tbl WHERE user_chat_id=? AND chatSessionID=?";
    $res = $this->db->query($sql, array($param['userid'], $param['chatSessionID']));
    if ($res->num_rows() > 0) {
        $this->db->where('chatSessionID', $param['chatSessionID'])
                ->update('chats_tbl', $update);
        if ($this->db->affected_rows() > 0) {
            $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => 'This chat has been closed successfully',
                    'classname' => 'alert-primary',
                    'result' => '',  
                    'redirect' => '',
                );
                echo json_encode($response);
                die();
        }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
         // If not found, insert
    } else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
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



}