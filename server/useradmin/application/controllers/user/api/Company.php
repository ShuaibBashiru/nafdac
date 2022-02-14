<?php
defined('BASEPATH') OR exit("No direct script access allowed. Thanks");

class Company extends CI_Controller{
function list(){
    $data = array(
        "fetch" => 1,
        "status" => 1,
        "displayNumber" => $this->input->get('limitTo'),
        "userid" => $this->input->get('userid'),
        "company_name" => $this->input->get('company_name'),
    );

    
$this->load->model('api/CompanyModel');
$this->CompanyModel->getInfo($data);
}


}