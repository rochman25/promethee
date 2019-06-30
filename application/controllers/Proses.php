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
            $kriteria = $this->DataModel->distinct('*');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            foreach($kriteria as $key => $val){
                $datas['data'][$val['nama']] = $val;
                // echo $datas['data'][$val['nama']]['id'];
                $sub = $this->DataModel->getWhere('id_kriteria',$datas['data'][$val['nama']]['id']);
                $sub = $this->DataModel->getData('subkriteria')->result_array();
                foreach($sub as $key => $value){
                    $datas['data'][$val['nama']]['subkriteria'][] = $value;
                }
                $bobot[] =  $datas['data'][$val['nama']]['bobot'];
                // echo $key['nama'];
                // $sub = $this->DataModel->getWhere('id_kriteria',)
            }
            $datas['ekstra']['total_bobot'] = array_sum($bobot);
            // die(json_encode($datas));
            $data = array(
                "data_kriteria" => $datas,
                "kriteria" => $kriteria,
                "profile" => $profile
            );
            $this->load->view('pages/seleksi_proses',$data);
        }else{
            redirect('admin/login');
        }
    }

    public function seleksi(){
        if($this->_isLoggedIn()){
            
        }else{
            redirect('admin/login');
        }
    }

    private function _isLoggedIn(){
        if(isset($this->session->userdata['admin_data']['status'])){
            return true;
        }else{
            return false;
        }
    }

}