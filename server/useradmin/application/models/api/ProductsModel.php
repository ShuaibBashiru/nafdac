<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class ProductsModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getInfo($data){
    try{
    $sql = "SELECT t1.*, t2.company_name FROM products_tbl t1 INNER JOIN company_tbl t2 ON t2.id=t1.company_id WHERE t1.product_id=?";
    $res = $this->db->query($sql, array($data['product_id']));
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