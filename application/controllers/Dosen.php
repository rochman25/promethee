<?php

class Dosen extends CI_Controller
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
            if($profile->level != "superadmin"){
                $dosen = $this->DataModel->getWhere('prodi',$profile->prodi);
                $dosen = $this->DataModel->getData('dosen')->result_array();
            }else{
                $dosen = $this->DataModel->getData('dosen')->result_array();
            }
            $data = array(
                "datas" => $dosen,
                "profile" => $profile,
            );
            $this->load->view('pages/dosen/data', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function detail()
    {
        if ($this->_isLoggedIn()) {
            $id = $this->input->get('nidn');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $dosen = $this->DataModel->select('dosen.*, kriteria.nama as nama_kriteria, subkriteria.nama as nama_subkriteria, dosen_subkriteria.value as value_dosen_subkriteria, dosen_subkriteria.id as dosen_subkriteria_id');
            $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen.nidn = dosen_subkriteria.nidn', 'inner');
            $dosen = $this->DataModel->getJoin('subkriteria', 'dosen_subkriteria.id_subkriteria = subkriteria.id', 'inner');
            $dosen = $this->DataModel->getjOin('kriteria', 'subkriteria.id_kriteria=kriteria.id', 'inner');
            $dosen = $this->DataModel->getWhere('dosen.nidn', $id);
            $dosen = $this->DataModel->getData('dosen')->result_array();
            $data['nidn'] = $dosen[0]['nidn'];
            $data['nama'] = $dosen[0]['nama'];
            $data['jenis_kelamin'] = $dosen[0]['jenis_kelamin'];
            $data['prodi'] = $dosen[0]['prodi'];

            foreach ($dosen as $key => $value) {
                $data['kriteria'][$value['nama_kriteria']]['value'] = $value['nama_subkriteria'] != 'input' ? $value['nama_subkriteria'] : $value['value_dosen_subkriteria'];

                $data['kriteria'][$value['nama_kriteria']]['id'] = $value['dosen_subkriteria_id'];
            }
            $dosens = $data;
            $data = array(
                "data_calon" => $dosens,
                "profile" => $profile,
            );
            $this->load->view('pages/dosen/data_detail',$data);

        } else {
            redirect('admin/login');
        }
    }

    public function tambah()
    {
        if ($this->_isLoggedIn()) {
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->select("kriteria.id, kriteria.nama, kriteria.bobot, kriteria.jenis, subkriteria.nama as nama_subkriteria , subkriteria.bobot as bobot_subkriteria, subkriteria.id as subkriteria_id");
            $kriteria = $this->DataModel->getJoin('subkriteria', 'kriteria.id = subkriteria.id_kriteria', 'left');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            foreach ($kriteria as $key) {
                $datas[$key['nama']][] = $key;
            }
            $data = array(
                "datas" => $datas,
                "profile" => $profile,
                "mode" => "Tambah",
            );
            if ($this->input->post('kirim')) {
                $nidn = $this->input->post('nidn');
                $nama = $this->input->post('nama');
                $jk = $this->input->post('jenis_kelamin');
                $prodi = $this->input->post('prodi');
                $sub = $this->input->post('sub_id');
                $value = $this->input->post('value');
                $data = array(
                    "nidn" => $nidn,
                    "nama" => $nama,
                    "prodi" => $prodi,
                    "jenis_kelamin" => $jk,
                );
                $this->DataModel->insert("dosen", $data);
                $dataS = array();
                $i = 0;
                foreach ($sub as $key => $val) {
                    if (isset($value[$key])) {
                        $nilai = $value[$key];
                    } else {
                        $nilai = 0;
                    }
                    $dataS[$i]['nidn'] = $nidn;
                    $dataS[$i]['id_subkriteria'] = $val;
                    $dataS[$i]['value'] = $nilai;
                    $i++;
                    // $dataS[$i]['value'] = $value[$key];
                }
                // die(json_encode($dataS));
                $this->DataModel->insert_multiple("dosen_subkriteria", $dataS);
                redirect('dosen');
            } else {
                $this->load->view('pages/dosen/form_dosen', $data);
            }
        } else {
            redirect('admin/login');
        }
    }

    public function import(){
        if($this->_isLoggedIn()){
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $data = array(
                "profile" => $profile
            );
            if($this->input->post('kirim')){

            }else{
                $this->load->view('pages/dosen/import_file',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function ubah()
    {
        if ($this->_isLoggedIn()) {
            $id = $this->input->get('nidn');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->select("kriteria.id, kriteria.nama, kriteria.bobot, kriteria.jenis, subkriteria.nama as nama_subkriteria , subkriteria.bobot as bobot_subkriteria, subkriteria.id as subkriteria_id");
            $kriteria = $this->DataModel->getJoin('subkriteria', 'kriteria.id = subkriteria.id_kriteria', 'left');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            $dosen = $this->DataModel->select('dosen.*, kriteria.nama as nama_kriteria, subkriteria.nama as nama_subkriteria, dosen_subkriteria.value as value_dosen_subkriteria, dosen_subkriteria.id as dosen_subkriteria_id');
            $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen.nidn = dosen_subkriteria.nidn', 'inner');
            $dosen = $this->DataModel->getJoin('subkriteria', 'dosen_subkriteria.id_subkriteria = subkriteria.id', 'inner');
            $dosen = $this->DataModel->getjOin('kriteria', 'subkriteria.id_kriteria=kriteria.id', 'inner');
            $dosen = $this->DataModel->getWhere('dosen.nidn', $id);
            $dosen = $this->DataModel->getData('dosen')->result_array();
            foreach ($kriteria as $key) {
                $datas[$key['nama']][] = $key;
            }

            $data['nidn'] = $dosen[0]['nidn'];
            $data['nama'] = $dosen[0]['nama'];
            $data['jenis_kelamin'] = $dosen[0]['jenis_kelamin'];
            $data['prodi'] = $dosen[0]['prodi'];

            foreach ($dosen as $key => $value) {
                $data['kriteria'][$value['nama_kriteria']]['value'] = $value['nama_subkriteria'] != 'input' ? $value['nama_subkriteria'] : $value['value_dosen_subkriteria'];

                $data['kriteria'][$value['nama_kriteria']]['id'] = $value['dosen_subkriteria_id'];
            }
            $dosens = $data;
            $data = array(
                "datas" => $datas,
                "data_calon" => $dosens,
                "profile" => $profile,
                "mode" => "Ubah",
            );
            if ($this->input->post('kirim')) {
                $nidn = $this->input->get('nidn');
                $nama = $this->input->post('nama');
                $jk = $this->input->post('jenis_kelamin');
                $prodi = $this->input->post('prodi');
                $sub = $this->input->post('sub_id');
                $value = $this->input->post('value');
                $old_sub_id = $this->input->post('old_sub_id');
                $new_sub_id = $this->input->post('new_sub_id');
                $data = array(
                    "nama" => $nama,
                    "prodi" => $prodi,
                    "jenis_kelamin" => $jk,
                );
                $this->DataModel->getWhere('nidn',$nidn);
                $this->DataModel->update('dosen',$data);
                $dataS = array();
                $i = 0;
                foreach($old_sub_id as $key => $val){
                    if (isset($value[$key])) {
                        $nilai = $value[$key];
                    } else {
                        $nilai = 0;
                    }
                    $dataS[$i]['id'] = $val;
                    $dataS[$i]['nidn'] = $nidn;
                    $dataS[$i]['id_subkriteria'] = $sub[$key];
                    $dataS[$i]['value'] = $nilai;
                    $i++;
                }
                if(!empty($new_sub_id)){
                    foreach($new_sub_id as $key => $val){
                        if (isset($value[$key])) {
                            $nilai = $value[$key];
                        } else {
                            $nilai = 0;
                        }
                        $dataS[$i]['nidn'] = $nidn;
                        $dataS[$i]['id_subkriteria'] = $sub[$key];
                        $dataS[$i]['value'] = $nilai;
                        $i++;
                    }
                    $this->DataModel->insert_multiple("dosen_subkriteria",$dataS);
                }
                $this->DataModel->update_multiple("dosen_subkriteria",$dataS,"id");
                redirect('dosen/ubah?nidn='.$nidn);
                // die(json_encode($dataS));
            } else {
                // die(json_encode($data));
                $this->load->view('pages/dosen/form_dosen', $data);
            }
        } else {
            redirect('admin/login');
        }
    }

    public function hapus()
    {
        if ($this->_isLoggedIn()) {
            $id = $this->input->get('nidn');
            // die(json_encode($id));
            $this->DataModel->delete('nidn', $id, 'dosen_subkriteria');
            $this->DataModel->delete('nidn', $id, 'dosen');
            redirect('dosen');
        } else {
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
