<?php

class M_schedule extends CI_Model{


    public function __construct() {
        parent::__construct();
        $this->secretkey_server = $this->config->item('secretkey_server');
        $this->base_url = $this->config->item('base_url');
        $this->load->model('M_base','base');
    }


    function list_schedule($userid,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {

            $sql_days = "SELECT id,(
                        CASE
                            WHEN days = '1' Then 'Sunday'
                            WHEN days = '2' Then 'Monday'
                            WHEN days = '3' Then 'Tuesday'
                            WHEN days = '4' Then 'Wednesday'
                            WHEN days = '5' Then 'Thursday'
                            WHEN days = '6' Then 'Friday'
                            WHEN days = '7' Then 'Saturday'
                        END
                        ) AS days, days AS days_id, start_time, end_time FROM schedule WHERE userid = '$userid' AND status = 1 AND days =";

            $sunday = $this->db->query($sql_days.'1')->result();
            $monday = $this->db->query($sql_days.'2')->result();
            $tuesday = $this->db->query($sql_days.'3')->result();
            $wednesday = $this->db->query($sql_days.'4')->result();
            $thursday = $this->db->query($sql_days.'5')->result();
            $friday = $this->db->query($sql_days.'6')->result();
            $saturday = $this->db->query($sql_days.'7')->result();

            $data = array(
                'ResponseCode' => '00',
                'Status' => 'Success',
                'Message' => 'List Data Schedule',
                'Data' => array(
                    'sunday' => $sunday,
                    'monday' => $monday, 
                    'tuesday' => $tuesday,
                    'wednesday' => $wednesday,
                    'thursday' => $thursday,
                    'friday' => $friday,
                    'saturday' => $saturday
                ) 
            );

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }

    function add_schedule($userid,$days,$start_time,$end_time,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {

            $sql_schedule = $this->db->query("SELECT id FROM schedule WHERE userid = '$userid' 
                AND start_time = '$start_time' AND days = '$days' AND end_time = '$end_time' ")->row();
            if (isset($sql_schedule)) {
                
                $data = array(
                    'ResponseCode' => '02',
                    'Status' => 'Failed',
                    'Message' => 'Data Exist', 
                );

            }else{
                $data_insert = array(
                    'days' => $days,
                    'start_time' => $start_time, 
                    'end_time' => $end_time,
                    'userid' => $userid,
                    'create_date' => date('Y-m-d h:i:s')
                );
                $data_execute = $this->db->insert('schedule',$data_insert);
                if ($data_execute = TRUE) {
                    $data = array(
                        'ResponseCode' => '00',
                        'Status' => 'Success',
                        'Message' => 'Success Add Schedule' 
                    );
                }else{
                    $data = array(
                        'ResponseCode' => '02',
                        'Status' => 'Failed',
                        'Message' => 'Failed Add Schedule' 
                    );
                }
            }

            

            

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }

    function detail_schedule($userid,$schedule_id,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {

            $sql_days = "SELECT id,(
                        CASE
                            WHEN days = '1' Then 'Sunday'
                            WHEN days = '2' Then 'Monday'
                            WHEN days = '3' Then 'Tuesday'
                            WHEN days = '4' Then 'Wednesday'
                            WHEN days = '5' Then 'Thursday'
                            WHEN days = '6' Then 'Friday'
                            WHEN days = '7' Then 'Saturday'
                        END
                        ) AS days, days AS days_id, start_time, end_time FROM schedule WHERE userid = '$userid' AND status = 1 AND id = '$schedule_id' ";

            $data_exec = $this->db->query($sql_days)->row();

            if (isset($data_exec)) {
                $data = array(
                    'ResponseCode' => '00',
                    'Status' => 'Success',
                    'Message' => 'List Data Schedule',
                    'Data' => array(
                        'days' => $data_exec->days,
                        'days_id' => $data_exec->days_id, 
                        'start_time' => $data_exec->start_time,
                        'end_time' => $data_exec->end_time
                    ) 
                );
            }else{
                $data = array(
                    'ResponseCode' => '03',
                    'Status' => 'Failed',
                    'Message' => 'Not Found Data Schedule', 
                );
            }
            

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }



    function update_schedule($schedule_id,$userid,$days,$start_time,$end_time,$secretkey){
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {


            //check data schedule
            $sql_schedule = "SELECT id FROM schedule WHERE id = '$schedule_id' AND userid = '$userid' ";
            $exec_schedule = $this->db->query($sql_schedule)->row();

            if (isset($exec_schedule)) {
                $data_insert = array(
                    'days' => $days,
                    'start_time' => $start_time, 
                    'end_time' => $end_time,
                    'userid' => $userid,
                    'update_date' => date('Y-m-d h:i:s')
                );
                $this->db->where('id',$schedule_id);
                $exec_update = $this->db->update('schedule',$data_insert);

                if ($exec_update = TRUE) {
                    $data = array(
                        'ResponseCode' => '00',
                        'Status' => 'Success',
                        'Message' => 'Success Update Schedule' 
                    );
                }else{
                    $data = array(
                        'ResponseCode' => '02',
                        'Status' => 'Failed',
                        'Message' => 'Failed Update Schedule' 
                    );
                }

            }else{
                $data = array(
                    'ResponseCode' => '03',
                    'Status' => 'Failed',
                    'Message' => 'Not Found Data Schedule', 
                );
            }
            
            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
    }

    function delete_schedule($userid,$schedule_id,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {

            $sql_schedule = $this->db->query("SELECT id FROM schedule WHERE userid = '$userid' AND id = '$schedule_id' ")->row();
            if (isset($sql_schedule)) {
                
                $this->db->query("UPDATE schedule SET status = '0' WHERE id = '$schedule_id' AND userid = '$userid' ");
                $data = array(
                    'ResponseCode' => '00',
                    'Status' => 'Success',
                    'Message' => 'Success Delete Data', 
                );

            }else{
                $data = array(
                    'ResponseCode' => '03',
                    'Status' => 'Failed',
                    'Message' => 'Not Found Data Schedule', 
                );
            }

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }


    
   



}

?>