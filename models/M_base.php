<?php

// extends class Model
class M_base extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->secretkey_server = $this->config->item('secretkey_server');

        //config email
        $this->smtp_host = $this->config->item('smtp_host');
        $this->smtp_user = $this->config->item('smtp_user');
        $this->smtp_pass = $this->config->item('smtp_pass');
        //
    }


    function send_email($subject,$email,$message){

        //send email
        $config['useragent'] = 'CodeIgniter';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $this->smtp_host;
        $config['smtp_user'] = $this->smtp_user;
        $config['smtp_pass'] = $this->smtp_pass;
        $config['smtp_port'] = 587; 
        $config['smtp_timeout'] = 5;
        $config['wordwrap'] = TRUE;
        $config['wrapchars'] = 76;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['validate'] = FALSE;
        $config['priority'] = 3;
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['bcc_batch_mode'] = FALSE;
        $config['bcc_batch_size'] = 200;
        //end config
        $this->load->library('email');
        //$this->email->initialize($config);
        //konfigurasi pengiriman
        $this->email->from($this->smtp_user);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
    
        $result_email = $this->email->send();
        //end email

        return TRUE;  
    }




}

?>