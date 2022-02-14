<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");
class Item extends CI_Controller{

function itemlist(){
    $data = array(
        "fetch" => 1,
        "status" => 1,
        "displayNumber" => $this->input->get('limitTo'),
        "userid" => $this->input->get('userid'),
    );
$this->load->model('api/Item_Api_Model');
$this->Item_Api_Model->getItems($data);
}


}