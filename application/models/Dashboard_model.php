<?php

class Dashboard_model extends Ci_Model
{

  public function total($table)


  {
    $query = $this->db->get($table)->num_rows();
    return $query;
  }

  function get_maxd($pl)
  {
    $this->db->select('a.nis,a.nama_santri,b.nama_jabatan,d.nama_shift');
    $this->db->from('santri as a,jabatan as b,shift as d');
    $this->db->where('b.id_jabatan=a.jabatan');
    $this->db->where('d.id_shift = a.id_shift');
    // $this->db->where_in('c.gedung_id', $pl);
    return $this->db->get();
  }

  // jangan pake fungsi ini, testing query
  function get_maxe($in)
  {
    $sql =  " SELECT COUNT(nis) as total_santri
                FROM santri
                WHERE gedung_id IN ('1','2','3','4','5','6','7')
                GROUP BY gedung_id
                ORDER BY total_santri desc, nis
                ";

    $sql2 = " SELECT a.nama_gedung, COUNT(b.nis) as total_santri
                FROM santri as b, gedung as a
                WHERE b.gedung_id IN ('1','2','3','4','5','6','7')
                AND a.gedung_id=b.gedung_id
                GROUP BY b.gedung_id
                ORDER BY total_santri desc, b.nis";
    return $this->db->query($sql, $in);
    $sql3 = " CREATE view total_jabatan as
              (SELECT a.nama_jabatan, COUNT(b.nis) as total_santri
                FROM santri as b, jabatan as a
                WHERE b.jabatan IN ('1','2','3','4')
                AND a.id_jabatan=b.jabatan
                GROUP BY b.jabatan
                ORDER BY total_santri desc, b.nis)";

    $sql4 = "SELECT	a.nama_santri,b.nama_jabatan,d.nama_gedung, count(c.id_khd) as total_kehadiran
                FROM santri as a, jabatan as b,presensi as c,gedung as d
              	where a.jabatan=b.id_jabatan
                and c.nis=a.nis
                and a.gedung_id=d.gedung_id
                GROUP BY a.nis
                ORDER BY total_kehadiran desc, a.nis";
  }

  function get_max($id)
  {
    $gi = $this->group_by_gi($id);
    $select = array('a.nama_gedung,count(b.nis) as total_santri');
    $this->db->select($select);
    $this->db->from('santri as b , gedung as a');
    $this->db->where('b.gedung_id=a.gedung_id');
    $this->db->group_by('b.gedung_id');
    $this->db->order_by('total_santri desc, b.nis');
    return $this->db->get();
  }

  function get_max2($in)
  {
    $select = array('a.nama_jabatan,count(b.nis) as total_santri');
    $this->db->select($select);
    $this->db->from('santri as b , jabatan as a');
    $this->db->where('b.jabatan=a.id_jabatan');
    $this->db->group_by('b.jabatan');
    $this->db->order_by('total_santri desc, b.nis');
    return $this->db->get();
  }

  function group_by_gi($id)
  {
    $this->db->select('gedung_id');
    $this->db->from('gedung');
    $this->db->group_by('gedung_id');
    return $this->db->get()->result_array();
  }
}
