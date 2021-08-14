<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekap_model extends CI_Model
{
    public $nis = 'nis';
    public $order = 'DESC';
    public $id_khd = 'id_khd';
    public $tgl = 'tgl';
    public $dayList = 'D';


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

    function jmlHadir()
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select('a.nis, b.tgl, b.id_khd');
        $this->db->from('santri as a,presensi as b');
        $this->db->where('a.nis = b.nis');
        $this->db->group_by('b.tgl');
        $this->db->where("b.tgl >=", $start);
        $this->db->where("b.tgl <=", $end);
        $this->db->distinct();
        return $this->db->get('presensi')->num_rows();
    }

    function resultHadir()
    {
        $this->db->select("a.nis, b.tgl, b.id_khd");
        $this->db->from("santri as a, presensi as b");
        $this->db->where("a.nis = b.nis");
        $this->db->group_by("b.tgl");
        $this->db->distinct();
        return $this->db->get()->result();
    }

    function resultHadir2($start, $end)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select("a.nis, b.tgl, b.id_khd");
        $this->db->from("santri as a, presensi as b ");
        $this->db->where("a.nis = b.nis");
        $this->db->where("b.tgl >=", $start);
        $this->db->where("b.tgl <=", $end);
        $this->db->group_by("b.tgl");
        $this->db->distinct();
        return $this->db->get()->result();
    }

    // fungsi ketika absensi hadir
    function  _cek($tanggal, $nis)
    {
        $this->db->distinct();
        $this->db->where("tgl", $tanggal);
        $this->db->where("nis", $nis);
        $this->db->where('id_khd', 1);
        $this->db->distinct();
        return $this->db->get("presensi")->num_rows();
    }

    // fungsi ketika absensi sakit
    function  _cek2($tanggal, $nis)
    {
        $this->db->distinct();
        $this->db->where("tgl", $tanggal);
        $this->db->where("nis", $nis);
        $this->db->where('id_khd', 2);
        $this->db->where('id_status', 3);
        $this->db->distinct();
        return $this->db->get("presensi")->num_rows();
    }

    // fungsi ketika ijin
    function  _cek3($tanggal, $nis)
    {
        $this->db->distinct();
        $this->db->where("tgl", $tanggal);
        $this->db->where("nis", $nis);
        $this->db->where('id_khd', 3);
        $this->db->where('id_status', 3);
        $this->db->distinct();
        return $this->db->get("presensi")->num_rows();
    }

    // fungsi ketika tanpa keterangan
    function  _cek4($tanggal, $nis)
    {
        $this->db->distinct();
        $this->db->where("tgl", $tanggal);
        $this->db->where("nis", $nis);
        $this->db->where('id_khd', 4);
        $this->db->where('id_status', 3);
        $this->db->distinct();
        return $this->db->get("presensi")->num_rows();
    }

    // fungsi ketika off/libur
    function  _cek5($tanggal, $nis)
    {
        $this->db->distinct();
        $this->db->where("tgl", $tanggal);
        $this->db->where("nis", $nis);
        $this->db->where('id_khd', 5);
        $this->db->where('id_status', 3);
        $this->db->distinct();
        return $this->db->get("presensi")->num_rows();
    }

    function resultCek($resultHadir)
    {
        $cek = count($resultHadir);
        if ($cek > 0) {
            foreach ($resultHadir as $data) {
                $cek = $this->_cek($data->tanggal);
                if (!$cek) {
                    $cek = "<i class='fa fa-close'></i>";
                } else {
                    $cek = "<i class='fa fa-check-square-o'></i>";
                };
                echo "<td>" . $cek . "</td>";
            }
        } else {
            echo "";
        };
    }

    function santri_bak3($start, $end, $id_shift)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $id_shift = $_GET['id_shift'];
        $this->db->select("a.nis, a.nama_santri, a.shift_id, a.kelompok_id, b.nama_kelompok, c.nama_shift, d.id_khd, d.ket
        , f.nama_status");
        $this->db->from("santri as a, kelompok as b, shift as c,presensi as d, kehadiran as e, stts as f");
        $this->db->where("b.id_kelompok = a.kelompok_id");
        $this->db->where("c.id_shift = a.shift_id");
        $this->db->where("a.nis = d.nis");
        $this->db->where("d.id_khd = e.id_khd");
        $this->db->where("d.id_status = f.id_status");
        $this->db->where("d.id_khd", 1);
        $this->db->where("d.id_status", 2);
        $this->db->where("d.tgl >=", $start);
        $this->db->where("d.tgl <=", $end);
        $this->db->where("a.shift_id", $id_shift);
        $this->db->order_by("a.shift_id", "ASC");
        $this->db->order_by("a.kelompok_id", "ASC");

        $this->db->distinct();
        return $this->db->get('presensi')->result();
    }

    // fungsi mendata rekap santri berdasarkan lokasi
    function santri()
    {
        $this->db->select("a.nis, a.nama_santri, b.nama_kelompok, c.nama_shift, d.id_khd, d.ket
        , f.nama_status");
        $this->db->from("santri as a, kelompok as b, shift as c, presensi as d, kehadiran as e, stts as f");
        $this->db->where("b.id_kelompok = a.kelompok_id");
        $this->db->where("c.id_shift = a.shift_id");
        $this->db->where("a.nis = d.nis");
        $this->db->where("d.id_khd = e.id_khd");
        $this->db->where("d.id_status = f.id_status");
        $this->db->where("d.id_khd", 1);
        $this->db->where("d.id_status", 2);
        $this->db->distinct();
        return $this->db->get('presensi')->result();
    }

    function santri_bak2($start, $end)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select("a.nis, a.nama_santri, a.shift_id, a.kelompok_id, b.nama_kelompok, c.nama_shift, d.id_khd, d.ket
        , f.nama_status");
        $this->db->from("santri as a, kelompok as b, shift as c, presensi as d, kehadiran as e, stts as f");
        $this->db->where("b.id_kelompok = a.kelompok_id");
        $this->db->where("c.id_shift = a.shift_id");
        $this->db->where("a.nis = d.nis");
        $this->db->where("d.id_khd = e.id_khd");
        $this->db->where("d.id_status = f.id_status");
        $this->db->where("d.id_khd", 1);
        $this->db->where("d.id_status", 2);
        $this->db->where("d.tgl >=", $start);
        $this->db->where("d.tgl <=", $end);
        $this->db->order_by("a.shift_id", "ASC");
        $this->db->order_by("a.kelompok_id", "ASC");
        $this->db->distinct();
        return $this->db->get('presensi')->result();
    }


    // fungsi menghitung total kehadiran (masuk)
    function totalHadir($nis)
    {
        $this->db->select("b.nis, a.tgl");
        $this->db->from("presensi as a, santri as b");
        $this->db->where("b.nis = a.nis");
        $this->db->where("b.nis", $nis);
        $this->db->where("a.id_khd", 1);
        $this->db->distinct();

        return $this->db->get()->num_rows();
    }

    function tohadir($nis)
    {
        $nis = $this->input->post('nis');
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $nis)
            ->where('id_khd', 1)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }

    function tosakit($nis)
    {
        $nis = $this->input->post('nis');
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $nis)
            ->where('id_khd', 2)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }

    function toijin($nis)
    {
        $nis = $this->input->post('nis');
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $nis)
            ->where('id_khd', 3)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }

    function toalpha($nis)
    {
        $nis = $this->input->post('nis');
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $nis)
            ->where('id_khd', 4)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }
    // fungsi menghitung total kehadiran (masuk)
    function totalHadir_bak($nis, $start, $end)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select("b.nis, a.tgl");
        $this->db->from("presensi as a, santri as b");
        $this->db->where("b.nis = a.nis");
        $this->db->where("b.nis", $nis);
        $this->db->where("a.id_khd", 1);
        $this->db->where("a.tgl >=", $start);
        $this->db->where("a.tgl <=", $end);
        $this->db->distinct();

        return $this->db->get()->num_rows();
    }

    // fungsi menghitung total kehadiran (sakit)
    function totalHadir2($nis, $start, $end)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select("b.nis, a.tgl");
        $this->db->from("presensi as a, santri as b");
        $this->db->where("b.nis=a.nis");
        $this->db->where("b.nis", $nis);
        $this->db->where("a.id_khd", 2);
        $this->db->where("a.tgl >=", $start);
        $this->db->where("a.tgl <=", $end);
        $this->db->distinct();
        return $this->db->get()->num_rows();
    }

    // fungsi menghitung total kehadiran (ijin)
    function totalHadir3($nis, $start, $end)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select("b.nis, a.tgl");
        $this->db->from("presensi as a, santri as b");
        $this->db->where("b.nis = a.nis");
        $this->db->where("b.nis", $nis);
        $this->db->where("a.id_khd", 3);
        $this->db->where("a.tgl >=", $start);
        $this->db->where("a.tgl <=", $end);
        $this->db->distinct();
        return $this->db->get()->num_rows();
    }

    // fungsi menghitung total kehadiran (alpha)
    function totalHadir4($nis, $start, $end)
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $this->db->select("b.nis, a.tgl");
        $this->db->from("presensi as a, santri as b");
        $this->db->where("b.nis = a.nis");
        $this->db->where("b.nis", $nis);
        $this->db->where("a.id_khd", 4);
        $this->db->where("a.tgl >=", $start);
        $this->db->where("a.tgl <=", $end);
        $this->db->distinct();
        return $this->db->get()->num_rows();
    }

    function update_khd()
    {
        $tgl = date('d');
        $id_status = 3;
        $id = $this->input->get('tgl');
        $id_khd = $this->input->get('id_khd');
        $kar = $this->input->get('nis');
        $ket = $this->input->post('ket');
        $query_str  =
            $this->db->where('tgl', $id)
            ->where('nis', $kar)
            ->where('id_status', 3)
            ->get('presensi');
        if ($query_str->num_rows() == 0) {
            $this->insert_khd();
        } else {
            $data = array(
                'id_khd' => $this->input->get('id_khd'),
                'ket' => $this->input->get('ket'),
            );
            $this->db->where('tgl', $id);
            $this->db->where('nis', $kar);
            $this->db->update('presensi', $data);
        }
    }

    function insert_khd()
    {
        $tgl = date('d');
        $id_status = 3;
        $id = $this->input->get('tgl');
        $id_khd = $this->input->get('id_khd');
        $kar = $this->input->get('nis');
        $ket = $this->input->get('ket');
        $insert = array(
            'nis' => $kar,
            'tgl' => $id,
            'id_khd' => $id_khd,
            'id_status' => $id_status,
            'ket' => $ket,
        );
        $this->db->where("nis", $this->input->get('kar'));
        $this->db->insert('presensi', $insert);
    }

    function tohadirM($id_krywn)
    {
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $id_krywn)
            ->where('id_khd', 1)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }

    function tosakitM($id_krywn)
    {
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $id_krywn)
            ->where('id_khd', 2)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }

    function toijinM($id_krywn)
    {
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $id_krywn)
            ->where('id_khd', 3)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }

    function toalphaM($id_krywn)
    {
        return
            $this->db->select('count(nis) as total')
            ->where('nis', $id_krywn)
            ->where('id_khd', 4)
            ->where('month(tgl) = month(CURRENT_date())')
            ->get('presensi')->result_array();
    }
}
