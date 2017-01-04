<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Users extends REST_Controller {

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('users_model');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id != null) {
            if ( count($this->users_model->get_users_by_emplid($id)) > 0 ) {
                $this->response($this->users_model->get_users_by_emplid($id)[0], REST_Controller::HTTP_OK);
            } else {
                $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function login_post()
    {
        $request = json_decode(file_get_contents('php://input'));
        $email = $request->email;
        $password = $request->password;

        if ($email == NULL || $password == NULL) {
            $this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $results = $this->users_model->get_users($email);
            if ( count($results) == 0 ) {
                $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
            } else {
                if ( $results[0]->Email == $email && $this->bcrypt->check_password($password, $results[0]->Password) && $results[0]->Role == 'emp' ) {
                    $this->response($this->users_model->get_users_session($email), REST_Controller::HTTP_OK);
                } else {
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }

    public function update_put()
    {
        $request = json_decode(file_get_contents('php://input'));
        $data = array();
        if ( isset($request->password) ) $data['Password'] = $this->bcrypt->hash_password($request->password);
        if ( isset($request->address) ) $data['Address'] = $request->address;
        if ( isset($request->postalcode) ) $data['PostalCode'] = $request->postalcode;
        if ( isset($request->phoneno) ) $data['PhoneNo'] = $request->phoneno;
        if ( $data != null ) {
            $data['UpdatedAt'] = date(DATE_W3C, now('Asia/Jakarta'));
            $data['UpdatedBy'] = $this->get('id');

            $this->db->trans_begin();
            $this->users_model->update_users_by_email($this->get('id'), $data);
            $this->db->trans_commit();  

            $this->response(null, REST_Controller::HTTP_ACCEPTED);

        }
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/api/v1/Users.php */