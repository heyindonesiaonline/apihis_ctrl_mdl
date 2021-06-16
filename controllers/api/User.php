<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('M_user','usr');
    }
    
    function profil_post() 
    {   
        $userid=$this->post('userid');
        $secretkey=$this->post('secretkey');

        $postdata = $this->usr->get_profil($userid,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }

    function updatepicture_post() 
    {   
        $userid=$this->post('userid');
        $imagedata=$this->post('imagedata');
        $secretkey=$this->post('secretkey');


        //proses upload image
        $path="assets/document/";
        $roomPhotoList = $this->post('imagedata');
        $random_digit=md5(date('Y_m_d_h_i_s'));
        $filename=$random_digit.'.jpg';
        $decoded=base64_decode($roomPhotoList);
        file_put_contents($path.$filename,$decoded);
        //

        $postdata = $this->usr->update_picture($userid,$path.$filename,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }

    
    
}
?>