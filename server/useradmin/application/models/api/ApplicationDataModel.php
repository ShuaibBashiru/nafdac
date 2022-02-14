<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class ApplicationDataModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getInfo($data){
    try{
        $biodata = $this->biodata($data);
        $contact = $this->contact($data);
        $academic = $this->academic($data);
        $programme = $this->programme($data);
        $gender = $this->gender($data);
        $document_with_id = $this->document_with_id($data);
        $document_with_no_id = $this->document_with_no_id($data);
        $response=array(
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => 'Successfull',
            'classname' => 'alert-primary',
            'biodata' => $biodata,
            'contact' => $contact,
            'academic' => $academic,
            'programme' => $programme,
            'gender' => $gender,
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

function biodata($data){
    try{
    $sql = "SELECT * FROM applicant_record WHERE applicant_number=? AND record_status=?";
    $res = $this->db->query($sql, array($data['userid'], 1));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }

}

function contact($data){
    try{
        $sql = "SELECT t2.country_name, t3.state_name, t4.city_name FROM applicant_record t1 INNER JOIN country_list t2 ON 
        t1.country_id=t2.country_id INNER JOIN state_list t3 ON t1.state_id = t3.state_id
        INNER JOIN city_list t4 ON t1.city_id=t4.city_id
        WHERE t1.applicant_number=? AND t1.record_status=?";
        $res = $this->db->query($sql, array($data['userid'], 1));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }

}


function academic($data){
    try{
        $sql = "SELECT * FROM academic_institution WHERE applicant_number=? AND record_status=?";
        $res = $this->db->query($sql, array($data['userid'], 1));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }

}

function programme($data){
    try{
        $sql = "SELECT t2.programme, t1.programme_duration, t3.country_name FROM applicant_record t1 INNER JOIN programmes t2 ON 
        t1.programme_id=t2.id INNER JOIN country_list t3 ON t1.programme_destination=t3.country_id
        WHERE t1.applicant_number=? AND t1.record_status=?";
        $res = $this->db->query($sql, array($data['userid'], 1));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
    }

}

function gender($data){
    try{
        $sql = "SELECT t2.genderName FROM applicant_record t1 INNER JOIN gender t2 ON 
        t1.gender_id=t2.id WHERE t1.applicant_number=? AND t1.record_status=?";
        $res = $this->db->query($sql, array($data['userid'], 1));
    if ($res->num_rows() > 0) {
        $rows=$res->row();
        return $rows;
    }else{
        return '';
    } 
    } catch (Exception $e) {
        return '0';
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