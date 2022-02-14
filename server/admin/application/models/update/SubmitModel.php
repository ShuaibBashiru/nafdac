<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class SubmitModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function update($data, $param, $update){
    try{
    $sql = "SELECT applicant_number FROM application_completed WHERE applicant_number=?";
    $res = $this->db->query($sql, array($data['applicant_number']));
    if ($res->num_rows() > 0) {
        $this->db->where('applicant_number', $param['userid'])
                    ->update('application_completed', $update);

        if ($this->db->affected_rows() > 0) {
            $response=array( 
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => 'Your account was updated successfully, click on the next button to continue.',
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
        $sql = "SELECT applicant_number FROM applicants_passport WHERE applicant_number=?";
        $res = $this->db->query($sql, array($param['userid']));
        if ($res->num_rows() > 0) {
        $this->db->insert('application_completed', $data);
         if ($this->db->affected_rows() > 0) {
            $response=array( 
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => 'Your account was updated successfully, click on the next button to continue.',
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
        $response=array(
            'status' => 'error processing',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => 'You are yet to upload your passport, please go back to upload and complete the form.',
            'result' => '',
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