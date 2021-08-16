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
        $penggajian = $this->Penggajian_model->get_all_query();
        $data = array(
            'penggajian_data' => $penggajian,
            'user' => $user,
            'users' => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'penggajian/penggajian_list', $data);
        $this->load->view('template/datatables');
    }

    public function data()
    {
        $this->output_json($this->Penggajian_model->get_all_q(), false);
    }


    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }
}
