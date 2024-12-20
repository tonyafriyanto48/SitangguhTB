<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('admin_model', 'puskesmas');
        $this->load->library('form_validation');

        $userId = $this->session->userdata('login_session')['user'];
        $this->user = $this->puskesmas->get('user', ['id_user' => $userId]);
    }

    public function index()
    {
        $data['title'] = "Profile";
        $data['user'] = $this->user;
        $this->template->load('templates/dashboard', 'profile/user', $data);
    }

    private function _validasi()
    {
        $db = $this->puskesmas->get('user', ['id_user' => $this->input->post('id_user', true)]);
        $username = $this->input->post('username', true);
        $email = $this->input->post('email', true);

        $uniq_username = $db['username'] == $username ? '' : '|is_unique[user.username]';
        $uniq_email = $db['email'] == $email ? '' : '|is_unique[user.email]';

        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric' . $uniq_username);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $uniq_email);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
    }

    private function _config()
    {
        $config['upload_path']      = "./assets/img/avatar";
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = '2048';

        $this->load->library('upload', $config);
    }

    public function setting()
    {
        $this->_config();
        if ($this->input->method(true) == "GET") {
            $data['title'] = "Profile";
            $data['user'] = $this->user;
            $this->template->load('templates/dashboard', 'profile/setting', $data);
        } else if ($this->input->method(true) == "POST") {
            $this->_validasi();
            if ($this->form_validation->run()) {
                $input = $this->input->post();
                if (empty($_FILES['foto']['name'])) {
                    $insert = $this->puskesmas->update('user', 'id_user', $input['id_user'], $input);
                    if ($insert) {
                        set_pesan('Changes Saved');
                    } else {
                        set_pesan('Changes NOT SAVED.');
                    }
                    redirect('profile/setting');
                } else {
                    if ($this->upload->do_upload('foto') == false) {
                        echo $this->upload->display_errors();
                        die;
                    } else {
                        if (userdata('foto') != 'user.png') {
                            $old_image = FCPATH . 'assets/img/avatar/' . userdata('foto');
                            if (!unlink($old_image)) {
                                set_pesan('gagal hapus foto lama.');
                                redirect('profile/setting');
                            }
                        }

                        $input['foto'] = $this->upload->data('file_name');
                        $update = $this->puskesmas->update('user', 'id_user', $input['id_user'], $input);
                        if ($update) {
                            set_pesan('Changes has been made');
                        } else {
                            set_pesan('Failed to save your changes');
                        }
                        redirect('profile/setting');
                    }
                }
            }
        }
    }

    public function ubahpassword()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[3]|differs[password_lama]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Change Password";
            $this->template->load('templates/dashboard', 'profile/ubahpassword', $data);
        } else {
            $input = $this->input->post(null, true);
            if (password_verify($input['password_lama'], userdata('password'))) {
                $new_pass = ['password' => password_hash($input['password_baru'], PASSWORD_DEFAULT)];
                $query = $this->puskesmas->update('user', 'id_user', userdata('id_user'), $new_pass);

                if ($query) {
                    set_pesan('Your password has been updated!');
                } else {
                    set_pesan('Hahaha, Something went wrong', false);
                }
            } else {
                set_pesan('Looks like something is wrong, Your current password is totally wrong!!', false);
            }
            redirect('profile/ubahpassword');
        }
    }
}
