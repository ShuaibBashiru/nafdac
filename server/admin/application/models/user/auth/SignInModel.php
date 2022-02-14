<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class SignInModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}

function SignIn($data){
    try{
    $sql = "SELECT * FROM applicant_record WHERE email_one=? AND pwd_auth_hash=? LIMIT 1";
    $res = $this->db->query($sql, array($data['userid'], md5($data['password'])));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
        $this->session->set_userdata('usersession', $rows);
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Signed in successfully, you are now redirecting...',
            'classname' => 'alert-primary',
            'result' => $rows,
            'chatSessionID' => date("y").(int)microtime(true),
            'redirect' => '/app/secure/dashboard',
            'session' =>  $this->session->userdata('active'),
        );
        echo json_encode($response);
        die();
    }else{
        $error = $this->db->error();
        $response=array(
            'status' => 'error processing',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => 'Invalid login details, please try again.',
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