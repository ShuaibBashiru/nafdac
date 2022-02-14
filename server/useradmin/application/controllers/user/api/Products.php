<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");

class Products extends CI_Controller{

function list(){
    $data = array(
        "fetch" => 1,
        "status" => 1,
        "displayNumber" => $this->input->get('limitTo'),
        "userid" => $this->input->get('userid'),
        "product_id" => $this->input->get('product_id'),
    );

$this->load->model('api/ProductsModel');
$this->ProductsModel->getInfo($data);
}


}