<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penggajian_model extends CI_Model
{
    function get_all_query()
    {
        $sql = "SELECT b.nip, b.nama_pengajar, c.nama_khd
              FROM presensi as a, pengajar as b, kehadiran as c
              WHERE a.nomor_induk = b.nip
              AND c.id_khd = a.id_khd
              AND a.id_khd = 1
              AND a.id_status = 2";
        return $this->db->query($sql)->result();
    }

    function get_all_q()
    {
        $this->datatables->select('a.id_absen, a.tgl, a.jam_msk, a.jam_klr, b.nip, b.nama_pengajar, c.id_khd, c.nama_khd, a.ket, d.nama_status, d.id_status');
        $this->datatables->from('presensi a');
        $this->datatables->join('pengajar b', 'a.nomor_induk = b.nip', 'left');
        $this->datatables->join('kehadiran c', 'a.id_khd = c.id_khd', 'left');
        $this->datatables->join('stts d', 'a.id_status = d.id_status', 'left');
        return $this->datatables->generate();
    }
}
