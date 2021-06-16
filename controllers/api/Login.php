<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('M_authentication','aut');
    }
    
    //get blog
    function login_post() {
        $result = $this->auth->login();
        $this->response($result, 200);
    }
    
    
}
?>