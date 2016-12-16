<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function get_users($email)
    {
        $this->db->where('Email', $email);
        return $this->db->get('Ms_Employee')->result();
    }

    public function get_users_by_emplid($emplid)
    {
        $this->db->where('EmployeeID', $emplid);
        $this->db->select('EmployeeID, FullName');
        return $this->db->get('Ms_Employee')->result();
    }

    public function get_users_session($email)
    {
        $this->db->where('Email', $email);
        $this->db->select('EmployeeID, Role, Email');
        return $this->db->get('Ms_Employee')->result()[0];
    }

}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */