<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class DropdownModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getItemCategory($data){
    try{
        $itemCategory = $this->itemCategory($data);
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Successfull',
            'classname' => 'alert-primary',
            'itemCategory' => $itemCategory,
        );
        echo json_encode($response);
        die();

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


function itemCategory($data){
    try{
    $sql = "SELECT * FROM item_category_tbl WHERE record_status=?";
    $res = $this->db->query($sql, array(1));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }
}


function countries($data){
    try{
    $sql = "SELECT * FROM country_list WHERE record_status=?";
    $res = $this->db->query($sql, array(1));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }

}

function programmes($data){
    try{
    $sql = "SELECT * FROM programmes WHERE record_status=?";
    $res = $this->db->query($sql, array(1));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }
}

function getStates($data){
    try{
    $sql = "SELECT * FROM state_list WHERE record_status=? AND country_id = ?";
    $res = $this->db->query($sql, array(1, $data['country_id']));
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

function getCity($data){
    try{
    $sql = "SELECT * FROM city_list WHERE record_status=? AND state_id = ?";
    $res = $this->db->query($sql, array(1, $data['state_id']));
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


function getDocuments($data){
    try{
    $sql = "SELECT * FROM documents WHERE record_status=?";
    $res = $this->db->query($sql, array(1));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
            $response=array(
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => 'Successfull',
                'classname' => 'alert-primary',
                'document_list' => $rows,  
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


}