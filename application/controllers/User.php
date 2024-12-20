<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
        if (!is_puskesmas()) {
            redirect('dashboard');
        }

        $this->load->model('admin_model', 'puskesmas');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "User Management";
        $data['users'] = $this->puskesmas->getUsers(userdata('id_user'));
        $this->template->load('templates/dashboard', 'user/data', $data);
    }

    private function _validasi($mode)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($mode == 'add') {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|trim');
            $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'matches[password]|trim');
        } else {
            $db = $this->puskesmas->get('user', ['id_user' => $this->input->post('id_user', true)]);
            $username = $this->input->post('username', true);
            $email = $this->input->post('email', true);

            $uniq_username = $db['username'] == $username ? '' : '|is_unique[user.username]';
            $uniq_email = $db['email'] == $email ? '' : '|is_unique[user.email]';

            $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric' . $uniq_username);
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $uniq_email);
        }
    }

    public function add()
    {
        $this->_validasi('add');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Add User";
            $this->template->load('templates/dashboard', 'user/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $input_data = [
                'nama'          => $input['nama'],
                'username'      => $input['username'],
                'email'         => $input['email'],
                'no_telp'       => $input['no_telp'],
                'role'          => $input['role'],
                'password'      => password_hash($input['password'], PASSWORD_DEFAULT),
                'created_at'    => time(),
                'foto'          => 'user.png'
            ];

            if ($this->puskesmas->insert('user', $input_data)) {
                set_pesan('Data Saved');
                redirect('user');
            } else {
                set_pesan('Something Went Wrong', false);
                redirect('user/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->input->method(true) == "GET") {
            $data['title'] = "Edit User";
            $data['user'] = $this->puskesmas->get('user', ['id_user' => $id]);
            $this->template->load('templates/dashboard', 'user/edit', $data);
        } else if ($this->input->method(true) == "POST") {
            $this->_validasi('edit');
            if ($this->form_validation->run()) {
                $input = $this->input->post(null, true);
                $input_data = [
                    'nama'          => $input['nama'],
                    'username'      => $input['username'],
                    'email'         => $input['email'],
                    'no_telp'       => $input['no_telp'],
                    'role'          => $input['role']
                ];

                if ($this->puskesmas->update('user', 'id_user', $id, $input_data)) {
                    set_pesan('Data has  been changed');
                    redirect('user');
                } else {
                    set_pesan('Something went wrong', false);
                    redirect('user/edit/' . $id);
                }
            }
        }

        // if ($this->form_validation->run() == false) {
        //     $data['title'] = "Edit User";
        //     $data['user'] = $this->puskesmas->get('user', ['id_user' => $id]);
        //     $this->template->load('templates/dashboard', 'user/edit', $data);
        // } else {

        // }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->puskesmas->delete('user', 'id_user', $id)) {
            set_pesan('Data Deleted');
        } else {
            set_pesan('Something went wrong', false);
        }
        redirect('user');
    }

    public function toggle($getId)
    {
        $id = encode_php_tags($getId);
        $status = $this->puskesmas->get('user', ['id_user' => $id])['is_active'];
        $toggle = $status ? 0 : 1; //Jika user aktif maka nonaktifkan, begitu pula sebaliknya
        $pesan = $toggle ? 'User Activated' : 'User Deactivated';

        if ($this->puskesmas->update('user', 'id_user', $id, ['is_active' => $toggle])) {
            set_pesan($pesan);
        }
        redirect('user');
    }
}
