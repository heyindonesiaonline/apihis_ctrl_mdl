<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('M_auth','auth');
    }
    
    function login_post() 
    {   
        $email=$this->post('email');
        $password=$this->post('password');
        $secretkey=$this->post('secretkey');

        $postdata = $this->auth->login($email,$password,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }


    function register_post() 
    {   
        $username=$this->post('username');
        $email=$this->post('email');
        $password=$this->post('password');
        $type_account=$this->post('type_account');
        $secretkey=$this->post('secretkey');

        $postdata = $this->auth->register($username,$email,$password,$type_account,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }


    function forgetpassword_post() 
    {   
        $email=$this->post('email');
        $secretkey=$this->post('secretkey');

        $postdata = $this->auth->forget_password($email,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }


    function resetpassword_post() 
    {   
        $id=$this->post('id');
        $password=$this->post('password');
        $conf_password=$this->post('conf_password');
        $secretkey=$this->post('secretkey');

        $postdata = $this->auth->reset_password($id,$password,$conf_password,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }


    function changepassword_post() 
    {   
        $userid=$this->post('userid');
        $old_password=$this->post('old_password');
        $password=$this->post('password');
        $conf_password=$this->post('conf_password');
        $secretkey=$this->post('secretkey');

        $postdata = $this->auth->change_password($userid,$old_password,$password,$conf_password,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }
    
    
}
?>