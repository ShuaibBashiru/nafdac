<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class ProductsModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function upload($data, $param){
    $count = 0;
    $exist=0;
    $success=0;
    $failed=0;
    $message='';
    try{
        foreach ($data['rows'] as $key) {
        $count += 1;

        $data = array(
            "company_id" => $data['company_id'],
            "category_id" => 0,
            "product_id" => 'N'.date("y").(int)microtime(true),
            "category_name" => $key['category'],
            "descriptions" => $key['description'],
            "title" =>  $key['productname'],
            "date_created" =>  date("Y-m-d"),
            "time_created" =>  date("h:s:i"),
            "created_by" => 0,
        );

        $sql = "SELECT title FROM products_tbl WHERE title=? AND company_id = ?";
        $res = $this->db->query($sql, array($key['productname'], $data['company_id']));
    if ($res->num_rows() > 0) {
            $exist +=1;
    } else{
        
        $this->db->insert('products_tbl', $data);
            if ($this->db->affected_rows() > 0) {
            $success += 1;
            }else{
            $error = $this->db->error();
            $message = $error['message'];
            $failed += 1;

            }

}

}
// End of foreach
        if($success>0){
            $response=array( 
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => 'Success! Kindly check the details of your upload.',
                'classname' => 'alert-primary',
                'result' => '',  
                'redirect' => '',
                'total' => $count,
                'success' => $success,
                'failed' => $failed,
                'exist' => $exist,
            );
            echo json_encode($response);
            die();
        }else{
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Failed! seems like these records already exist, Kindly check the details of your upload.',
                'result' => $message,
                'error' => '',
                'total' => $count,
                'success' => $success,
                'failed' => $failed,
                'exist' => $exist,
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