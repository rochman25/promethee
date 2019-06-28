<?php

class Proses extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('DataModel'); 
        $this->load->library('form_validation');       
    }

    public function index(){
        if($this->_isLoggedIn()){
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            $data = array(
                "kriteria" => $kriteria,
                "profile" => $profile
            );
            $this->load->view('pages/seleksi_proses',$data);
        }else{
            redirect('admin/login');
        }
    }

    public function tambah(){

    }

    public function ubah(){

    }

    public function hapus(){
        
    }

    private function _isLoggedIn(){
        if(isset($this->session->userdata['admin_data']['status'])){
            return true;
        }else{
            return false;
        }
    }

}