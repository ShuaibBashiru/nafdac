<?php
defined('BASEPATH') OR exit('Error connecting, browse properly');
class Extract extends CI_Model{
function getFile($data){
    try{
        require_once('SimpleXLSX.php');
        if ($xlsx = SimpleXLSX::parse($data['filepath'])) {
        $header_values = $rows = [];
        foreach ($xlsx->rows() as $k => $r) {
            if ($k === 0) { 
                $header_values = $r;
                continue;
            }
            $rows[] = array_combine($header_values, $r);
        }
        
        $response=array( 
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => '',
            'classname' => 'alert-primary',
            'filename' => $data['filename'],
            'result' => $rows,  
            'redirect' => '',
        );
        echo json_encode($response);
        die();


        } else {
            $response=array( 
                'status' => 'errorform',
                'statusmsg' => 'error',
                'error' => 'File error',
                'msg' => 'Something went wrong with your file!, kindly try again or report this error.',
                'classname' => 'alert-danger',
            );
            echo json_encode($response);
            die();
        }
   
    } catch (Exception $e) {
        $response=array( 
            'status' => 'server',
            'statusmsg' => 'error',
            'msg' => 'Server error, kindly try again or report this error.',
            'classname' => 'alert-danger',
            'error' => $e->getMessage(),
        );
        echo json_encode($response);
        die();
    }

}


function getUploaded($filepath){
    try{
        require_once('SimpleXLSX.php');
        if ($xlsx = SimpleXLSX::parse($filepath)) {
        $header_values = $rows = [];
        foreach ($xlsx->rows() as $k => $r) {
            if ($k === 0) { 
                $header_values = $r;
                continue;
            }
            $rows[] = array_combine($header_values, $r);
        }
        
       return $rows;


        } else {
            $response=array( 
                'status' => 'errorform',
                'statusmsg' => 'error',
                'error' => 'File error',
                'msg' => 'Something went wrong with your file!, kindly try again or report this error.',
                'classname' => 'alert-danger',
            );
            echo json_encode($response);
            die();
        }
   
    } catch (Exception $e) {
        $response=array( 
            'status' => 'server',
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