<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Genbar_Model extends CI_model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getShow($nis)
	{
		$this->db->where('nis', $nis);
		$hasil = $this->db->get('santri');
		return $hasil;
	}

	public function getshow_query($nis)
	{
		$result = $this->search_value($_POST['term'] = null);
		$this->db->select('a.nis, a.nama_santri, b.nama_kelompok, c.nama_shift');
		$this->db->from('santri as a, kelompok as b, shift as c');
		$this->db->where('b.id_kelompok = a.kelompok_id');
		$this->db->where('c.id_shift = a.shift_id');
		$this->db->where('nama_santri', $_POST['id']);
		$hasil = $this->db->get();
		return $hasil;
	}

	function search_value($title)
	{
		$this->db->like('nama_santri', $title, 'both');
		$this->db->order_by('nama_santri', 'ASC');
		$this->db->limit(10);
		return $this->db->get('santri')->result();
	}
}
