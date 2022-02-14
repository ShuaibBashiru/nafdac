<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class Item_Api_Model extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getItems($data){
    try{
    $sql = "SELECT t1.*, t2.category_name FROM items_tbl t1 INNER JOIN item_category_tbl t2 ON t2.id=t1.category_id";
    $res = $this->db->query($sql);
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