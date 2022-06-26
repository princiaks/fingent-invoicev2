<?php 
class My404 extends CI_Controller 
{
 public function __construct() 
 {
    parent::__construct(); 
 } 

 public function index() 
 { 
  $this->output->set_status_header('404'); 
  $this->load->view('site/header-intro');
  $this->load->view('site/not-found');
  $this->load->view('site/footer-intro');
  // $baseurl="http://".$_SERVER['HTTP_HOST'].preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])).'/';
  
 } 
} 
?>