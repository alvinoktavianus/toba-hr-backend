<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class PersonalLeave extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pl_data');
    }

    public function create_post()
    {
        $request = json_decode(file_get_contents('php://input'));

        if ( $request->emplid == null ) {
            $this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);  
        } else {

            $balance = $this->pl_data->get_pl_balance($request->emplid);
            $diff = (int)date_diff($request->from, $request->to);

            if ( $balance == 0 ) {
                $this->response(NULL, REST_Controller::HTTP_UNAUTHORIZED);  
            } else if ( $request->type == "UL" ){
                // buat data dan kurangin current balance
                $this->response(NULL, REST_Controller::HTTP_CREATED);
            } else if ( $request->type == "PL" && $balance-$diff >= 0) {
                // buat data cuti
            } else if ( $request->type == "ML" ) {
                // buat data cuti, atur karyawan menjadi tidak aktif
            } else if ( $request->type == "SL" ) {
                // validasi jika izin 1 hari, maka tidak mengurangi cuti
                // validasi jika izin lebih dari 1 hari, maka mengurangi jatah cuti
            }
            
        }

    }

}

/* End of file PersonalLeave.php */
/* Location: ./application/controllers/api/v1/PersonalLeave.php */