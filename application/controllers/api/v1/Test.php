<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Test extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function users_get()
    {
        $id = $this->get('id');
        if ( $id == NULL ) {
            $mahasiswa = $this->db->get('mahasiswa')->result();
            $this->response($mahasiswa, REST_Controller::HTTP_OK);
        } else if ( $id > 0 ){
            $this->db->where('id', $id);
            $mahasiswa = $this->db->get('mahasiswa')->result();
            if ( !empty($mahasiswa) ) $this->response($mahasiswa, REST_Controller::HTTP_OK);
            else $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
        } else{
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function users_post()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat')
        );
        if ( $this->db->insert('mahasiswa', $data) )
            $this->response(NULL, REST_Controller::HTTP_OK);
        else
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    }

}

/* End of file Test.php */
/* Location: ./application/controllers/api/v1/Test.php */