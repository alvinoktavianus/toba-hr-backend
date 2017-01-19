<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PL_data extends CI_Model {

    public function get_pl_balance($id)
    {
        return (int)$this->db->get('MsEmployee')->result()[0]->PersonalLeaveBalance;
    }

}

/* End of file PL_data.php */
/* Location: ./application/models/PL_data.php */