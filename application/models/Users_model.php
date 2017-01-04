<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function get_users($email)
    {
        $this->db->where('Email', $email);
        return $this->db->get('MsEmployee')->result();
    }

    public function get_users_by_emplid($emplid)
    {
        $this->db->where('EmployeeID', $emplid);
        return $this->db->get('MsEmployee')->result();
    }

    public function get_users_session($email)
    {
        $this->db->where('Email', $email);
        $this->db->select('EmployeeID, Role, Email');
        return $this->db->get('MsEmployee')->result()[0];
    }

    public function update_users_by_email($id, $object)
    {
        $this->db->where('EmployeeID', $id);
        $this->db->update('MsEmployee', $object);
    }

}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */