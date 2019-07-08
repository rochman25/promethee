<?php

class Staff extends CI_Controller
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
            $id = $this->session->userdata['admin_data']['id'];
            $profile = $this->DataModel->getWhere('id', $this->session->userdata['admin_data']['id']);
            $profile = $this->DataModel->getData('pengguna')->row();
            $staff = $this->DataModel->getWhere('id !=',$id);
            $staff = $this->DataModel->getData('pengguna')->result_array();
            $data = array(
                "profile" => $profile,
                "datas" => $staff
            );
            $this->load->view('pages/staff_prodi/data',$data);

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
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $prodi = $this->input->post('prodi');
                $pass = $this->input->post('password');
                $this->form_validation->set_rules('nama','Nama','required');
                $this->form_validation->set_rules('username','Username','required');
                $this->form_validation->set_rules('email','Email','required');
                $this->form_validation->set_rules('password','Password','required');
                if($this->form_validation->run() == FALSE){
                    $this->load->view('pages/staff_prodi/form_staff',$data);
                }else{
                    $data = array(
                        "nama" => $nama,
                        "username" => $username,
                        "email" => $email,
                        "prodi" => $prodi,
                        "password" => md5($pass),
                        "level" => "admin"
                    );
                    $this->DataModel->insert('pengguna',$data);
                    redirect('staff');
                }

            }else{
                $this->load->view('pages/staff_prodi/form_staff',$data);
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
            $staff = $this->DataModel->getWhere('id',$id);
            $staff = $this->DataModel->getData('pengguna')->row();
            $data = array(
                "profile" => $profile,
                "data_staff" => $staff
            );
            if($this->input->post('kirim')){
                $nama = $this->input->post('nama');
                $username = $this->input->post('username');
                $email = $this->input->post('email');
                $prodi = $this->input->post('prodi');
                $pass = $this->input->post('password');
                $this->form_validation->set_rules('nama','Nama','required');
                $this->form_validation->set_rules('username','Username','required');
                $this->form_validation->set_rules('email','Email','required');
                $this->form_validation->set_rules('password','Password','required');
                if($this->form_validation->run() == FALSE){
                    $this->load->view('pages/staff/form_staff',$data);
                }else{
                    $data = array(
                        "nama" => $nama,
                        "username" => $username,
                        "email" => $email,
                        "prodi" => $prodi,
                        "password" => md5($pass)
                    );
                    $this->DataModel->getWhere('id',$id);
                    $this->DataModel->update('pengguna',$data);
                    redirect('staff');
                }
            }else{
                $this->load->view('pages/staff_prodi/form_staff',$data);
            }
        }else{
            redirect('admin/login');
        }
    }

    public function hapus()
    {
        if($this->_isLoggedIn()){
            $id = $this->input->get('id');
            $this->DataModel->delete('id',$id,'pengguna');
            redirect('staff');
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
