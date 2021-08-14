<?php

class Scan extends Ci_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->library('form_validation');
		$this->load->model('Scan_model', 'Scan');
	}


	public function messageAlert($type, $title)
	{
		$messageAlert = "const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});
		Toast.fire({
			type: '" . $type . "',
			title: '" . $title . "'
		});";
		return $messageAlert;
	}

	function index()
	{
		$this->load->view('scan/scan_qrcode');
	}

	function pengajar()
	{
		$this->load->view('scan/scan_qrcode');
	}

	function cek_id()
	{
		$user = $this->user;
		$result_code = $this->input->post('nomor_induk');
		$tgl = date('Y-m-d');
		$jam_msk = date('h:i:s');
		$jam_klr = date('h:i:s');
		$cek_id = $this->Scan->cek_id($result_code);
		$cek_kehadiran = $this->Scan->cek_kehadiran($result_code, $tgl);
		if (!$cek_id) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Absen gagal, data tidak ditemukan!'));
			redirect($_SERVER['HTTP_REFERER']);
		} elseif ($cek_kehadiran && $cek_kehadiran->jam_msk != '00:00:00' && $cek_kehadiran->jam_klr == '00:00:00' && $cek_kehadiran->id_status == 1) {
			$data = array(
				'jam_klr' => $jam_klr,
				'id_status' => 2
			);
			$this->Scan->absen_pulang($result_code, $data);
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Absen pulang!'));
			redirect($_SERVER['HTTP_REFERER']);
		} elseif ($cek_kehadiran && $cek_kehadiran->jam_msk != '00:00:00' && $cek_kehadiran->jam_klr != '00:00:00' && $cek_kehadiran->id_status == 2) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('warning', 'Sudah absen!'));
			redirect($_SERVER['HTTP_REFERER']);
			return false;
		} else {
			$data = array(
				'nomor_induk' => $result_code,
				'tgl' => $tgl,
				'jam_msk' => $jam_msk,
				'id_khd' => 1,
				'id_status' => 1
			);
			$this->Scan->absen_masuk($data);
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Absen masuk!'));
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}
