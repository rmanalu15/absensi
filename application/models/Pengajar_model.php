<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengajar_model extends CI_Model
{

    public $table = 'pengajar';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_card_pengajar($nip)
    {
        $sql = "SELECT nip, nama_pengajar, foto
        from pengajar
        where nip = '$nip'";
        return $this->db->query($sql)->row_array();
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
            ->from('pengajar')->get()->result();
    }

    function get_all_query()
    {
        $sql = "SELECT a.id, a.nip, a.nama_pengajar, a.jenis_kelamin, a.tanggal_lahir, a.alamat, b.nama_shift
                from pengajar as a, shift as b
                where b.id_shift = a.shift_id";
        return $this->db->query($sql)->result();
    }

    function getData()
    {
        $this->datatables->select('a.id, a.nip, a.nama_pengajar, a.jenis_kelamin, a.tanggal_lahir, a.alamat, b.nama_shift')
            ->from('pengajar as a, shift as b')
            ->where('b.id_shift = a.shift_id');
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
