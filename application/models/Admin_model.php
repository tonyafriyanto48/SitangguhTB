<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->replace($table, $data);
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function update_alamat($id_pasien, $data)
    {
        $this->db->where('id_pasien', $id_pasien);
        $this->db->update('pasien', $data);
    }

    public function getUsers($id)
    {
        /**
         * ID disini adalah untuk data yang tidak ingin ditampilkan. 
         * Maksud saya disini adalah 
         * tidak ingin menampilkan data user yang digunakan, 
         * pada managemen data user
         */
        $this->db->where('id_user !=', $id);
        return $this->db->get('user')->result_array();
    }

    public function getpasien()
    {
        $this->db->join('jenis_pengobatan j', 'b.id_jenis_pengobatan = j.id_jenis_pengobatan');
        $this->db->join('asuransi s', 'b.id_asuransi = s.id_asuransi');
        $this->db->join('klinik sp', 'b.id_klinik = sp.id_klinik');
        $this->db->order_by('id_pasien');
        return $this->db->get('pasien b')->result_array();
    }

    public function getPasienMasuk($limit = null, $id_pasien = null, $range = null)
    {
        $this->db->select('*');
        $this->db->from('Pasien_masuk bm');
        $this->db->join('user u', 'bm.user_id = u.id_user');
        $this->db->join('klinik sp', 'bm.klinik_id = sp.id_klinik');
        // $this->db->join('pasien b', 'bm.pasien_id = b.id_pasien');
        $this->db->join('asuransi s', 'bm.asuransi_id = s.id_asuransi');
        if ($limit != null) {
            $this->db->limit($limit);
        }

        if ($id_pasien != null) {
            $this->db->where('id_pasien', $id_pasien);
        }

        if ($range != null) {
            $this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
            $this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
        }

        $this->db->order_by('id_pasien_masuk', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getpasienKeluarDashboard($limit = null, $range = null)
    {
        $this->db->select('*');
        $this->db->from('pasien_keluar_dtl bkd');
        $this->db->join('pasien_keluar bk', 'bk.id_pasien_keluar = bkd.id_pasien_keluar');
        $this->db->join('user u', 'bk.id_user = u.id_user');
        $this->db->join('pasien b', 'bkd.pasien_id = b.id_pasien');
        $this->db->join('asuransi s', 'b.id_asuransi = s.id_asuransi');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        // if ($id_pasien != null) {
        //     $this->db->where('id_pasien', $id_pasien);
        // }
        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        $this->db->order_by('bkd.id_detail', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getpasienKeluar($limit = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('pasien_keluar bk', 'bk.id_pasien_keluar = bkd.id_pasien_keluar');
        // $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('pasien b', 'bkd.pasien_id = b.id_pasien');
        $this->db->join('asuransi s', 'b.asuransi_id = s.id_asuransi');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        // if ($id_pasien != null) {
        //     $this->db->where('id_pasien', $id_pasien);
        // }
        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        // $this->db->group_by('bk.id_pasien_keluar', 'DESC');
        $this->db->order_by('bk.id_pasien_keluar', 'DESC');
        return $this->db->get('pasien_keluar_dtl bkd')->result_array();
    }

    public function getIDpasienKeluar($id_pasien_keluar)
    {
        $this->db->select('*');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('pasien b', 'bk.pasien_id = b.id_pasien');
        $this->db->join('jenis_pengobatan j', 'b.jenis_pengobatan_id = j.id_jenis_pengobatan');
        $this->db->join('asuransi s', 'b.asuransi_id = s.id_asuransi');
        $this->db->where('bk.id_pasien_keluar', $id_pasien_keluar);
        $this->db->order_by('id_pasien_keluar', 'DESC');
        return $this->db->get('pasien_keluar bk');
    }

    public function getIDpasienKeluar2($id_pasien_keluar)
    {
        $this->db->select('*');
        $this->db->join('pasien_keluar bk', 'bk.id_pasien_keluar = bkd.id_pasien_keluar');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('pasien b', 'bkd.pasien_id = b.id_pasien');
        $this->db->join('jenis_pengobatan j', 'b.jenis_pengobatan_id = j.id_jenis_pengobatan');
        $this->db->join('asuransi s', 'b.asuransi_id = s.id_asuransi');
        $this->db->where('bk.id_pasien_keluar', $id_pasien_keluar);
        // $this->db->order_by('id_pasien_keluar bk', 'DESC');
        return $this->db->get('pasien_keluar_dtl bkd');
    }

    public function findIDpasienKeluar($id)
    {
        $query = $this->db->where('id_pasien_keluar', $id)
            // ->limit(100)
            ->get('pasien_keluar');
        if ($query->num_rows() > 0) {
            return $query->row_array();
            //return $query;
        } else {
            return array();
            //return $query;
        }
    }

    public function simpan_cart($id_pasien_keluar)
    {
        foreach ($this->cart->contents() as $item) {
            $data = array(
                'id_pasien_keluar'  =>  $id_pasien_keluar,
                'pasien_id'       =>  $item['id'],
                'harga'           =>  $item['amount'],
                'jumlah_keluar'   =>  $item['qty'],
                'total_nominal_dtl'   =>  $item['subtotal']
            );
            $this->db->insert('pasien_keluar_dtl', $data);
            // $this->db->query("update tbl_pasien set pasien_alamat=pasien_alamat-'$item[qty]' where pasien_id='$item[id]'");
        }
        return true;
    }

    public function get_pasien($id_pasien)
    {
        $query = $this->db->query("SELECT * FROM pasien where id_pasien='$id_pasien'");
        return $query;
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function sum($table, $field)
    {
        $this->db->select_sum($field);
        return $this->db->get($table)->row_array()[$field];
    }

    public function min($table, $field, $min)
    {
        $field = $field . ' <=';
        $this->db->where($field, $min);
        return $this->db->get($table)->result_array();
    }

    public function chartpasienMasuk($bulan)
    {
        $like = 'I' . date('y') . $bulan;
        $this->db->like('id_pasien_masuk', $like, 'after');
        return count($this->db->get('Pasien_masuk')->result_array());
    }

    public function chartpasienKeluar($bulan)
    {
        $like = 'S' . date('y') . $bulan;
        $this->db->like('id_pasien_keluar', $like, 'after');
        return count($this->db->get('pasien_keluar_dtl')->result_array());
    }

    public function laporan($table, $mulai, $akhir)
    {
        $tgl = $table == 'Pasien_masuk' ? 'tanggal_masuk' : 'tanggal_keluar';
        $this->db->where($tgl . ' >=', $mulai);
        $this->db->where($tgl . ' <=', $akhir);
        return $this->db->get($table)->result_array();
    }

    public function cekalamat($id)
    {
        $this->db->join('asuransi s', 'b.asuransi_id=s.id_asuransi');
        return $this->db->get_where('pasien b', ['id_pasien' => $id])->row_array();
    }
}
