<?php

class Scan_model extends Ci_Model
{
    public function cek_id($nomor_induk)
    {
        $query_str_1 = $this->db->where('nis', $nomor_induk)->get('santri');
        $query_str_2 = $this->db->where('nip', $nomor_induk)->get('pengajar');

        if ($query_str_1->num_rows() > 0) {
            return $query_str_1->row();
        }
        if ($query_str_2->num_rows() > 0) {
            return $query_str_2->row();
        } else {
            return false;
        }
    }

    public function absen_masuk($data)
    {
        return $this->db->insert('presensi', $data);
    }

    public function cek_kehadiran($nomor_induk, $tgl)
    {
        $query_str = $this->db->where('nomor_induk', $nomor_induk)->where('tgl', $tgl)->get('presensi');

        if ($query_str->num_rows() > 0) {
            return $query_str->row();
        } else {
            return false;
        }
    }

    public function absen_pulang($nomor_induk, $data)
    {
        $tgl = date('Y-m-d');
        return $this->db->where('nomor_induk', $nomor_induk)
            ->where('tgl', $tgl)
            ->update('presensi', $data);
    }
}
