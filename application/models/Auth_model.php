<?php

class Auth_model extends CI_model {

    function __construct() { 
        parent::__construct();
        $this->load->helper('date');

        if (ENVIRONMENT == 'production') {
            $this->db->save_queries = FALSE;
        }
        date_default_timezone_set('Asia/Kolkata');
		$date = date('Y-m-d H:i:s', time());
    }
    
}
