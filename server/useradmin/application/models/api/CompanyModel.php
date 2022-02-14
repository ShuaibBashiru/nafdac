<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class CompanyModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}

function getInfo($data){
    try{
        $company_name=$data['company_name'];
    $sql = "SELECT * FROM company_tbl WHERE company_name LIKE ?";
    $res = $this->db->query($sql, array('%'.$company_name.'%'));
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


}