<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class BiodataModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getInfo($data){
    try{
    $sql = "SELECT * FROM applicant_record WHERE applicant_number=? LIMIT 1";
    $res = $this->db->query($sql, array($data['userid']));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
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


}