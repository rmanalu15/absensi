<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekap extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        } else if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $models = array(
            'Rekap_model' => 'rekap',
            'Santri_model' => 'sant',
            'Pengajar_model' => 'peng'
        );
        $this->load->model($models);
        $this->load->library('form_validation');
        $this->user = $this->ion_auth->user()->row();
        $this->route = "rekap";
    }

    public function index()
    {
        $user = $this->user;
        $data = array(
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'rekap/rekap_list', $data);
        $this->load->view('template/datatables');
    }

    public function ajax_list_modal($id)
    {
        // var_dump($id);
        // die();
        $nomor_induk = $this->input->get('nomor_induk');
        $start = $this->input->get('tgl');
        $end = $this->input->get('tgl');
        $id_shift = $this->input->get('id_shift');
        if ($id == "S") {
            $data['colspan'] = $this->rekap->jmlHadir_1($start, $end);
        } else {
            $data['colspan'] = $this->rekap->jmlHadir_2($start, $end);
        }
        $data['start'] = $this->input->get('tgl');
        $data['end'] = $this->input->get('tgl');
        $data['id_shift'] = $this->input->get('id_shift');
        if ($id == "S") {
            $data['resultHadir'] =   $this->rekap->resultHadir2_1($start, $end);
            $data['data'] = $this->rekap->resultHadir2_1($start, $end);
        } else {
            $data['resultHadir'] =   $this->rekap->resultHadir2_2($start, $end);
            $data['data'] = $this->rekap->resultHadir2_2($start, $end);
        }
        $startdate = $this->input->get('start');
        $st = date('Y-m-d', strtotime($startdate));
        $t = explode('-', $st);
        $bulan = $this->tanggal->bulan($t[1]);
        $data['periode'] = $bulan . '&nbsp' . $t[0];
        $id_khd['id_khd'] = set_value('id_khd');
        if ($id == "S") {
            $result = array(
                $this->rekap->santri_bak2_1($id, $start, $end),
            );
        } else {
            $result = array(
                $this->rekap->santri_bak2_2($id, $start, $end),
            );
        }
        $this->load->view("rekap/modalAbsen", $data, $id_khd, $result);
    }

    public function ajax_list_laporan()
    {
        $user = $this->user;
        $data['user'] = $user;
        $start = $this->input->get('tgl');
        $end = $this->input->get('tgl');
        $this->load->view("rekap/ModalLaporan", $data, $start, $end);
    }

    public function ajax_list_modal2($id)
    {
        $nomor_induk = $this->input->get('nomor_induk');
        $start = $this->input->get('tgl');
        $end = $this->input->get('tgl');
        $id_shift = $this->input->get('$id_shift');
        $data['id_khd'] = set_value('id_khd');
        if ($id == "S") {
            $data['colspan'] = $this->rekap->jmlHadir_1($start, $end);
        } else {
            $data['colspan'] = $this->rekap->jmlHadir_2($start, $end);
        }
        $data['start'] = $this->input->get('tgl');
        $data['end'] = $this->input->get('tgl');
        $data['id_shift'] = $this->input->get('id_shift');
        if ($id == "S") {
            $data['resultHadir2'] = $this->rekap->santri_bak3_1($start, $end, $id_shift);
        } else {
            $data['resultHadir2'] = $this->rekap->santri_bak3_2($start, $end, $id_shift);
        }
        $startdate = $this->input->get('start');
        $st = date('Y-m-d', strtotime($startdate));
        $t = explode('-', $st);
        $bulan = $this->tanggal->bulan($t[1]);
        $data['periode'] = $bulan . '&nbsp' . $t[0];
        if ($id == "S") {
            $result = array(
                $this->rekap->santri_bak3_1($id, $start, $end, $id_shift),
            );
        } else {
            $result = array(
                $this->rekap->santri_bak3_2($id, $start, $end, $id_shift),
            );
        }
        $this->load->view("rekap/modalAbsen", $data, $result);
    }

    function addkhd()
    {
        $data = $this->rekap->update_khd();
    }
}
