<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Logout extends CI_Controller{

function logmeout(){
    try {
    if ($this->session->userdata('usersession')) {
        $this->session->unset_userdata('usersession');
        $this->session->sess_destroy();
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'error' => '',
            'msg' => 'Session: Your session has expired, logging you out...',
            'classname' => 'alert-primary',
            'result' => '',  
            'redirect' => '/app/site/signin',

        );
        echo json_encode($response);
        die();
        }else{
        $response = array(
            'status' => 'success',
            'statusmsg' => 'success',
            'error' => '',
            'key' => $this->security->get_csrf_hash(),
            'msg' => 'Session: Your session has expired, logging you out...',
            'classname' => 'alert-primary',
            'redirect' => '/app/site/signin',
    );
    echo json_encode($response);
    die();
}
} catch (Exception $e) {
    $response=array( 
        'status' => 'errorform',
        'statusmsg' => 'error',
        'error' => $e->getMessage(),
        'msg' => 'Server error, kindly try again or report this error.',
        'classname' => 'alert-danger',
    );
    echo json_encode($response);
    die();
}
}
}