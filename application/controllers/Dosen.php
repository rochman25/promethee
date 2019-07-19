<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Dosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataModel');
        $this->load->library('form_validation');
        // $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }

    public function index()
    {
        if ($this->_isLoggedIn()) {
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            if ($profile->level != "superadmin") {
                $dosen = $this->DataModel->order_by('dosen.nama','ASC');
                $dosen = $this->DataModel->getWhere('prodi', $profile->prodi);
                $dosen = $this->DataModel->getData('dosen')->result_array();
            } else {
                $dosen = $this->DataModel->order_by('dosen.nama','ASC');
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
            // die(json_encode($id));
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $dosen = $this->DataModel->select('dosen.*, kriteria.nama as nama_kriteria, subkriteria.nama as nama_subkriteria, dosen_subkriteria.value as value_dosen_subkriteria, dosen_subkriteria.id as dosen_subkriteria_id,dosen_subkriteria.periode');
            $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen.nidn = dosen_subkriteria.nidn', 'inner');
            $dosen = $this->DataModel->getJoin('subkriteria', 'dosen_subkriteria.id_subkriteria = subkriteria.id', 'inner');
            $dosen = $this->DataModel->getJoin('kriteria', 'subkriteria.id_kriteria=kriteria.id', 'inner');
            $dosen = $this->DataModel->getWhere('dosen.nidn', $id);
            $dosen = $this->DataModel->getData('dosen')->result_array();
            // die(json_encode($dosen));   
            $data['nidn'] = $dosen[0]['nidn'];
            $data['nama'] = $dosen[0]['nama'];
            $data['jenis_kelamin'] = $dosen[0]['jenis_kelamin'];
            $data['prodi'] = $dosen[0]['prodi'];
            $data['periode'] = $dosen[0]['periode'];

            foreach ($dosen as $key => $value) {
                $data['kriteria'][$value['nama_kriteria']]['value'] = $value['nama_subkriteria'] != 'input' ? $value['nama_subkriteria'] : $value['value_dosen_subkriteria'];

                $data['kriteria'][$value['nama_kriteria']]['id'] = $value['dosen_subkriteria_id'];
            }
            $dosens = $data;
            $data = array(
                "data_calon" => $dosens,
                "profile" => $profile,
            );
            $this->load->view('pages/dosen/data_detail', $data);

        } else {
            redirect('admin/login');
        }
    }

    public function tambah()
    {
        if ($this->_isLoggedIn()) {
            $id_periode = $this->input->get('periode');
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
                $cek = $this->DataModel->getWhere('nidn',$nidn);
                $cek = $this->DataModel->getData('dosen')->row();
                // die(json_encode($cek));
                if($cek != null){
                    $this->DataModel->getWhere('nidn',$nidn);
                    $this->DataModel->update('dosen',$data);
                }else{
                    $this->DataModel->insert("dosen", $data);
                }
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
                    $dataS[$i]['periode'] = $id_periode;
                    $i++;
                    // $dataS[$i]['value'] = $value[$key];
                }
                // die(json_encode($dataS));
                $this->DataModel->insert_multiple("dosen_subkriteria", $dataS);
                redirect('proses?periode='.$id_periode);
            } else {
                $this->load->view('pages/dosen/form_dosen', $data);
            }
        } else {
            redirect('admin/login');
        }
    }

    

    public function import()
    {
        if ($this->_isLoggedIn()) {
            $id_periode = $this->input->get('periode');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $data = array(
                "profile" => $profile,
            );
            if ($this->input->post('kirim')) {
                if (!empty($_FILES['file']['name'])) {
                    $config['upload_path'] = "assets/data_dosen";
                    $config['file_name'] = date("y-m-d") . "data_dosen";
                    $config['allowed_types'] = 'xlsx|xls';
                    $config['overwrite'] = TRUE;
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('file')) {
                        echo " error " . "<br>";
                        var_dump($_FILES['file']);
                        // var_dump($_FILES['usulan']);
                        echo $this->upload->display_errors('<p>', '</p>');
                    } else {
                        // $media = $this->upload->data('file');
                        // die(json_encode($media));
                        $inputFileName = 'assets/data_dosen/' . date("y-m-d") . "data_dosen.xlsx";
                        try {
                            $objReader = new Xlsx();
                            $objReader->setReadDataOnly(true);
                            // $objReader->setLoadSheetsOnly("Sheet 1");
                            $objPHPExcel = $objReader->load($inputFileName);
                        } catch (Excepton $e) {
                            // die("error ".pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                        }
                        $datas = [];
                        $datas_dosen = [];
                        // var_dump($objPHPExcel->getActiveSheet()->toArray());
                        $sheet = $objPHPExcel->getActiveSheet();
                        $hr = $sheet->getHighestRow();
                        $hc = $sheet->getHighestColumn();
                        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($hc);
                        for ($row = 2; $row <= $hr; $row++) {
                            $dataArray = $objPHPExcel->getActiveSheet()
                                ->rangeToArray(
                                    'A' . $row . ':' . $hc . $row,
                                    NULL,
                                    TRUE,
                                    FALSE
                                );
                            $data_dosen['data'][] = array(
                                "nidn" => $dataArray[0][0],
                                "nama" => $dataArray[0][1],
                                "prodi" => $dataArray[0][2],
                                "jenis_kelamin" => $dataArray[0][3],
                            );
                            // $datas['data']['nidn'][] = $dataArray[0][0];
                            // $datas['data'][$dataArray[0][0]]['X1'] = $dataArray[0][4];
                            // $datas['data'][$dataArray[0][0]]['X2'] = $dataArray[0][5];
                            // $datas['data'][$dataArray[0][0]]['X3'] = $dataArray[0][6];
                            // $datas['data'][$dataArray[0][0]]['X4'] = $dataArray[0][7];
                            // $datas['data'][$dataArray[0][0]]['X5'] = $dataArray[0][8];
                            // $datas['data'][$dataArray[0][0]]['X6'] = $dataArray[0][9];
                            // $datas['data'][$dataArray[0][0]]['X7'] = $dataArray[0][10];
                            // $datas['data'][$dataArray[0][0]]['X8'] = $dataArray[0][11];
                            // $datas['data'][$dataArray[0][0]]['X9'] = $dataArray[0][12];
                            // $datas['data'][$dataArray[0][0]]['X10'] = $dataArray[0][13];
                            $datas['data'][] = array(
                                "nidn" => $dataArray[0][0],
                                "X1" => $dataArray[0][4],
                                "X2" => $dataArray[0][5],
                                "X3" => $dataArray[0][6],
                                "X4" => $dataArray[0][7],
                                "X5" => $dataArray[0][8],
                                "X6" => $dataArray[0][9],
                                "X7" => $dataArray[0][10],
                                "X8" => $dataArray[0][11],
                                "X9" => $dataArray[0][12],
                                "X10" => $dataArray[0][13],
                            );
                            // for($row = 0; $row <= 8; $row++){
                            //     $datass[] = array(
                                     
                            //     );
                            // }
                        }
                        $dat = array();
                        for($i=1;$i<=10;$i++){
                            $q = $this->DataModel->select('id');
                            $q = $this->DataModel->getWhere('simbol','X'.$i);
                            $q = $this->DataModel->getData('kriteria')->row();
                            // var_dump($q);
                            for($j=0; $j<count($datas['data']); $j++){
                                $dat['data'][$datas['data'][$j]['nidn']][$q->id] = $datas['data'][$j]['X'.$i];
                                // $dat['data'][]['bobot'][] = $datas['data'][$j]['X'.$i];
                            }
                        }
                        die(json_encode($dat));

                        for($i=0; $i<count($data_dosen['data']); $i++){
                            for($j=0; $j<count($dat['data'][$data_dosen['data'][0]['nidn']]); $j++){
                                $arr = array_keys($dat['data'][$data_dosen['data'][$i]['nidn']]);
                                echo $arr[$j] . "<br>";
                            }
                            // $j++;
                            // $arr = array_keys($dat['data'][$data_dosen['data'][$i]['nidn']]);
                            // echo $arr[$i] . "<br>";
                            // echo $dat['data'][];
                            // $q = $this->DataModel->select('id');
                            // $q = $this->DataModel->getWhere($dat['data'][$data_dosen['data'][$i]['nidn']])
                        }
                        die();
                        die(json_encode(($data_dosen)));
                    }
                }
            } else {
                $this->load->view('pages/dosen/import_file', $data);
            }
        } else {
            redirect('admin/login');
        }
    }

    public function ubah()
    {
        if ($this->_isLoggedIn()) {
            $id_periode = $this->input->get('periode');
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
            // die(json_encode($dosen));
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
                $this->DataModel->getWhere('nidn', $nidn);
                $this->DataModel->update('dosen', $data);
                $dataS = array();
                $i = 0;
                foreach ($old_sub_id as $key => $val) {
                    if (isset($value[$key])) {
                        $nilai = $value[$key];
                    } else {
                        $nilai = 0;
                    }
                    $dataS[$i]['id'] = $val;
                    $dataS[$i]['nidn'] = $nidn;
                    $dataS[$i]['id_subkriteria'] = $sub[$key];
                    $dataS[$i]['value'] = $nilai;
                    $dataS[$i]['periode'] = $id_periode;
                    $i++;
                }
                if (!empty($new_sub_id)) {
                    foreach ($new_sub_id as $key => $val) {
                        if (isset($value[$key])) {
                            $nilai = $value[$key];
                        } else {
                            $nilai = 0;
                        }
                        $dataS[$i]['nidn'] = $nidn;
                        $dataS[$i]['id_subkriteria'] = $sub[$key];
                        $dataS[$i]['value'] = $nilai;
                        $dataS[$i]['periode'] = $id_periode;
                        $i++;
                    }
                    $this->DataModel->insert_multiple("dosen_subkriteria", $dataS);
                }
                $this->DataModel->update_multiple("dosen_subkriteria", $dataS, "id");
                redirect('dosen/ubah?nidn=' . $nidn);
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
