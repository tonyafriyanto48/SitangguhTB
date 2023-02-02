<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'puskesmas');
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['pasien'] = $this->puskesmas->count('pasien');
        $data['Pasien_masuk'] = $this->puskesmas->count('Pasien_masuk');
        $data['pasien_keluar'] = $this->puskesmas->count('pasien_keluar_dtl');
        $data['klinik'] = $this->puskesmas->count('klinik');
        $data['user'] = $this->puskesmas->count('user');
        $data['jenis_pengobatan'] = $this->puskesmas->count('jenis_pengobatan');
        // $data['alamat'] = $this->puskesmas->sum('pasien', 'alamat');
        $data['asuransi'] = $this->puskesmas->count('asuransi');
        // $data['pasien_min'] = $this->puskesmas->min('pasien', 'alamat', 10);
        // $data['transaksi'] = [
        //     'Pasien_masuk' => $this->puskesmas->getpasienMasuk(5),
        //     'pasien_keluar' => $this->puskesmas->getpasienKeluarDashboard(5)
        // ];

        // Line Chart
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['cbm'] = [];
        $data['cbk'] = [];

        foreach ($bln as $b) {
            $data['cbm'][] = $this->puskesmas->chartpasienMasuk($b);
            $data['cbk'][] = $this->puskesmas->chartpasienKeluar($b);
        }

        $this->template->load('templates/dashboard', 'dashboard', $data);
    }
}
