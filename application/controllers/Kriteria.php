<?php

class Kriteria extends CI_Controller
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
            $datas = null;
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->select("kriteria.id, kriteria.nama, kriteria.bobot, kriteria.jenis, subkriteria.nama as nama_subkriteria , subkriteria.bobot as bobot_subkriteria, subkriteria.id as subkriteria_id");
            $kriteria = $this->DataModel->getJoin('subkriteria','kriteria.id = subkriteria.id_kriteria','left');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            // die(json_encode($kriteria));
            foreach($kriteria as $key){
                $datas[$key['nama']][] = $key;
            }
            // die(json_encode($datas));
            $data = array(
                "datas" => $datas,
                "profile" => $profile,
            );
            $this->load->view('pages/kriteria/data', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function detail(){
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->select("kriteria.id, kriteria.nama, kriteria.bobot, kriteria.jenis, subkriteria.nama as nama_subkriteria , subkriteria.bobot as bobot_subkriteria, subkriteria.id as subkriteria_id");
            $kriteria = $this->DataModel->getWhere('kriteria.id',$id);
            $kriteria = $this->DataModel->getJoin('subkriteria','kriteria.id = subkriteria.id_kriteria','left');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            $data = array(
                "data_kriteria" => $kriteria,
                "profile" => $profile,
            );
            $this->load->view('pages/kriteria/data_detail', $data);
        }else{
            redirect('admin/login');
        }
    }

    public function tambah_sub(){
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $data = array(
                "profile" => $profile,
            );
            if($this->input->post('kirim')){
                $nama = $this->input->post('nama');
                $bobot = $this->input->post('bobot');
                $this->form_validation->set_rules('nama', 'Nama', 'required');
                $this->form_validation->set_rules('bobot', 'Bobot', 'required');
                $data = array(
                    "id_kriteria" => $id,
                    "nama" => $nama,
                    "bobot" => $bobot
                );
                $this->DataModel->insert('subkriteria',$data);
                redirect('kriteria/detail?id='.$id);
            }else{
                $this->load->view('pages/subkriteria/form_subkriteria',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function ubah_sub(){
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $kriteria_id = $this->input->get('kriteria_id');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $subKriteria = $this->DataModel->getWhere('id',$id);
            $subKriteria = $this->DataModel->getData('subkriteria')->row();
            $data = array(
                "data_subkriteria" => $subKriteria,
                "profile" => $profile,
            );
            if($this->input->post('kirim')){
                $nama = $this->input->post('nama');
                $bobot = $this->input->post('bobot');
                $this->form_validation->set_rules('nama', 'Nama', 'required');
                $this->form_validation->set_rules('bobot', 'Bobot', 'required');
                if($this->form_validation->run() == FALSE){
                    $this->load->view('pages/subkriteria/form_subkriteria',$data);
                }else{
                    $data = array(
                        "nama" => $nama,
                        "bobot" => $bobot
                    );
                    $result = $this->DataModel->getWhere('id',$id);
                    $result = $this->DataModel->update('subkriteria',$data);
                    redirect('kriteria/detail?id='.$kriteria_id);
                }
            }else{
                $this->load->view('pages/subkriteria/ubah_subkriteria',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function hapus_sub(){
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $kriteria_id = $this->input->get('kriteria_id');
            $this->DataModel->delete('id',$id,'subkriteria');
            redirect('kriteria/detail?id='.$kriteria_id);
        }else{
            redirect('admin/login');
        }
    }

    public function tambah()
    {
        if ($this->_isLoggedIn()) {
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $data = array(
                "profile" => $profile,
            );
            if ($this->input->post('kirim')) {
                $nama = $this->input->post('nama');
                $bobot = $this->input->post('bobot');
                $jenis = $this->input->post('jenis');
                $sub = $this->input->post('subkriteria');
                // die(json_encode($bobot));
                $nama_sub = $this->input->post('sub_nama');
                $bobot_sub = $this->input->post('sub_bobot');
                $this->form_validation->set_rules('nama', 'Nama', 'required');
                // $this->form_validation->set_rules('bobot', 'Bobot', 'required');
                $this->form_validation->set_rules('jenis', 'Jenis', 'required');
                if ($this->form_validation->run() == false) {
                    $this->load->view('pages/kriteria/form_kriteria', $data);
                } else {
                    $dataK = array(
                        "nama" => $nama,
                        // "bobot" => $bobot,
                        "jenis" => $jenis
                    );
                    $this->DataModel->insert('kriteria',$dataK);
                    if($sub == "Punya"){
                        // $dataS = array(
                        //     "id_kriteria" => $this->DataModel->getInsertId(),
                        //     "nama" => $nama_sub,
                        //     "bobot" => $bobot_sub
                        // );
                        $dataS = array();
                        $i=0;
                        foreach($nama_sub as $key => $val){
                            $dataS[$i]['id_kriteria'] = $this->DataModel->getInsertId();
                            $dataS[$i]['nama'] = $val;
                            $dataS[$i]['bobot'] = $bobot_sub[$key];
                            $i++;
                        }
                        $this->DataModel->insert_multiple("subkriteria",$dataS);
                        // die(json_encode($dataS));
                    }else{
                        $dataS = array(
                            "id_kriteria" => $this->DataModel->getInsertId(),
                            "nama" => "input",
                        );
                        $this->DataModel->insert('subkriteria',$dataS);
                    }
                    redirect('kriteria');                    
                }
            } else {
                $this->load->view('pages/kriteria/form_kriteria', $data);
            }
        } else {
            redirect('admin/login');
        }
    }

    public function ubah()
    {
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->getWhere('id',$id);
            $kriteria = $this->DataModel->getData('kriteria')->row();
            $data = array(
                "data_kriteria" => $kriteria,
                "profile" => $profile
            );
            if($this->input->post('kirim')){
                $nama = $this->input->post('nama');
                $bobot = $this->input->post('bobot');
                $jenis = $this->input->post('jenis');
                $this->form_validation->set_rules('nama', 'Nama', 'required');
                // $this->form_validation->set_rules('bobot', 'Bobot', 'required');
                $this->form_validation->set_rules('jenis', 'Jenis', 'required');
                if ($this->form_validation->run() == false) {
                    $this->load->view('pages/kriteria/form_kriteria', $data);
                } else {
                    $dataK = array(
                        "nama" => $nama,
                        "bobot" => $bobot,
                        "jenis" => $jenis
                    );
                    $this->DataModel->getWhere('id',$id);
                    $this->DataModel->update('kriteria',$dataK);
                    redirect('kriteria');
                }
            }else{
                $this->load->view('pages/kriteria/form_kriteria', $data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function hapus()
    {
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $this->DataModel->delete('id_kriteria',$id,'subkriteria');
            $this->DataModel->delete('id',$id,'kriteria');
            redirect('kriteria');
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
