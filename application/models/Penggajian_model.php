<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penggajian_model extends CI_Model
{

    public $table = 'presensi';
    public $id = 'id_absen';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
}
