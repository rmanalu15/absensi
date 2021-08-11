<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar_model extends CI_Model
{


   /*Read the data from DB */
   public function getEvents()
   {

      $sql = "SELECT * FROM presensi WHERE presensi.ssgl BETWEEN ? AND ? ORDER BY presensi.tgl ASC";
      return $this->db->query($sql, array($_GET['start'], $_GET['end']))->result();
   }

   function santri($id)
   {
      $this->db->select("a.nis,a.nama_santri,b.nama_jabatan,c.nama_shift,d.nama_gedung,e.id_khd,e.ket
                      ,g.nama_status");
      $this->db->from("santri as a,jabatan as b, shift as c, gedung as d,presensi as e,kehadiran as f, stts as g");
      $this->db->where("b.id_jabatan=a.jabatan");
      $this->db->where("c.id_shift=a.id_shift");
      $this->db->where("a.gedung_id=d.gedung_id");
      $this->db->where("a.nis=e.nis");
      $this->db->where("e.id_khd=f.id_khd");
      $this->db->where("e.id_status=g.id_status");
      $this->db->where("d.gedung_id", $id);
      $this->db->where("e.id_khd", 1);
      $this->db->where('order_date >=', $first_date);
      $this->db->where('order_date >=', $first_date);
      return $this->db->get('orders');
      $this->db->distinct();
      return $this->db->get('presensi')->result();
   }
}
