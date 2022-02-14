<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class DocumentModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getInfo($data){
    try{
        $document_with_id = $this->document_with_id($data);
        $document_with_no_id = $this->document_with_no_id($data);
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Successfull',
            'classname' => 'alert-primary',
            'document_uploaded' => $document_with_id,
            'document_uploaded_2' => $document_with_no_id
        );
        echo json_encode($response);
        die();

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

function document_with_id($data){
    try{
    $sql = "SELECT t1.id, t1.applicant_number, t1.file_upload_name, t1.date_created, t2.documentName FROM applicants_document t1
     INNER JOIN documents t2 ON t1.document_id=t2.id WHERE t1.applicant_number=? AND t1.document_id<>? AND t1.record_status=?";
    $res = $this->db->query($sql, array($data['userid'], 0, 1));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {    
        return '0';
    }

}

function document_with_no_id($data){
    try{
    $sql = "SELECT t1.id, t1.applicant_number, t1.file_upload_name, t1.date_created, t1.name_specified as documentName FROM applicants_document t1 WHERE t1.applicant_number=? AND t1.document_id=? AND t1.record_status=?";
    $res = $this->db->query($sql, array($data['userid'], 0, 1));
    if ($res->num_rows() > 0) {
        $rows=$res->result();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }
}





}