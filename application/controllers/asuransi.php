<?php
defined('BASEPATH') or exit('No direct script access allowed');

class asuransi extends CI_Controller
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
        $data['title'] = "Asuransi";
        $data['asuransi'] = $this->puskesmas->get('asuransi');
        $this->template->load('templates/dashboard', 'asuransi/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_asuransi', 'Nama asuransi', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Asuransi";
            $this->template->load('templates/dashboard', 'asuransi/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->puskesmas->insert('asuransi', $input);
            if ($insert) {
                set_pesan('Data Saved');
                redirect('asuransi');
            } else {
                set_pesan('Data Failed To Save', false);
                redirect('asuransi/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Asuransi";
            $data['asuransi'] = $this->puskesmas->get('asuransi', ['id_asuransi' => $id]);
            $this->template->load('templates/dashboard', 'asuransi/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->puskesmas->update('asuransi', 'id_asuransi', $id, $input);
            if ($update) {
                set_pesan('Data Saved');
                redirect('asuransi');
            } else {
                set_pesan('Something went wrong', false);
                redirect('asuransi/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->puskesmas->delete('asuransi', 'id_asuransi', $id)) {
            set_pesan('Requested data has been deleted');
        } else {
            set_pesan('Something went wrong', false);
        }
        redirect('asuransi');
    }
}
