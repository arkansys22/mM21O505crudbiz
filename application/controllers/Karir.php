<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Karir extends CI_Controller {

    function __construct()
  {
    parent::__construct();
    /* memanggil model untuk ditampilkan pada masing2 modul */
    /* memanggil function dari masing2 model yang akan digunakan */
    $this->load->model(array('Crud_m'));
  }
  public function hubungi_kami()
{

			  $data['status']   = '';
    $data['status_produk']   = '';
    $data['status_lini']   = 'active';
    $data['posts_bisnis'] = $this->Crud_m->view_where_orders('bisnis','bisnis_status','bisnis_id','ASC');
      $data['identitas']= $this->Crud_m->get_by_id_identitas($id='1');



  $this->load->view('fronts/karir/v_hubungikami',$data);
}
}