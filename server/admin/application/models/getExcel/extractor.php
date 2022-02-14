<?php
function extractFile($filename){
    try {
        require_once('SimpleXLSX.php');
        if ($xlsx = SimpleXLSX::parse($filename)) {
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
                'msg' => 'Something went wrong with your file, kindly try again or report this error.',
                'classname' => 'alert-danger',
            );
            echo json_encode($response);
            die();
            // echo SimpleXLSX::parseError();
        }
        
    } catch (Exception $e) {
        $response=array( 
            'status' => 'errorform',
            'statusmsg' => 'error',
            'error' => 'Technical error error',
            'msg' => 'Technical error, kindly try again or report this error.',
            'classname' => 'alert-danger',
        );
        echo json_encode($response);
        die();
}

}