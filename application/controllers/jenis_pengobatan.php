<?php
defined('BASEPATH') or exit('No direct script access allowed');

class jenis_pengobatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('admin_model', 'puskesmas');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Jenis Pengobatan";
        $data['jenis_pengobatan'] = $this->puskesmas->get('jenis_pengobatan');
        $this->template->load('templates/dashboard', 'jenis_pengobatan/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_jenis_pengobatan', 'Nama jenis pengobatan', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Jenis Pengobatan";
            $this->template->load('templates/dashboard', 'jenis_pengobatan/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->puskesmas->insert('jenis_pengobatan', $input);
            if ($insert) {
                set_pesan('Data has been saved!');
                redirect('jenis_pengobatan');
            } else {
                set_pesan('Something went wrong', false);
                redirect('jenis_pengobatan/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Jenis Pengobatan";
            $data['jenis_pengobatan'] = $this->puskesmas->get('jenis_pengobatan', ['id_jenis_pengobatan' => $id]);
            $this->template->load('templates/dashboard', 'jenis_pengobatan/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->puskesmas->update('jenis_pengobatan', 'id_jenis_pengobatan', $id, $input);
            if ($update) {
                set_pesan('Data Saved');
                redirect('jenis_pengobatan');
            } else {
                set_pesan('Something went wrong', false);
                redirect('jenis_pengobatan/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->puskesmas->delete('jenis_pengobatan', 'id_jenis_pengobatan', $id)) {
            set_pesan('Data Deleted');
        } else {
            set_pesan('Something went wrong', false);
        }
        redirect('jenis_pengobatan');
    }
}
