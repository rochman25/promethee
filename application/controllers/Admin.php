<?php

class Admin extends CI_Controller
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
            $data = array("profile" => $profile);
            $this->load->view('pages/dashboard', $data);
        } else {
            redirect('admin/login');
        }
    }

    public function pengaturan()
    {
        if ($this->_isLoggedIn()) {
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $data = array("profile" => $profile);
            if ($this->input->post('kirim')) {
                $nama = $this->input->post('nama');
                $uname = $this->input->post('username');
                $oPass = $this->input->post('password_lama');
                $nPass = $this->input->post('password_baru');

                $this->form_validation->set_rules('nama', 'Nama', 'required');
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
                $this->form_validation->set_rules('password_baru', 'Password Baru', 'required');

                if ($this->form_validation->run() == false) {
                    $this->load->view('pages/profile', $data);
                } else {
                    $dataP = $this->DataModel->getWhere('id', $this->session->userdata('admin_data')['id']);
                    $dataP = $this->DataModel->getData('pengguna')->row();
                    if (md5($oPass) != $dataP->password) {
                        $this->session->set_flashdata('pesan', 'Password lama tidak sama');
                        $this->session->set_flashdata('warna', 'danger');
                        redirect('admin/pengaturan');
                    } else {
                        $dataP = array(
                            "nama" => $nama,
                            "username" => $uname,
                            "password" => md5($nPass),
                        );
                        $this->DataModel->getWhere('id', $this->session->userdata('admin_data')['id']);
                        $this->DataModel->update('pengguna', $dataP);
                        $this->session->set_flashdata('pesan', 'Data telah diperbarui');
                        $this->session->set_flashdata('warna', 'success');
                        redirect('admin/pengaturan');
                    }

                }
            } else {
                $this->load->view('pages/profile', $data);
            }
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

    public function login()
    {
        if ($this->input->post('kirim')) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == false) {
                $this->load->view('pages/login');
            } else {
                $data = array(
                    "username" => $username,
                    "password" => md5($password),
                );
                // die(json_encode($data));
                $log = $this->DataModel->Login('pengguna', $data)->row();

                if ($log != null) {
                    $account = array('id' => $log->id, 'username' => $log->username, 'status' => "true");
                    $this->session->set_userdata('admin_data', $account);
                    redirect('admin/index');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                        <p>Username atau password tidak dikenali</p></div>');
                    $this->load->view('pages/login');
                }
            }
        } else {
            $this->load->view('pages/login');
        }
    }

    public function logout()
    {
        $sess_array = array(
            'username' => '',
        );
        $this->session->unset_userdata('admin_data', $sess_array);
        $this->session->sess_destroy();
        redirect('admin/login', 'refresh');
    }

}
