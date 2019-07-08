<?php

class Proses extends CI_Controller
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
            $id_periode = $this->input->post('periode');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $periode = $this->DataModel->getData('periode')->result_array();
            $kriteria = $this->DataModel->distinct('*');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            $dosen = $this->DataModel->select('dosen.*, kriteria.nama as nama_kriteria, subkriteria.nama as nama_subkriteria, dosen_subkriteria.value as value_dosen_subkriteria, dosen_subkriteria.id as dosen_subkriteria_id');
            $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen.nidn = dosen_subkriteria.nidn', 'inner');
            $dosen = $this->DataModel->getJoin('subkriteria', 'dosen_subkriteria.id_subkriteria = subkriteria.id', 'inner');
            $dosen = $this->DataModel->getjOin('kriteria', 'subkriteria.id_kriteria=kriteria.id', 'inner');
            $dosen = $this->DataModel->getData('dosen')->result_array();
            foreach ($kriteria as $key => $val) {
                $datas['data'][$val['nama']] = $val;
                // echo $datas['data'][$val['nama']]['id'];
                $sub = $this->DataModel->getWhere('id_kriteria', $datas['data'][$val['nama']]['id']);
                $sub = $this->DataModel->getData('subkriteria')->result_array();
                $input_paramter = $this->DataModel->getWhere('periode',$this->input->post('periode'));
                $input_paramter = $this->DataModel->getWhere('id_kriteria',$datas['data'][$val['nama']]['id']);
                $input_parameter = $this->DataModel->getData('input_parameter')->result_array();
                foreach ($sub as $key => $value) {
                    $datas['data'][$val['nama']]['subkriteria'][] = $value;
                }
                foreach ($input_parameter as $key => $value2){
                    $datas['data'][$val['nama']]['input_parameter'][] = $value2;
                }
                $bobot[] = $datas['data'][$val['nama']]['bobot'];
                // echo $key['nama'];
                // $sub = $this->DataModel->getWhere('id_kriteria',)
            }
            $datas['ekstra']['total_bobot'] = array_sum($bobot);
            // die(json_encode($datas));
            $data = array(
                "data_kriteria" => $datas,
                "kriteria" => $kriteria,
                "profile" => $profile,
                "periode" => $periode,
                "id_periode" => $id_periode
            );
            $this->load->view('pages/seleksi_proses', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function seleksi()
    {
        if ($this->_isLoggedIn()) {
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->distinct('*');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            $dosen = $this->DataModel->distinct('*');
            $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen.nidn = dosen_subkriteria.nidn', 'inner');
            $dosen = $this->DataModel->getData('dosen')->result_array();
            foreach ($kriteria as $key => $val) {
                $datas['data'][$val['nama']] = $val;
                // echo $datas['data'][$val['nama']]['id'];
                $sub = $this->DataModel->getWhere('id_kriteria', $datas['data'][$val['nama']]['id']);
                $sub = $this->DataModel->getData('subkriteria')->result_array();
                foreach ($sub as $key => $value) {
                    $datas['data'][$val['nama']]['subkriteria'][] = $value;
                }
                $bobot[] = $datas['data'][$val['nama']]['bobot'];
                // echo $key['nama'];
                // $sub = $this->DataModel->getWhere('id_kriteria',)
            }
            $datas['ekstra']['total_bobot'] = array_sum($bobot);
            $data_kriteria = $datas;
            unset($datas);

            foreach ($dosen as $key => $val) {
                $datas['data'][$val['nidn']] = $val;

                $dos = $this->DataModel->select('kriteria.nama, kriteria.id, subkriteria.nama AS nama_subkriteria, subkriteria.bobot AS bobot_subkriteria, dosen_subkriteria.value');
                $dos = $this->DataModel->getJoin('subkriteria', 'subkriteria.id = dosen_subkriteria.id_subkriteria', 'inner');
                $dos = $this->DataModel->getJoin('kriteria', 'kriteria.id = subkriteria.id_kriteria', 'inner');
                $dos = $this->DataModel->getWhere('dosen_subkriteria.nidn', $datas['data'][$val['nidn']]['nidn']);
                $dos = $this->DataModel->getData('dosen_subkriteria')->result_array();
                // die(json_encode($dos));
                foreach ($dos as $key => $value) {
                    $datas['data'][$val['nidn']]['kriteria'][$value['nama']] = $value;
                }

            }
            $data_calon = $datas;
            unset($datas);

            $tipe = $this->input->post('tipe');
            $q = $this->input->post('q');
            $p = $this->input->post('p');
            $id_kriteria = $this->input->post('id_kriteria');
            // die(json_encode($q));
            $jarak_kriteria = [];
            $h_d = [];
            $ranking = [];
            $hasil = [];
            $ranking_hasil = [];
            $ranking_input = [];
            $input_parameter = [];

            foreach($q as $key => $val){
                // echo $key;
                $input_parameter[] = array(
                    "id_kriteria" => $id_kriteria[$key],
                    "tipe" => $tipe[$key],
                    "q" => $val,
                    "p" => $p[$key],
                    "periode" => $this->input->post('periode_id')
                );
            }
            $this->DataModel->insert_multiple('input_parameter',$input_parameter);
            // die(json_encode($input_parameter));

            foreach ($data_kriteria['data'] as $key_kriteria => $value_kriteria) {

                $bobot = $value_kriteria['bobot'] / $data_kriteria['ekstra']['total_bobot'];
                // var_dump($value_kriteria);
                // die(json_encode($bobot));
                $y = 1;
                // Jarak Kriteria
                // die(json_encode($data_calon));
                foreach ($data_calon['data'] as $key_dosen_y => $value_dosen_y) {
                    $tmp_bobot_y = $value_dosen_y['kriteria'][$key_kriteria]['nama_subkriteria'] == 'input' ? $value_dosen_y['kriteria'][$key_kriteria]['value'] : $value_dosen_y['kriteria'][$key_kriteria]['bobot_subkriteria'];
                    // die(json_encode($value_dosen_y));
                    // var_dump($value_dosen_y);
                    foreach ($data_calon['data'] as $key_dosen_x => $value_dosen_x) {
                        // die(json_encode($value_dosen_x));
                        $tmp_bobot_x = $value_dosen_x['kriteria'][$key_kriteria]['nama_subkriteria'] == 'input' ? $value_dosen_x['kriteria'][$key_kriteria]['value'] : $value_dosen_x['kriteria'][$key_kriteria]['bobot_subkriteria'];
                        // echo json_encode($tmp_bobot_x);
                        $jka = $tmp_bobot_x - $tmp_bobot_y;
                        // var_dump($tmp_bobot_x);
                        // var_dump($tmp_bobot_y);
                        // var_dump($jka);
                        $jarak_kriteria[$key_kriteria]['A' . $y][] = $jka;

                        $nilai_pref = $this->_NilaiPreferensi($tipe[$value_kriteria['id']], $jka, $q[$value_kriteria['id']], $p[$value_kriteria['id']], $bobot);
                        // var_dump($nilai_pref);
                        $h_d[$key_kriteria]['A' . $y][] = $nilai_pref;
                        // die(json_encode($h_d));
                    }
                    $y++;
                }

            }
            // die();
            // die(json_encode($jarak_kriteria));
            // die(json_encode($h_d));
            for ($i = 0; $i < count($data_calon['data']); $i++) {

                for ($j = 0; $j < count($data_calon['data']); $j++) {

                    $tmp_sum = 0;
                    foreach ($data_kriteria['data'] as $key => $value) {

                        $tmp_sum += $h_d[$key]['A' . ($i + 1)][$j];

                    }
                    $ranking['A' . ($i + 1)][$j] = $tmp_sum;
                }
                $hasil['A' . ($i + 1)]['leaving'] = array_sum($ranking['A' . ($i + 1)]) / (count($data_calon['data']) - 1);
            }
            $j = 0;
            foreach ($data_calon['data'] as $key => $value) {
                $tmp_entering = 0;
                for ($i = 0; $i < count($data_calon['data']); $i++) {
                    $tmp_entering += $ranking['A' . ($i + 1)][$j];
                }
                $hasil['A' . ($j + 1)]['entering'] = $tmp_entering / (count($data_calon['data']) - 1);
                $hasil['A' . ($j + 1)]['net_flow'] = $hasil['A' . ($j + 1)]['leaving'] - $hasil['A' . ($j + 1)]['entering'];
                $hasil['A' . ($j + 1)]['nama'] = $value['nama'];
                $ranking_hasil[] = array(
                    "nidn" => $value['nidn'],
                    "nama" => $value['nama'],
                    "nilai" =>  $hasil['A' . ($j + 1)]['leaving'] - $hasil['A' . ($j + 1)]['entering']
                );
                $ranking_input[] = array(
                    "nidn" => $value['nidn'],
                    "nilai" => $hasil['A' . ($j + 1)]['leaving'] - $hasil['A' . ($j + 1)]['entering'],
                    "periode" => $this->input->post('periode_id')
                );
                $j++;
            }
            // $rank = array();
            $nilai = array_column($ranking_hasil,'nilai');
            array_multisort($nilai,SORT_DESC,$ranking_hasil);
            // die(json_encode($rank));
            // array_multisort()
            // die(json_encode($ranking_hasil));
            // ksort($ranking_hasil);
            $this->DataModel->insert_multiple("hasil_seleksi",$ranking_input);
            $data = array(
                "data_kriteria" => $data_kriteria,
                "data_calon" => $data_calon,
                "profile" => $profile,
                "tipe" => $tipe,
                "q" => $q,
                "p" => $p,
                "hasil" => $hasil,
                "jarak_kriteria" => $jarak_kriteria,
                "ranking" => $ranking,
                "ranking_hasil" => $ranking_hasil,
                "h_d" => $h_d,
            );

            $this->load->view('pages/hasil_seleksi', $data);

            // die(json_encode($data));

        } else {
            redirect('admin/login');
        }
    }

    private function _NilaiPreferensi($tp = '', $f_jka, $f_q, $f_p = '', $f_bobot)
    {
        $f_np = 0;

        switch ($tp) {
            case '1':
                if ($f_jka = 0) {
                    $f_np = 0;
                } else {
                    $f_np = 1;
                }

                break;
            case '2':
                if ($f_jka < -$f_q | $f_jka > $f_q) {
                    $f_np = 1;
                } else {
                    $f_np = 0;
                }

                break;
            case '3':
                if ($f_jka < -$f_p | $f_jka > $f_p) {
                    $f_np = 1;
                } else {
                    $f_np = $f_jka / $f_p;
                }
                break;

            case '4':
                if ($f_jka > $f_q) {
                    $f_np = 1;
                } else if ($f_jka <= $f_q) {
                    $f_np = 0;
                } else {
                    $per = $f_p - $f_q;
                    $f_np = $f_jka / $per;
                }
                break;
            case '5':
                if ($f_jka > $f_p) {
                    $f_np = 1;
                } else if ($f_jka <= $f_q) {
                    $f_np = 0;
                } else {
                    $f_np = 0.5;
                }

                break;

            case '6':
                if($f_jka <= 0){
                    $f_np = 0;
                }else{
                    // $f_np = 
                }
                break;

            default:
                # code...
                break;
        }

        $hasil = $f_np * $f_bobot;

        return $hasil;
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
