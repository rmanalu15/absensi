<?php

class Dashboard_model extends Ci_Model
{

  public function total($table)


  {
    $query = $this->db->get($table)->num_rows();
    return $query;
  }

  function get_maxd()
  {
    $this->db->select('a.nis, a.nama_santri, b.nama_kelompok, c.nama_shift');
    $this->db->from('santri as a, kelompok as b, shift as c');
    $this->db->where('b.id_kelompok = a.kelompok_id');
    $this->db->where('c.id_shift = a.id_shift');
    return $this->db->get();
  }

  // jangan pake fungsi ini, testing query
  function get_maxe($in)
  {
    $sql =  " SELECT COUNT(nis) as total_santri
                FROM santri
                ORDER BY total_santri desc, nis";

    $sql2 = " SELECT COUNT(nis) as total_santri
                FROM santri
                ORDER BY total_santri desc, nis";
    return $this->db->query($sql, $in);
    $sql3 = " CREATE view total_kelompok as
              (SELECT a.nama_kelompok, COUNT(b.nis) as total_santri
                FROM santri as b, kelompok as a
                WHERE b.kelompok_id IN ('1','2','3','4')
                AND a.id_kelompok = b.kelompok_id
                GROUP BY b.kelompok_id
                ORDER BY total_santri desc, b.nis)";

    $sql4 = "SELECT	a.nama_santri,b.nama_kelompok,count(c.id_khd) as total_kehadiran
                FROM santri as a, kelompok as b,presensi as c
              	where a.kelompok=b.id_kelompok
                and c.nis=a.nis
                GROUP BY a.nis
                ORDER BY total_kehadiran desc, a.nis";
  }

  function get_max()
  {
    $select = array('count(b.nis) as total_santri');
    $this->db->select($select);
    $this->db->from('santri as b');
    $this->db->order_by('total_santri desc, b.nis');
    return $this->db->get();
  }

  function get_max2($in)
  {
    $select = array('a.nama_kelompok,count(b.nis) as total_santri');
    $this->db->select($select);
    $this->db->from('santri as b , kelompok as a');
    $this->db->where('b.kelompok_id = a.id_kelompok');
    $this->db->group_by('b.kelompok_id');
    $this->db->order_by('total_santri desc, b.nis');
    return $this->db->get();
  }
}
