<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penggajian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $models = array(
            'Rekap_model' => 'rekap'
        );
        $this->load->model($models);
        $this->load->model('Penggajian_model');
        $this->user = $this->ion_auth->user()->row();
        $this->load->library('user_agent');
    }

    public function index()
    {
        $this->session->set_userdata('referred_from', current_url());
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $data = array(
            'user' => $user,
            'users' => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'penggajian/penggajian_list', $data);
        $this->load->view('template/datatables');
    }
}
