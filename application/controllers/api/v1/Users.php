<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Users extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

    public function login_post()
    {
        $emplid = $this->input->post('emplid');
        $password = $this->input->post('password');

        if ($emplid == NULL || $password == NULL) $this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);
        else if ($emplid == "0") $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        else {
            $results = $this->users_model->get_users($emplid);
            if (count($results) == 0) $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
            else {

                if ($results[0]->EmployeeID == $emplid && $this->bcrypt->check_password($password, $results[0]->Password)) {
                    $this->response($this->users_model->get_users_session($emplid), REST_Controller::HTTP_OK);
                } else {
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }

            }
        }
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/api/v1/Users.php */