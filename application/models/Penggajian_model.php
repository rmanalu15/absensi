<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penggajian_model extends CI_Model
{
    function get_all_query()
    {
        $sql = "SELECT b.nip, b.nama_pengajar
              FROM presensi_pengajar as a, pengajar as b
              WHERE a.nip = b.nip
              AND a.id_khd = 1
              AND a.id_status = 2";
        return $this->db->query($sql)->result();
    }
}
