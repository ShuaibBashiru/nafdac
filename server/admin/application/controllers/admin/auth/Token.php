<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Token extends CI_Controller{
function tokenize(){
    try {
    if ($this->input->get('token')=='') {
        $response=array( 
            'status' => 'formerror',
            'statusmsg' => 'error',
            'error' => '',
            'msg' => 'Error processing this request, kindly reload to continue.',
            'classname' => 'text-danger'

        );
        echo json_encode($response);
        die();
        }else{
    $response = array(
        'status' => 'success',
        'statusmsg' => 'success',
        'error' => '',
        'key' => $this->security->get_csrf_hash(),
        'msg' => 'Successful',
        'classname' => 'text-primary',
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
        'classname' => 'text-danger',
    );
    echo json_encode($response);
    die();
}
}
}