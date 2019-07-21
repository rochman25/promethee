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
            $id_periode = $this->input->get('periode');
            $nama_periode = $this->DataModel->select('nama');
            $nama_periode = $this->DataModel->getWhere('id', $id_periode);
            $nama_periode = $this->DataModel->getData('periode')->row();
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $periode = $this->DataModel->getData('periode')->result_array();
            $kriteria = $this->DataModel->distinct('*');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            $dosen = array();
            if ($this->input->get('periode') != null) {
                $dosen = $this->DataModel->distinct('dosen.nidn,dosen.nama,dosen.prodi,dosen.jenis_kelamin');
                $dosen = $this->DataModel->order_by('dosen.nama', 'ASC');
                if ($profile->level == "admin") {
                    $dosen = $this->DataModel->getWhere('dosen.prodi', $profile->prodi);
                }
                $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen_subkriteria.nidn = dosen.nidn', 'inner');
                $dosen = $this->DataModel->getWhere('dosen_subkriteria.periode', $id_periode);
                $dosen = $this->DataModel->getData('dosen')->result_array();
            }
            foreach ($kriteria as $key => $val) {
                $datas['data'][$val['nama']] = $val;
                // echo $datas['data'][$val['nama']]['id'];
                $sub = $this->DataModel->getWhere('id_kriteria', $datas['data'][$val['nama']]['id']);
                $sub = $this->DataModel->getData('subkriteria')->result_array();
                $input_paramter = $this->DataModel->getWhere('periode', $this->input->post('periode'));
                $input_paramter = $this->DataModel->getWhere('id_kriteria', $datas['data'][$val['nama']]['id']);
                $input_parameter = $this->DataModel->getData('input_parameter')->result_array();
                foreach ($sub as $key => $value) {
                    $datas['data'][$val['nama']]['subkriteria'][] = $value;
                }
                foreach ($input_parameter as $key => $value2) {
                    $datas['data'][$val['nama']]['input_parameter'][] = $value2;
                }
                $bobot[] = $datas['data'][$val['nama']]['bobot'];
                // echo $key['nama'];
                // $sub = $this->DataModel->getWhere('id_kriteria',)
            }
            $datas['ekstra']['total_bobot'] = array_sum($bobot);
            // die(json_encode($datas));
            $data = array(
                "nama_periode" => $nama_periode,
                "dosen" => $dosen,
                "data_kriteria" => $datas,
                "kriteria" => $kriteria,
                "profile" => $profile,
                "periode" => $periode,
                "id_periode" => $id_periode
            );
            // die(json_encode($data));
            $this->load->view('pages/seleksi_proses', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function seleksi()
    {
        if ($this->_isLoggedIn()) {
            $id_periode = $this->input->post('periode_id');
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $kriteria = $this->DataModel->distinct('*');
            $kriteria = $this->DataModel->getData('kriteria')->result_array();
            // $dosen = $this->DataModel->select('dosen.nidn,dosen.nama,dosen.prodi,dosen.jenis_kelamin');
            $dosen = $this->DataModel->distinct('*');
            if ($profile->level == 'admin') {
                $dosen = $this->DataModel->getWhere('prodi', $profile->prodi);
            }
            $dosen = $this->DataModel->order_by('dosen.nama', 'ASC');
            $dosen = $this->DataModel->getJoin('dosen_subkriteria', 'dosen.nidn = dosen_subkriteria.nidn', 'inner');
            $dosen = $this->DataModel->getWhere('dosen_subkriteria.periode', $id_periode);
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
            $nidn_dosen = [];
            // var_dump($q);
            foreach ($q as $key => $val) {
                // echo $key;
                $input_parameter[] = array(
                    "id_kriteria" => $id_kriteria[$key],
                    "tipe" => $tipe[$key],
                    "q" => $val,
                    "p" => $p[$key],
                    "periode" => $this->input->post('periode_id')
                );
            }
            $cek = $this->DataModel->getWhere('periode', $this->input->post('periode_id'));
            $cek = $this->DataModel->getData('input_parameter')->result_array();
            if (!empty($cek)) {
                $i = 0;
                foreach ($cek as $key) {
                    // echo $key['id'];
                    $input_parameter[$i]['id'] = $key['id'];
                    // array_push($key,$input_parameter);
                    $i++;
                }
                // die(json_encode($input_parameter));
                // die(json_encode($input_parameter));
                $this->DataModel->update_multiple('input_parameter', $input_parameter, 'id');
            } else {
                // die(json_encode($this->input->post('periode_id')));
                $this->DataModel->insert_multiple('input_parameter', $input_parameter);
            }
            // die(json_encode($input_parameter));
            // die(json_encode($data_calon));
            foreach ($data_kriteria['data'] as $key_kriteria => $value_kriteria) {
                // echo $key_kriteria;
                // $bobot = $value_kriteria['bobot'] / $data_kriteria['ekstra']['total_bobot'];
                // $bobot = $value_kriteria['bobot'];
                $bobot = 0;
                // echo $bobot ."<br>";
                // var_dump($value_kriteria);
                // die(json_encode($bobot));
                $y = 1;

                // Jarak Kriteria
                // die(json_encode($data_calon));
                foreach ($data_calon['data'] as $key_dosen_y => $value_dosen_y) {
                    // echo $key_dosen_y . "<br>";
                    $tmp_bobot_y = $value_dosen_y['kriteria'][$key_kriteria]['nama_subkriteria'] == 'input' ? $value_dosen_y['kriteria'][$key_kriteria]['value'] : $value_dosen_y['kriteria'][$key_kriteria]['bobot_subkriteria'];
                    // die(json_encode($value_dosen_y));
                    // var_dump($value_dosen_y);
                    // echo $tmp_bobot_y . "<br>";
                    foreach ($data_calon['data'] as $key_dosen_x => $value_dosen_x) {
                        $tmp_bobot_x = $value_dosen_x['kriteria'][$key_kriteria]['nama_subkriteria'] == 'input' ? $value_dosen_x['kriteria'][$key_kriteria]['value'] : $value_dosen_x['kriteria'][$key_kriteria]['bobot_subkriteria'];
                        $jka = 0;
                        $jka = $tmp_bobot_x - $tmp_bobot_y;
                        // echo $jka . "<br>";
                        // $jarak_kriteria[$key_kriteria]['A' . $y][] = $jka;
                        // $jarak_kriteria[$key_kriteria]['A' . $y]['a'][] = $tmp_bobot_x;
                        // $jarak_kriteria[$key_kriteria]['A' . $y]['b'][] = $tmp_bobot_y;
                        // $jarak_kriteria[$key_kriteria]['A' . $y]['D'][] = abs($jka);
                        // echo $tipe[$value_kriteria['id']] . "<br>";
                        $nilai_pref = $this->_NilaiPreferensi($tipe[$value_kriteria['id']], $jka, $q[$value_kriteria['id']], $p[$value_kriteria['id']], $bobot);
                        // echo "tipe = " . $tipe[$value_kriteria['id']] . " " . $tmp_bobot_x . "-" . $tmp_bobot_y . " = " . $jka . " q = " . $q[$value_kriteria['id']] . " p = "  . $p[$value_kriteria['id']] . " p = " . $nilai_pref . "<br>";
                        // echo $nilai_pref . "<br>";
                        // $index_pref[$key_dosen_x][$key_dosen_y] = $nilai_pref;
                        // $jarak_kriteria[$key_kriteria][$key_dosen_y]['p'][] = $nilai_pref;
                        $h_d[$key_kriteria][$key_dosen_y][] = $nilai_pref;
                        // if ($key_dosen_x != $key_dosen_y) {
                            // echo "tipe = " . $tipe[$value_kriteria['id']] . " " . $key_kriteria . " : " . $key_dosen_x . "-" . $key_dosen_y . " = " . $tmp_bobot_x . "-" . $tmp_bobot_y . " = " . $jka . " q = " . $q[$value_kriteria['id']] . " p = "  . $p[$value_kriteria['id']] . " p = " . $nilai_pref . "<br>";
                            $jarak_kriteria[$key_kriteria][$key_dosen_x]['a'][] = $tmp_bobot_x;
                            $jarak_kriteria[$key_kriteria][$key_dosen_x]['b'][] = $tmp_bobot_y;
                            $jarak_kriteria[$key_kriteria][$key_dosen_x]['d'][] = $jka;
                            $jarak_kriteria[$key_kriteria][$key_dosen_x]['D'][] = abs($jka);
                            $jarak_kriteria[$key_kriteria][$key_dosen_x]['p'][] = $nilai_pref;
                        // }
                        // }
                        // die(json_encode($value_dosen_x));
                        // echo json_encode($value_dosen_x,true);
                        // die(json_encode($tmp_bobot_x));
                        // echo $key_dosen_x . "<br>";
                        // echo $tmp_bobot_y . "<br>";
                        // echo $tmp_bobot_x . "-" . $tmp_bobot_y . "<br>";

                        // echo $jka . "<br>";
                        // die(json_encode($h_d));
                    }
                    // echo $y;
                    $y++;
                }
                // die(json_encode($tmp_bobot_x));
                // die();
            }
            // die(json_encode($h_d));
            // die();
            // die(json_encode($jarak_kriteria));
            // die(json_encode($data_calon));
            // for ($i = 0; $i < count($data_calon['data']); $i++) {
            foreach ($data_calon['data'] as $key_dosen => $val) {
                for ($j = 0; $j < count($data_calon['data']); $j++) {
                    // if($i != $j){
                    $tmp_sum = 0;
                    foreach ($data_kriteria['data'] as $key => $value) {
                        // var_dump($h_d);
                        // echo $h_d[$key]['A' . ($i + 1)][$j] . "<br>";
                        $tmp_sum += (1 / count($data_kriteria['data'])) * $h_d[$key][$key_dosen][$j];
                        // var_dump($h_d[$key]);
                        // echo $tmp_sum . "<br>";
                        // echo $h_d[$key]['A' . ($i + 1)][$j] . "<br>";
                    }
                    $ranking[$key_dosen][$j] = $tmp_sum;
                    // }
                }
                // echo array_sum($ranking[$key_dosen]) . "<br>";
                $hasil[$key_dosen]['entering'] = (1 / 4) * array_sum($ranking[$key_dosen]);
            }
            // die(json_encode($ranking));
            // die();
            $j = 0;
            foreach ($data_calon['data'] as $key_d => $val) {
                $tmp_entering = 0;
                foreach ($data_calon['data'] as $key => $value) {
                    $tmp_entering += $ranking[$key][$j];
                    // echo $j;
                    // echo $ranking[$key][$i] . "<br>";
                    // die(json_encode($ranking[$key][$i]));
                    // echo $ranking[$key] . "<br>";
                    // echo $tmp_entering . "<br>";
                    // echo $ranking[$key][$i] . "<br>";
                }

                // echo $tmp_entering . "<br>";
                $hasil[$key_d]['leaving'] = (1 / 4) * $tmp_entering;
                $hasil[$key_d]['net_flow'] = $hasil[$key_d]['leaving'] - $hasil[$key_d]['entering'];
                $hasil[$key_d]['nama'] = $val['nama'];
                $ranking_hasil[] = array(
                    "nidn" => $val['nidn'],
                    "nama" => $val['nama'],
                    "nilai" =>  $hasil[$key_d]['leaving'] - $hasil[$key_d]['entering']
                );
                $ranking_input[] = array(
                    "nidn" => $val['nidn'],
                    "nilai" => $hasil[$key_d]['leaving'] - $hasil[$key_d]['entering'],
                    "periode" => $this->input->post('periode_id'),
                    'prodi' => $profile->prodi
                );
                $j++;
            }
            // die();
            // die(json_encode($hasil));
            // $rank = array();
            $nilai = array_column($ranking_hasil, 'nilai');
            array_multisort($nilai, SORT_DESC, $ranking_hasil);
            // die(json_encode($rank));
            // array_multisort()

            // ksort($ranking_hasil);
            $cek = $this->DataModel->getWhere('prodi', $profile->prodi);
            $cek = $this->DataModel->getWhere('periode', $this->input->post('periode_id'));
            $cek = $this->DataModel->getData('hasil_seleksi')->result_array();
            // die(json_encode($cek));
            if (!empty($cek)) {
                $i = 0;
                foreach ($cek as $key) {
                    $ranking_input[$i]['id'] = $key['id'];
                    $i++;
                }
                // die(json_encode($ranking_input));
                foreach ($ranking_input as $key) {
                    if (isset($key['id'])) {
                        $dat_in = array(
                            "nilai" => $key['nilai'],
                            "nidn" => $key['nidn'],
                            "prodi" => $key['prodi'],
                            "periode" => $key['periode']
                        );
                        $this->DataModel->getWhere('id', $key['id']);
                        $this->DataModel->update('hasil_seleksi', $dat_in);
                    }
                    // $ceek = $this->DataModel->getWhere('id',$key['id']);
                    // $ceek = $this->DataModel->getData('hasil_seleksi')->row();
                    // if($ceek != null){

                    // }
                    else {
                        $dat_in = array(
                            "nilai" => $key['nilai'],
                            "nidn" => $key['nidn'],
                            "prodi" => $key['prodi'],
                            "periode" => $key['periode']
                        );
                        $this->DataModel->insert('hasil_seleksi', $dat_in);
                    }
                    unset($dat_in);
                    // echo $key['id'] . "<br>";
                }
                // die();
                // $this->DataModel->update_multiple('hasil_seleksi', $ranking_input, 'id');
            } else {
                $this->DataModel->insert_multiple("hasil_seleksi", $ranking_input);
            }



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
            // die(json_encode($data));
            $this->load->view('pages/hasil_seleksi', $data);



        } else {
            redirect('admin/login');
        }
    }

    private function _NilaiPreferensi($tp, $f_jka, $f_q, $f_p, $f_bobot)
    {
        $f_np = 0;

        switch ($tp) {
            case 1:
                if ($f_jka == 0) {
                    $f_np = 0;
                } else {
                    $f_np = 1;
                }
                break;
            case 2:
                if ($f_jka <= $f_q) {
                    $f_np = 0;
                } else {
                    $f_np = 1;
                }
                // die(json_encode($f_np));
                break;
            case 3:
                if ($f_jka < -$f_p | $f_jka > $f_p) {
                    $f_np = 1;
                } else {
                    $f_np = $f_jka / $f_p;
                }
                break;
            case 4:
                if (abs($f_jka) > $f_p) {
                    $f_np = 1;
                } else if (abs($f_jka) <= $f_q) {
                    $f_np = 0;
                } else {
                    $f_np = 0.5;
                }
                break;

            case 5:
                if ($f_jka > $f_q) {
                    $f_np = 1;
                } else if ($f_jka <= $f_q) {
                    $f_np = 0;
                } else {
                    $per = $f_p - $f_q;
                    $f_np = $f_jka / $per;
                }
                break;

            case 6:
                if ($f_jka <= 0) {
                    $f_np = 0;
                } else {
                    // $f_np = 
                }
                break;

            default:
                # code...
                break;
        }

        //$hasil = $f_np*$f_bobot;

        return $f_np;
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
