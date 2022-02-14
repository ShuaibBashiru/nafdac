<?php
try {
require_once('getExcel/extractor.php');
    $filename = 'grading.xlsx';
    $rows = extractFile($filename);
    $count = 1;
    foreach ($rows as $key) {
        echo $count.': '.$key['english'].' '.$key['mathematic'].' '.$key['biology'].' '.$key['chemistry'].'<br/>';
        $count += 1;
    }
    
} catch (Exception $e) {
    $response=array( 
        'status' => 'errorform',
        'statusmsg' => 'error',
        'error' => 'Technical error error',
        'msg' => 'Error processing your file, kindly try again or report this error.',
        'classname' => 'alert-danger',
    );
    echo json_encode($response);
    die();
}
