<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class CheckSession extends CI_Model{
function isSession($userid){
    try {
        if ($this->session->userdata('usersession') AND ($this->session->userdata['usersession']->email_one == $userid)) {
    }else{
        $response=array( 
            'status' => 'failed',
            'statusmsg' => 'error',
            'error' => '',
            'msg' => 'Session: Your session has expired, Log out and re-login to continue',
            'classname' => 'alert-warning',
            'result' => '',  
            'redirect' => '/app/site/logout',
        );
        $this->session->sess_destroy();
        echo json_encode($response);
        die();
    }
} catch (Exception $e) {
    $response=array( 
        'status' => 'errorform',
        'statusmsg' => 'error',
        'error' => $e->getMessage(),
        'msg' => 'Server: Your session has expired, Log out and re-login to continue',
        'classname' => 'alert-warning',
        'redirect' => '/app/site/logout',
    );
    echo json_encode($response);
    die();
}
}


}