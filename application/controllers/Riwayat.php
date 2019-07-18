<?php

class Riwayat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if($this->_isLoggedIn()){
            $id = $this->input->post('periode');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $periode = $this->DataModel->getData('periode')->result_array();
            $data = array(
                "profile" => $profile,
                "periode" => $periode
            );
            if(!empty($id)){
                $rank = $this->DataModel->select('hasil_seleksi.nidn,hasil_seleksi.nilai,periode.nama as nama_periode,dosen.nama');
                $rank = $this->DataModel->order_by('nilai','desc');
                $rank = $this->DataModel->getJoin('dosen','hasil_seleksi.nidn = dosen.nidn','inner');
                $rank = $this->DataModel->getJoin('periode','periode.id = hasil_seleksi.periode','inner');
                if($profile->level == 'admin'){
                    $rank = $this->DataModel->getWhere('hasil_seleksi.prodi',$profile->prodi);
                }
                $rank = $this->DataModel->getWhere('periode',$id);
                $rank = $this->DataModel->getData('hasil_seleksi')->result_array();
                $data = array(
                    "profile" => $profile,
                    "periode" => $periode,
                    "datas" => $rank
                );
                $this->load->view('pages/riwayat',$data);
            }else{
                $this->load->view('pages/riwayat',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    private function _isLoggedIn()
    {
        if (isset($this->session->userdata['admin_data']['status'])) {
            return true;
        } else {
            return false;
        }
    }

}
