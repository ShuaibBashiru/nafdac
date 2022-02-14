<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class FileUploadModel extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function update($data, $param, $update){
    try{
          $sql = "SELECT applicant_number FROM applicants_document WHERE applicant_number=? AND (document_id =? AND document_id <> ?) OR (name_specified = ? AND document_id =?)";
        $res = $this->db->query($sql, array($data['applicant_number'], $data['document_id'], 0, $data['name_specified'], 0));
    if ($res->num_rows() > 0) {

        $sql = "UPDATE applicants_document SET document_id=?, file_upload_name=?, name_specified=?, date_modified=?, time_modified=?, created_by=? WHERE applicant_number=? AND (document_id =? AND document_id <> ?) OR (name_specified =? AND document_id=?)";
        $res = $this->db->query($sql, array($update['document_id'], $update['file_upload_name'], $update['name_specified'], $update['date_modified'], $update['time_modified'], $data['created_by'], $data['applicant_number'], $data['document_id'], 0, $data['name_specified'], 0));
        if ($this->db->affected_rows() > 0) {
            $response=array(
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => 'A similar file found with the same name has been updated successfully, click on the next button to continue.',
                'classname' => 'alert-primary',
                'result' => '',
                'redirect' => '',
            );
            echo json_encode($response);
            die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
         // If not found, insert
    } else{
        // Check if equal to 4
            $sql = "SELECT applicant_number FROM applicants_document WHERE applicant_number=?";
            $res = $this->db->query($sql, array($data['applicant_number']));
            if($res->num_rows() >= 4){
                $response=array( 
                    'status' => 'error',    
                    'statusmsg' => 'failed',
                    'msg' => 'You can only upload maximum of four (4) documents or update previously updated file by selection or enter the name.',
                    'classname' => 'alert-danger',
                    'result' => '',  
                    'redirect' => '',
                );
                echo json_encode($response);
                die();
            }else{
        $this->db->insert('applicants_document', $data);
         if ($this->db->affected_rows() > 0) {
            $response=array( 
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => 'Your document was updated successfully, click on the next button to continue.',
                'classname' => 'alert-primary',
                'result' => '',  
                'redirect' => '',
            );
            echo json_encode($response);
            die();
    }else{
        $error = $this->db->error();
            $response=array(
                'status' => 'error processing',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'msg' => 'Error updating your record, please try again later or report this error.',
                'result' => $error['message'],
                'error' => '',
            );
            echo json_encode($response);
            die();
   
        }
    }
// end of if not complete
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