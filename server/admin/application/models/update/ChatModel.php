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
                    'msg' => 'Sent 1',
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
                    'msg' => 'Sent 2',
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


}