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
        $request = json_decode(file_get_contents('php://input'));
        $email = $request->email;
        $password = $request->password;

        if ($email == NULL || $password == NULL) $this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);
        else {
            $results = $this->users_model->get_users($email);
            if ( count($results) == 0 ) $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
            else {
                if ( $results[0]->Email == $email && $this->bcrypt->check_password($password, $results[0]->Password) ) {
                    $this->response($this->users_model->get_users_session($email), REST_Controller::HTTP_OK);
                } else {
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/api/v1/Users.php */