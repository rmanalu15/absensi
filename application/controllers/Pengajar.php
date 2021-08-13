<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengajar extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Pengajar_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper('url');
        $this->user = $this->ion_auth->user()->row();
    }

    public function printCard($nip)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('<a href="' . base_url('dashboard') . '">Kembali!</a>', 403, 'Akses Dilarang!');
        }
        $this->load->library('ciqrcode');
        $data['card'] = $this->Pengajar_model->get_card_pengajar($nip);
        $this->load->view('pengajar/print_card', $data);
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
        $pengajar = $this->Pengajar_model->get_all_query();
        $data = array(
            'pengajar_data' => $pengajar,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'pengajar/pengajar_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {
        $this->output_json($this->Pengajar_model->getData(), false);
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
            'action' => site_url('pengajar/create_action'),
            'nip' => set_value('nip'),
            'nama_pengajar' => set_value('nama_pengajar'),
            'tempat_lahir' => set_value('tempat_lahir'),
            'tanggal_lahir' => set_value('tanggal_lahir'),
            'jenis_kelamin' => set_value('jenis_kelamin'),
            'alamat' => set_value('alamat'),
            'foto' => set_value('foto'),
            'shift_id' => set_value('shift_id'),
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'pengajar/pengajar_form', $data);
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
            $var = $this->Pengajar_model->get_max();
            $getvar = $var[0]->kode;
            $nilai = $this->formatNbr($var[0]->kode);
            $nourut = 'P' . $tgl . $nilai;
            $data = array(
                'nip' => $nourut,
                'nama_pengajar' => ucwords($this->input->post('nama_pengajar', TRUE)),
                'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'foto' => $new_foto,
                'shift_id' => $this->input->post('shift_id', TRUE)
            );
            $this->Pengajar_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan pengajar'));
            redirect(site_url('pengajar'));
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
        $row = $this->Pengajar_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('pengajar/update_action'),
                'id' => set_value('id', $row->id),
                'nip' => set_value('nip', $row->nip),
                'nama_pengajar' => set_value('nama_pengajar', $row->nama_pengajar),
                'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
                'tanggal_lahir' => set_value('tanggal_lahir', $row->tanggal_lahir),
                'alamat' => set_value('alamat', $row->alamat),
                'foto' => set_value('foto', $row->foto),
                'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
                'shift_id' => set_value('shift_id', $row->shift_id),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'pengajar/pengajar_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengajar'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        $row = $this->Pengajar_model->get_by_id($this->input->post('id'));
        $nip = $row->nip;

        $upload_foto = $_FILES['foto']['name'];
        if ($upload_foto) {
            $config['allowed_types'] = 'jpg|png';
            $config['upload_path'] = './assets/images/profile/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                // $old_foto = $row->foto;
                // if ($old_foto != 'default.png') {
                //     unlink(FCPATH . 'assets/images/profile/' . $old_foto);
                // }
                $new_foto = $this->upload->data('file_name');
            } else {
                echo $this->upload->dispay_errors();
            }
        } else {
            $new_foto = $row->foto;
        }

        $data = array(
            'nip' => $nip,
            'nama_pengajar' => $this->input->post('nama_pengajar', TRUE),
            'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'foto' => $new_foto,
            'shift_id' => $this->input->post('shift_id', TRUE),
        );

        $this->Pengajar_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data pengajar'));
        redirect(site_url('pengajar'));
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Pengajar_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Pengajar_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data pengajar'));
            redirect(site_url('pengajar'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('pengajar'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama_pengajar', 'nama pengajar', 'trim|required');
        $this->form_validation->set_rules('shift_id', 'shift_id', 'trim|required');
        $this->form_validation->set_rules('nip', 'nip', 'trim');
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
