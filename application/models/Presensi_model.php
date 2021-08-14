<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_model extends CI_Model
{

    public $table = 'presensi';
    public $id = 'id_absen';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_all_query_1()
    {
        $this->db->select('a.id_absen, a.tgl, a.jam_msk, a.jam_klr, a.nomor_induk, b.nama_santri as nama_user, c.nama_khd, a.ket, d.nama_status, d.id_status');
        $this->db->from('presensi a');
        $this->db->join('santri b', 'a.nomor_induk = b.nis', 'left');
        $this->db->join('kehadiran c', 'a.id_khd = c.id_khd', 'left');
        $this->db->join('stts d', 'a.id_status = d.id_status', 'left');
        $this->db->like('a.nomor_induk', "S");
        $query = $this->db->get()->result();
        return $query;
    }

    function get_all_query_2()
    {
        $this->db->select('a.id_absen, a.tgl, a.jam_msk, a.jam_klr, a.nomor_induk, b.nama_pengajar as nama_user, c.nama_khd, a.ket, d.nama_status, d.id_status');
        $this->db->from('presensi a');
        $this->db->join('pengajar b', 'a.nomor_induk = b.nip', 'left');
        $this->db->join('kehadiran c', 'a.id_khd = c.id_khd', 'left');
        $this->db->join('stts d', 'a.id_status = d.id_status', 'left');
        $this->db->like('a.nomor_induk', "P");
        $query = $this->db->get()->result();
        return $query;
    }

    function get_all_q_1()
    {
        $this->datatables->select('a.id_absen, a.tgl, a.jam_msk, a.jam_klr, a.nomor_induk, b.nama_santri as nama_user, c.id_khd, c.nama_khd, a.ket, d.nama_status, d.id_status');
        $this->datatables->from('presensi a');
        $this->datatables->join('santri b', 'a.nomor_induk = b.nis', 'left');
        $this->datatables->join('kehadiran c', 'a.id_khd = c.id_khd', 'left');
        $this->datatables->join('stts d', 'a.id_status = d.id_status', 'left');
        $this->datatables->like('a.nomor_induk', "S");
        return $this->datatables->generate();
    }

    function get_all_q_2()
    {
        $this->datatables->select('a.id_absen, a.tgl, a.jam_msk, a.jam_klr, a.nomor_induk, b.nama_pengajar as nama_user, c.id_khd, c.nama_khd, a.ket, d.nama_status, d.id_status');
        $this->datatables->from('presensi a');
        $this->datatables->join('pengajar b', 'a.nomor_induk = b.nip', 'left');
        $this->datatables->join('kehadiran c', 'a.id_khd = c.id_khd', 'left');
        $this->datatables->join('stts d', 'a.id_status = d.id_status', 'left');
        $this->datatables->like('a.nomor_induk', "P");
        return $this->datatables->generate();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function search_value($title)
    {
        $query_result =
            $this->db->like('nama_santri', $title, 'both')
            ->order_by('nama_santri', 'ASC')
            ->limit(10)->get('santri');
        if ($query_result->num_rows() > 0) {
            return $query_result->result();
        } else {
            return false;
        }
    }

    function get_by_ids($id)
    {
        return $this->db->where($this->id, $id)
            ->join('santri', 'santri.nis =' . $this->table . '.nis', 'left')
            ->get('presensi')
            ->row();
    }

    function cek_id($nis, $tgl)
    {
        $query_str = "SELECT * FROM presensi WHERE nis= ? AND tgl= ? ";
        $result = $this->db->query($query_str, array($nis, $tgl));
        if ($result->num_rows() == 1) {
            return $result;
        } else {
            return false;
        }
    }
}
