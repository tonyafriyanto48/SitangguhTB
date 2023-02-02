<?php
defined('BASEPATH') or exit('No direct script access allowed');

class klinik extends CI_Controller
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
        $data['title'] = "klinik";
        $data['klinik'] = $this->puskesmas->get('klinik');
        $this->template->load('templates/dashboard', 'klinik/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_klinik', 'Nama klinik', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "klinik";
            $this->template->load('templates/dashboard', 'klinik/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->puskesmas->insert('klinik', $input);
            if ($save) {
                set_pesan('Data Saved');
                redirect('klinik');
            } else {
                set_pesan('Something went wrong', false);
                redirect('klinik/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "klinik";
            $data['klinik'] = $this->puskesmas->get('klinik', ['id_klinik' => $id]);
            $this->template->load('templates/dashboard', 'klinik/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->puskesmas->update('klinik', 'id_klinik', $id, $input);

            if ($update) {
                set_pesan('Data Updated');
                redirect('klinik');
            } else {
                set_pesan('Something went wrong');
                redirect('klinik/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->puskesmas->delete('klinik', 'id_klinik', $id)) {
            set_pesan('Data Deleted');
        } else {
            set_pesan('Something went wrong', false);
        }
        redirect('klinik');
    }
}
