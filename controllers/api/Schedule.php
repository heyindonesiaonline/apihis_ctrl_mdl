<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Schedule extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('M_schedule','sch');
    }
    
    function listschedule_post() 
    {   
        $userid=$this->post('userid');
        $secretkey=$this->post('secretkey');

        $postdata = $this->sch->list_schedule($userid,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }

    function add_post() 
    {   
        $userid=$this->post('userid');
        $days=$this->post('days');
        $start_time=$this->post('start_time');
        $end_time=$this->post('end_time');
        $secretkey=$this->post('secretkey');

        $postdata = $this->sch->add_schedule($userid,$days,$start_time,$end_time,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }

    function detail_post() 
    {   
        $userid=$this->post('userid');
        $schedule_id=$this->post('schedule_id');
        $secretkey=$this->post('secretkey');

        $postdata = $this->sch->detail_schedule($userid,$schedule_id,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }


    function update_post() 
    {   
        $userid=$this->post('userid');
        $schedule_id=$this->post('schedule_id');
        $days=$this->post('days');
        $start_time=$this->post('start_time');
        $end_time=$this->post('end_time');
        $secretkey=$this->post('secretkey');

        $postdata = $this->sch->update_schedule($schedule_id,$userid,$days,$start_time,$end_time,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }

    function delete_post() 
    {   
        $userid=$this->post('userid');
        $schedule_id=$this->post('schedule_id');
        $secretkey=$this->post('secretkey');

        $postdata = $this->sch->delete_schedule($userid,$schedule_id,$secretkey);
        if($postdata['ResponseCode'] == '00')
        {
            $this->response($postdata, 200);
        }else{
            $this->response($postdata);
        }
    }

    
    
}
?>