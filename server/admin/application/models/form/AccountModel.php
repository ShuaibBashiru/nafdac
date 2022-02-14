<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class AccountModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function AddNew($data){
    try{
    $sql = "SELECT email_one, phone_one, applicant_number FROM admin_record WHERE email_one=? OR phone_one=? OR applicant_number=?";
    $res = $this->db->query($sql, array($data['email_one'], $data['phone_one'], $data['applicant_number']));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        foreach ($rows as $row){
        if ($data['email_one'] == $row->email_one) {
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'The Email address provided already in used, please try another or login to continue.',
                'result' => '',
                'error' => '',
            );
            echo json_encode($response);
            die();
        }elseif ($data['phone_one'] == $row->phone_one) {
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'The Phone number provided already in used, please try another or login to continue.',
                'result' => '',
                'error' => '',
            );
            echo json_encode($response);
            die();
        }elseif ($data['applicant_number'] == $row->applicant_number) {
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Something went wrong! Please try again later or report this error.',
                'result' => '',
                'error' => '',
            );
            echo json_encode($response);
            die();
        }else {
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'We are experiencing technical issue! Please try again later or report this error.',
                'result' => '',
                'error' => '',
            );
            echo json_encode($response);
            die();
        }
    }
    // if not exist
    }else{
    $this->db->insert('admin_record', $data);
    if ($this->db->affected_rows() > 0) {
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'New account was created successfully, please wait while you are being redirected.',
            'classname' => 'alert-primary',
            'result' => $data,  
            'redirect' => '/app/site/accountslip',
        );
        echo json_encode($response);
        die();
    }else{

        $error = $this->db->error();
        if(str_contains(strtolower($error['message']), 'duplicate')){
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Your Email or Phone number already in used, please try another.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
            
        }else{
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error processing request, kindly try again or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
        }
   
    }
} // End of if not exist
    } catch (Exception $e) {
        $response=array( 
            'status' => 'server',
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