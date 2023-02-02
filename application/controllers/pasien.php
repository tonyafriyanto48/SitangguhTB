<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pasien extends CI_Controller
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
        $data['title'] = "Pasien";
        $data['pasien'] = $this->puskesmas->get('pasien');
        $this->template->load('templates/dashboard', 'pasien/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('id_pasien', 'id pasien', 'required');
        $this->form_validation->set_rules('nama_pasien', 'Nama pasien', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jeniskelamin', 'required');
        $this->form_validation->set_rules('nama_jenis_pengobatan', 'Jenis Pengobatan', 'required');
        $this->form_validation->set_rules('nama_asuransi', 'Nama Asuransi', 'required');
        $this->form_validation->set_rules('nama_klinik', 'Nama Klinik', 'required');
        $this->form_validation->set_rules('no_tlpn', 'no telpon', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
    }

    public function add()
    {

        if (!isset($_POST["id_pasien"])) {
            $data['title'] = "pasien";
            $data['pasien'] = $this->puskesmas->get('pasien');
            $data['jenis_pengobatan'] = $this->puskesmas->get('jenis_pengobatan');
            $data['asuransi'] = $this->puskesmas->get('asuransi');
            $data['klinik'] = $this->puskesmas->get('klinik');
            $data['users'] = $this->puskesmas->get('user');

            // Mengenerate ID Barang
            $kode_terakhir = $this->puskesmas->getMax('pasien', 'id_pasien');
            $kode_tambah = substr($kode_terakhir, -4, 4);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
            $data['id_pasien'] = 'TB' . $number;

            $this->template->load('templates/dashboard', 'pasien/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->puskesmas->insert('pasien', $input);

            if ($insert) {
                set_pesan('Data saved successfully!');
                redirect('pasien');
            } else {
                set_pesan('Something went wrong');
                redirect('pasien/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);

        if (!isset($_POST["id_pasien"])) {
            $data['title'] = "Data Pasien";
            $data['users'] = $this->puskesmas->get('user');
            $data['pasien'] = $this->puskesmas->get('pasien');
            $data['jenis_pengobatan'] = $this->puskesmas->get('jenis_pengobatan');
            $data['asuransi'] = $this->puskesmas->get('asuransi');
            $data['klinik'] = $this->puskesmas->get('klinik');
            $data['nama_jenis_pengobatan'] = $this->puskesmas->get('jenis_pengobatan');
            $data['pasien'] = $this->puskesmas->get('pasien', ['id_pasien' => $id]);
            $this->template->load('templates/dashboard', 'pasien/edit', $data);
        } else {
            print_r($_POST);
            echo ("id $id");
            // die();
            $input = $this->input->post(null, true);
            $update = $this->puskesmas->update('pasien', 'id_pasien', $id, $input);
            if ($update) {
                set_pesan('Data saved successfully!');
                redirect('pasien');
            } else {
                set_pesan('Something Went Wrong');
                redirect('pasien/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->puskesmas->delete('pasien', 'id_pasien', $id)) {
            set_pesan('Data Deleted!');
        } else {
            set_pesan('Something Went Wrong', false);
        }
        redirect('pasien');
    }

    public function getalamat($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->puskesmas->cekalamat($id);
        output_json($query);
    }
}
