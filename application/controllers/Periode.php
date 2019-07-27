<?php

class Periode extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->_isLoggedIn()) {
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $periode = $this->DataModel->getData('periode')->result_array();
            $data = array(
                "profile" => $profile,
                "datas" => $periode
            );
            // die();
            $this->load->view('pages/periode/data',$data);

        }else{
            redirect('admin/login');
        }
    }

    public function detail()
    {

    }

    public function tambah()
    {
        if($this->_isLoggedIn()){
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $data = array(
                "profile" => $profile,
            );
            if($this->input->post('kirim')){
                $nama = $this->input->post('nama');
                $ket = $this->input->post('keterangan');
                $this->form_validation->set_rules('nama','Nama','required');
                if($this->form_validation->run() == FALSE){
                    $this->load->view('pages/periode/form_periode',$data);
                }else{
                    $data = array(
                        "nama" => $nama,
                        "keterangan" => $ket
                    );
                    $this->DataModel->insert('periode',$data);
                    redirect('periode');
                }

            }else{
                $this->load->view('pages/periode/form_periode',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function ubah()
    {
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $periode = $this->DataModel->getWhere('id',$id);
            $periode = $this->DataModel->getData('periode')->row();
            $data = array(
                "profile" => $profile,
                "data_periode" => $periode
            );
            if($this->input->post('kirim')){
                $nama = $this->input->post('nama');
                $ket = $this->input->post('keterangan');
                $this->form_validation->set_rules('nama','Nama','required');
                if($this->form_validation->run() == FALSE){
                    $this->load->view('pages/periode/form_periode',$data);
                }else{
                    $data = array(
                        "nama" => $nama,
                        "keterangan" => $ket
                    );
                    $this->DataModel->getWhere('id',$id);
                    $this->DataModel->update('periode',$data);
                    redirect('periode');
                }
            }else{
                $this->load->view('pages/periode/form_periode',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function hapus()
    {
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $this->DataModel->delete('id',$id,'periode');
            redirect('periode');
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
