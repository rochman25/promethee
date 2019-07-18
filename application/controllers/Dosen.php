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
                $dosen = $this->DataModel->getWhere('prodi', $profile->prodi);
                $dosen = $this->DataModel->getData('dosen')->result_array();
            } else {
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
            $this->load->view('pages/dosen/data_detail', $data);

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

    public function import()
    {
        if ($this->_isLoggedIn()) {
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
                        $datas = array();
                        $datass = array();
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
                            $datas[] = array(
                                "nidn" => $dataArray[0][0],
                                "nama" => $dataArray[0][1],
                                "prodi" => $dataArray[0][2],
                                "jenis_kelamin" => $dataArray[0][3]
                                // "nama" => 
                            );
                            // for($row = 0; $row <= 8; $row++){
                            //     $datass[] = array(
                                     
                            //     );
                            // }
                        }

                        die(json_encode($datas));
                        // echo '<table>' . PHP_EOL;
                        // foreach ($sheet->getRowIterator() as $row) {
                        //     echo '<tr>' . PHP_EOL;
                        //     $cellIterator = $row->getCellIterator();
                        //     $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
                        //     //    even if a cell value is not set.
                        //     // By default, only cells that have a value
                        //     //    set will be iterated.
                        //     foreach ($cellIterator as $cell) {
                        //         echo '<td>' .
                        //         $cell->getValue() .
                        //             '</td>' . PHP_EOL;
                        //     }
                        //     echo '</tr>' . PHP_EOL;
                        // }
                        // echo '</table>' . PHP_EOL;
                        // echo '<table>' . "\n";
                        // die(json_encode($highestColumnIndex));
                        // for ($row = 2; $row <= $hr; ++$row) {
                        //     // echo '<tr>' . PHP_EOL;
                        //     for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                        //         $value = $sheet->getCellByColumnAndRow($col, $row)->getValue();
                        //         // echo '<td>' . $value . '</td>' . PHP_EOL;
                        //         echo $value;
                        //         // $datas[] = $value;
                        //     }
                        //     // echo '</tr>' . PHP_EOL;
                        // }
                        // echo '</table>' . PHP_EOL;
                        // die(json_encode($datas));
                        // $id_s = 15;
                        // $id = 0;
                        // die(json_encode($hc));
                        // for ($row = 2; $row <= $hr; $row++){
                        //     $rowData = $sheet->rangeToArray('A' . $row . ':' . $hc . $row,
                        //                                     NULL,
                        //                                     TRUE,
                        //                                     FALSE);
                        //     for($id = 0; $id <= $highestColumnIndex; $id++){
                        //         $datas[] = array($rowData[0][$id]);
                        //     }
                        //     //Sesuaikan sama nama kolom tabel di database
                        //     //  $datas[] = array(
                        //     //      "nidn" => $rowData[0][0],
                        //     //      "nama" => $rowData[0][1],
                        //     //      "prodi" => $rowData[0][2],
                        //     //      "jenis_kelamin" => $rowData[0][3]
                        //     //  );

                        //     //  $datass[] = array(
                        //         //  "datas" => $rowData[0][$id],
                        //         //  "id_subkriteria" => $id_s,
                        //         //  "value" => $rowData[0][4],
                        //         //  "periode" => "1"
                        //     //  );
                        //     //  $id++;

                        //     //  $id_s++;
                        // }
                        // print_r($rowData);
                        die();
                        // die(json_encode($datas));
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
