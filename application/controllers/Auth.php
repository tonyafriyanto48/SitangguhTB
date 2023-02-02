<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Admin_model', 'puskesmas');
    }

    private function _has_login()
    {
        if ($this->session->has_userdata('login_session')) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->_has_login();

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Panel';
            $this->template->load('templates/auth', 'auth/login', $data);
        } else {
            $input = $this->input->post(null, true);

            $cek_username = $this->auth->cek_username($input['username']);
            if ($cek_username > 0) {
                $password = $this->auth->get_password($input['username']);
                if (password_verify($input['password'], $password)) {
                    $user_db = $this->auth->userdata($input['username']);
                    if ($user_db['is_active'] != 1) {
                        set_pesan('Akun anda Belum di Aktivasi, silahkan Hubungi Admin Puskesmas', false);
                        redirect('login');
                    } else {
                        $userdata = [
                            'user'  => $user_db['id_user'],
                            'role'  => $user_db['role'],
                            'timestamp' => time()
                        ];
                        $this->session->set_userdata('login_session', $userdata);
                        redirect('dashboard');
                    }
                } else {
                    set_pesan('Password Anda Salah', false);
                    redirect('auth');
                }
            } else {
                set_pesan('Usename Tidak Ter-Registrasi', false);
                redirect('auth');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('login_session');

        set_pesan('Logged Out Successfully!');
        redirect('auth');
    }

    public function register()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|trim');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'matches[password]|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Create Account';
            $this->template->load('templates/auth', 'auth/register', $data);
        } else {
            $user['nama'] = $this->input->post('nama');
            $user['username'] = $this->input->post('username');
            $user['email'] = $this->input->post('email');
            $user['no_telp'] = $this->input->post('no_telp');
            $user['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $user['role'] = 'klinik';
            $user['foto'] = 'user.png';
            $user['is_active']  = 0;
            $user['created_at'] = time();
            $query = $this->puskesmas->insert('user', $user);
            if ($query) {
                set_pesan('Silahkan Hubungi Admin Puskesmas  Untuk Aktivasi');
                redirect('login');
            } else {
                set_pesan('Kami Menemukan Kesalahan', false);
                redirect('register');
            }
        }
    }
}
