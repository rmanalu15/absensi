<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Santri extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Santri_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper('url');
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
        $santri = $this->Santri_model->get_all_query();
        $data = array(
            'santri_data' => $santri,
            'user' => $user, 'users' => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'santri/santri_list', $data);
        $this->load->view('template/datatables');
    }

    public function printCard($nis)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('<a href="' . base_url('dashboard') . '">Kembali!</a>', 403, 'Akses Dilarang!');
        }
        $this->load->library('ciqrcode');
        $data['card'] = $this->Santri_model->get_card_santri($nis);
        $this->load->view('santri/print_card', $data);
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Santri_model->getData(), false);
    }

    public function create()
    {
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('santri/create_action'),
            'nis' => set_value('nis'),
            'nama_santri' => set_value('nama_santri'),
            'tempat_lahir' => set_value('tempat_lahir'),
            'tanggal_lahir' => set_value('tanggal_lahir'),
            'jenis_kelamin' => set_value('jenis_kelamin'),
            'alamat' => set_value('alamat'),
            'nama_orang_tua' => set_value('nama_orang_tua'),
            'kelompok_id' => set_value('kelompok_id'),
            'foto' => set_value('foto'),
            'shift_id' => set_value('shift_id'),
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'santri/santri_form', $data);
    }
    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            /* Fungsi update foto */
            $upload_foto = $_FILES['foto']['name'];
            if ($upload_foto) {
                $config['allowed_types'] = 'jpg|png';
                $config['upload_path'] = './assets/images/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    /* Fungsi delete foto lama */
                    // $old_foto = $row->foto;
                    // if ($old_foto != 'default.png') {
                    //     unlink(FCPATH . 'assets/images/profile/' . $old_foto);
                    // }
                    /* End fungsi delete foto lama */
                    $new_foto = $this->upload->data('file_name');
                } else {
                    echo "Format Foto Tidak Mendukung!";
                }
            } else {
                $new_foto = 'default.png';
            }
            /* End fungsi update foto */

            $tgl = date('ym');
            $var = $this->Santri_model->get_max();
            $getvar = $var[0]->kode;
            $nilai = $this->formatNbr($var[0]->kode);
            $nourut = 'S' . $tgl . $nilai;
            $data = array(
                'nis' => $nourut,
                'nama_santri' => ucwords($this->input->post('nama_santri', TRUE)),
                'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'nama_orang_tua' => $this->input->post('nama_orang_tua', TRUE),
                'kelompok_id' => $this->input->post('kelompok_id', TRUE),
                'foto' => $new_foto,
                'shift_id' => $this->input->post('shift_id', TRUE)
            );
            $this->Santri_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan santri'));
            redirect(site_url('santri'));
        }
    }

    function formatNbr($nbr)
    {
        if ($nbr == 0)
            return "001";
        else if ($nbr < 10)
            return "00" . $nbr;
        elseif ($nbr >= 10 && $nbr < 100)
            return "0" . $nbr;
        else
            return strval($nbr);
    }


    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $user = $this->user;
        $row = $this->Santri_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('santri/update_action'),
                'id' => set_value('id', $row->id),
                'nis' => set_value('nis', $row->nis),
                'nama_santri' => set_value('nama_santri', $row->nama_santri),
                'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
                'tanggal_lahir' => set_value('tanggal_lahir', $row->tanggal_lahir),
                'alamat' => set_value('alamat', $row->alamat),
                'foto' => set_value('foto', $row->foto),
                'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
                'shift_id' => set_value('shift_id', $row->shift_id),
                'kelompok_id' => set_value('kelompok_id', $row->kelompok_id),
                'nama_orang_tua' => set_value('nama_orang_tua', $row->nama_orang_tua),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'santri/santri_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('santri'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        $row = $this->Santri_model->get_by_id($this->input->post('id'));
        $nis = $row->nis;

        /* Fungsi update foto */
        $upload_foto = $_FILES['foto']['name'];
        if ($upload_foto) {
            $config['allowed_types'] = 'jpg|png';
            $config['upload_path'] = './assets/images/profile/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                /* Fungsi delete foto lama */
                // $old_foto = $row->foto;
                // if ($old_foto != 'default.png') {
                //     unlink(FCPATH . 'assets/images/profile/' . $old_foto);
                // }
                /* End fungsi delete foto lama */
                $new_foto = $this->upload->data('file_name');
            } else {
                echo "Format Foto Tidak Mendukung!";
            }
        } else {
            $new_foto = $row->foto;
        }
        /* End fungsi update foto */

        $data = array(
            'nis' => $nis,
            'nama_santri' => $this->input->post('nama_santri', TRUE),
            'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'nama_orang_tua' => $this->input->post('nama_orang_tua', TRUE),
            'kelompok_id' => $this->input->post('kelompok_id', TRUE),
            'foto' => $new_foto,
            'shift_id' => $this->input->post('shift_id', TRUE),
        );

        $this->Santri_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data santri'));
        redirect(site_url('santri'));
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Santri_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Santri_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data santri'));
            redirect(site_url('santri'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('santri'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama_santri', 'nama santri', 'trim|required');
        $this->form_validation->set_rules('kelompok_id', 'kelompok_id', 'trim|required');
        $this->form_validation->set_rules('shift_id', 'shift_id', 'trim|required');
        $this->form_validation->set_rules('nis', 'nis', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function _set_useragent()
    {
        if ($this->agent->is_mobile('iphone')) {
            $this->agent = 'iphone';
        } elseif ($this->agent->is_mobile()) {
            $this->agent = 'mobile';
        } else {
            $this->agent = 'desktop';
        }
    }
}
