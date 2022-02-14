<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Auth_check extends CI_Controller{

function auth_check(){
    try {
    if ($this->session->userdata('usersession') AND ($this->session->userdata['usersession']->email_one == $this->input->get('userid'))) {
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'error' => '',
            'msg' => 'Active',
            'classname' => 'alert-primary',
            'result' => '',  
            'redirect' => '/app/site/logout',
        );
        echo json_encode($response);
        die();
        }else{
        $response = array(
            'status' => 'failed',
            'statusmsg' => 'error',
            'error' => '',
            'msg' => 'Session: Your session has expired, logging you out.',
            'classname' => 'alert-warning',
            'redirect' => '/app/site/logout',
        );
        echo json_encode($response);
        die();
}
} catch (Exception $e) {
    $response=array( 
        'status' => 'errorform',
        'statusmsg' => 'error',
        'error' => $e->getMessage(),
        'msg' => 'Server error, kindly try again or report this error. Logging you out...',
        'classname' => 'alert-warning',
        'redirect' => '/app/site/logout',
    );
    echo json_encode($response);
    die();
}
}

}