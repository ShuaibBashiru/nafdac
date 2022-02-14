<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class ItemModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function addCateg($data, $param){
    try{
    $sql = "SELECT id FROM item_category_tbl WHERE category_name=?";
    $res = $this->db->query($sql, array($data['category_name']));
    if ($res->num_rows() == 0) {
        $this->db->insert('item_category_tbl', $data);
            if ($this->db->affected_rows() > 0) {
            $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => 'Item created successfully',
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
                'msg' => 'Error creating record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
         // If not found, insert
    } else{
    $response=array( 
            'status' => 'exist',
            'statusmsg' => 'success',
            'msg' => 'Sorry! This item already exist, please confirm and try again.',
            'classname' => 'alert-danger',
            'result' => '',  
            'redirect' => '',
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


function addItem($data, $param){
    try{
    $sql = "SELECT id FROM items_tbl WHERE category_id=? AND title=? AND contents=?";
    $res = $this->db->query($sql, array($data['category_id'],$data['title'],$data['contents']));
    if ($res->num_rows() == 0) {
        $this->db->insert('items_tbl', $data);
            if ($this->db->affected_rows() > 0) {
            $response=array( 
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => 'Item created successfully',
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
                'msg' => 'Error creating record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
         // If not found, insert
    } else{
    $response=array( 
            'status' => 'exist',
            'statusmsg' => 'success',
            'msg' => 'Sorry! This item already exist, please confirm and try again.',
            'classname' => 'alert-danger',
            'result' => '',  
            'redirect' => '',
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