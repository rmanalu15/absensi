<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Santri_model extends CI_Model
{

    public $table = 'santri';
    public $id = 'id';
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


    function get_max()
    {
        return $this->db->select('max(id) as kode')
            ->from('santri')->get()->result();
    }

    function get_card_santri($nis)
    {
        $sql = "SELECT nis, nama_santri, foto
        from santri
        where nis = '$nis'";
        return $this->db->query($sql)->row_array();
    }

    function get_all_query()
    {
        $sql = "SELECT a.id, a.nis, a.nama_santri, a.jenis_kelamin, a.tempat_lahir, a.tanggal_lahir, a.nama_orang_tua, a.alamat, b.nama_kelompok, c.nama_shift
                from santri as a, kelompok as b, shift as c
                where b.id_kelompok = a.kelompok_id 
                and c.id_shift = a.shift_id";
        return $this->db->query($sql)->result();
    }

    function getData()
    {
        $this->datatables->select('a.id, a.nis, a.nama_santri, a.jenis_kelamin, a.tempat_lahir, a.tanggal_lahir, a.nama_orang_tua, a.alamat, b.nama_kelompok, c.nama_shift')
            ->from('santri as a, kelompok as b, shift as c')
            ->where('b.id_kelompok = a.kelompok_id')
            ->where('c.id_shift = a.shift_id');
        return $this->datatables->generate();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
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
}
