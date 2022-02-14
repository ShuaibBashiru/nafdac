<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class Api_model extends CI_Model{
public function __construct(){
parent::__construct();
$this->load->database('default');
}
function getLists($data){
    try{
    $rows = '';
    $totalRecord = 0;
    $no = $data['displayNumber'];
    $sql="SELECT TOP $no t1.*, t2.SchoolName FROM Ebportal.dbo.clearanceOfficer t1 INNER JOIN Ebportal.dbo.Schools t2 on t2.SchoolID=t1.school WHERE t1.session_id = ? AND t1.protype=? ORDER BY t1.Date_created DESC";
    $res=$this->db->query($sql, array($data['sessionid'], $data['program_type']));
    if($res->num_rows() > 0) {
    $rows=$res->result();
    $count_sql="SELECT t1.staffID FROM Ebportal.dbo.clearanceOfficer t1 WHERE t1.session_id = ? AND t1.protype=?";
    $counter=$this->db->query($count_sql, array($data['sessionid'], $data['program_type']));
    $newcounter=count($counter->result());
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'classname' => 'alert-primary',
            'msg' => '',
            'totalRecord' => $newcounter,
            'result' => $rows,
        );
        echo json_encode($response);
        die();
        }else{
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => 'No record found',
        );
        echo json_encode($response);
        die();
        }
 
    } catch (Exception $e) {
        $response=array( 
            'status' => 'server',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
            'msg' => 'Server error, kindly try again or report this error.',
        );
        echo json_encode($response);
        die();
    }

}
// SELECT t1.fullname as Name, t2.SchoolName, t1.passcode as ClearanceCode, t1.password FROM Ebportal.dbo.clearanceOfficer t1 INNER JOIN 
// Ebportal.dbo.Schools t2 on t2.SchoolID=t1.school WHERE t1.protype='FULL TIME' ORDER BY t2.SchoolName ASC
function searchLists($data){
    try{
if ($data['fetch']==1) {
$sql="SELECT t1.*, t2.SchoolName FROM Ebportal.dbo.clearanceOfficer t1 INNER JOIN Ebportal.dbo.Schools t2 on t2.SchoolID=t1.school WHERE t1.session_id = ? AND t1.protype=? AND (t1.fullname like ? OR t2.SchoolName like ? OR t1.passcode like ? OR t1.email like ? OR t1.phone like ?) ORDER BY t1.Date_created ASC";
$res=$this->db->query($sql, array($data['sessionid'], $data['program_type'], '%'.$data['search'].'%', '%'.$data['search'].'%', '%'.$data['search'].'%', '%'.$data['search'].'%', '%'.$data['search'].'%'));
if($res->num_rows() > 0) {
    $response=$res->result();
    $response=array( 
        'status' => 'success',
        'statusmsg' => 'success',
        'classname' => 'alert-primary',
        'msg' => '',
        'result' => $response
    );
    echo json_encode($response);
    die();
    }else{
    $response=array( 
        'status' => 'norecord',
        'statusmsg' => 'error',
        'classname' => 'alert-danger',
        'msg' => 'No record found for your search',

    );
    echo json_encode($response);
    die();
    }
}else{
    $response=array( 
        'status' => 'norecord',
        'statusmsg' => 'error',
        'classname' => 'alert-danger',
        'msg' => 'Something went wrong, kindly try again or report this error.',
    );
    echo json_encode($response);
    die();
};

    } catch (\Throwable $th) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'error' =>'',
            'msg' => 'Server error, kindly try again or report this error.',
        );
        echo json_encode($response);
        die();
    }

}


function getSchools($data){
    try{
if ($data['fetch']==1) {
$sql="SELECT * FROM Ebportal.dbo.Schools ORDER BY SchoolName ASC";
$res=$this->db->query($sql);
if($res->num_rows() > 0) {
    $response=$res->result();
    $response=array( 
        'status' => 'success',
        'statusmsg' => 'success',
        'classname' => 'alert-primary',
        'msg' => '',
        'result' => $response
    );
    echo json_encode($response);
    die();
    }else{
    $response=array( 
        'status' => 'norecord',
        'statusmsg' => 'error',
        'classname' => 'alert-danger',
        'msg' => 'No record found for your search',

    );
    echo json_encode($response);
    die();
    }
}else{
    $response=array( 
        'status' => 'norecord',
        'statusmsg' => 'error',
        'classname' => 'alert-danger',
        'msg' => 'Something went wrong, kindly try again or report this error.',
    );
    echo json_encode($response);
    die();
};

    } catch (\Throwable $th) {
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'error' =>'',
            'msg' => 'Server error, kindly try again or report this error.',
        );
        echo json_encode($response);
        die();
    }

}




function getPayment($data){
    try{
    if ($data['fetch']==1) {
    $sql="SELECT ApprovedAmount, lower(PaymentName) as PaymentName FROM Ebportal.dbo.vw_Transactions WHERE (payeenum = ? OR payeenum=?) AND paymentid in (5,6,7,70,4) AND sessionid=?";
    $res=$this->db->query($sql, array($data['user_id'], $data['user_id_2'], $data['sessionid']));
    if($res->num_rows() > 0) {
        $response=$res->result();
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'classname' => 'alert-primary',
            'msg' => '',
            'result' => $response
        );
        echo json_encode($response);
        die();
        }else{
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'msg' => 'This information do not have any transaction history',
    
        );
        echo json_encode($response);
        die();
        }
    }else{
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'userid' => $data['user_id'],
            'msg' => 'Something went wrong, kindly try again or report this error.',
        );
        echo json_encode($response);
        die();
    };

        } catch (\Throwable $th) {
            $response=array( 
                'status' => 'norecord',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'userid' => $data['user_id'],
                'error' =>'',
                'msg' => 'Server error, kindly try again or report this error.',
            );
            echo json_encode($response);
            die();
        }
    
    }

function ApprovalStatus($data){
    try {
    if ($data['fetch']==1) {
        if ($data['status']==1) {
           $status ='Approved';
        }else{
            $status ='Reversed';
        }
    $sql="UPDATE Hostel.dbo.allocation SET Approve=?, ApproverID=? WHERE Matricno = ?";
    $res=$this->db->query($sql, array($data['status'], $data['adminid'], $data['user_id']));
    if($res) {
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'classname' => 'alert-primary',
            'response' => $res,
            'userid' => $data['user_id'],
            'userStatus' => $status,
            'msg' => 'This record was '.($status).' successfully, please close this dialog if you are ok with this action.',
            'result' => ''
        );
        echo json_encode($response);
        die();
        }else{
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'response' => $res,
            'userid' => $data['user_id'],
            'msg' => 'This record could not be updated, kindly try again or report this error. Thanks',
    
        );
        echo json_encode($response);
        die();
        }
    }else{
        $response=array( 
            'status' => 'norecord',
            'statusmsg' => 'error',
            'classname' => 'alert-danger',
            'userid' => $data['user_id'],
            'msg' => 'Something went wrong, kindly try again or report this error.',
        );
        echo json_encode($response);
        die();
    };

        } catch (\Throwable $th) {
            $response=array( 
                'status' => 'norecord',
                'statusmsg' => 'error',
                'classname' => 'alert-danger',
                'userid' => $data['user_id'],
                'error' =>'',
                'msg' => 'Server error, kindly try again or report this error.',
            );
            echo json_encode($response);
            die();
        }
    // catch
    
    }


}