<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelompok extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->model('Kelompok_model');
        $this->load->library('form_validation');
        $this->user = $this->ion_auth->user()->row();
    }

    public function messageAlert($type, $title)
    {
        $messageAlert = "
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        Toast.fire({
            type: '" . $type . "',
            title: '" . $title . "'
        });
        ";
        return $messageAlert;
    }

    public function index()
    {
        $chek = $this->ion_auth->is_admin();

        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $kelompok = $this->Kelompok_model->get_all();

        $data = array(
            'kelompok_data' => $kelompok,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,

        );
        $this->template->load('template/template', 'kelompok/kelompok_list', $data);
        $this->load->view('template/datatables');
    }

    public function create()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('kelompok/create_action'),
            'id_kelompok' => set_value('id_kelompok'),
            'nama_kelompok' => set_value('nama_kelompok'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(), 'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'kelompok/kelompok_form', $data);
    }

    public function create_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_kelompok' => strtoupper($this->input->post('nama_kelompok', TRUE)),
            );
            $this->Kelompok_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan kelompok'));
            redirect(site_url('kelompok'));
        }
    }

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Kelompok_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('kelompok/update_action'),
                'id_kelompok' => set_value('id_kelompok', $row->id_kelompok),
                'nama_kelompok' => set_value('nama_kelompok', $row->nama_kelompok),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'kelompok/kelompok_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelompok'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kelompok', TRUE));
        } else {
            $data = array(
                'nama_kelompok' => strtoupper($this->input->post('nama_kelompok', TRUE)),
            );
            $this->Kelompok_model->update($this->input->post('id_kelompok', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data kelompok'));
            redirect(site_url('kelompok'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $row = $this->Kelompok_model->get_by_id($id);

        if ($row) {
            $this->Kelompok_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data kelompok'));
            redirect(site_url('kelompok'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'Data kelompok tidak ditemukan'));
            redirect(site_url('kelompok'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_kelompok', 'nama kelompok', 'trim|required');
        $this->form_validation->set_rules('id_kelompok', 'id_kelompok', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
