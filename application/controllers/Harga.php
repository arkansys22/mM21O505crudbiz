<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Harga extends CI_Controller {

  function __construct()
  {
      parent::__construct();
      /* memanggil model untuk ditampilkan pada masing2 modul */
      $this->load->model(array('Crud_m'));
      /* memanggil function dari masing2 model yang akan digunakan */
    }
  public function detail($id)
	{

			$config['per_page'] = 4;
      
			$row = $this->Crud_m->get_by_id_post($id,'paketharga_id','paketharga','paketharga_judul_seo');
			if ($this->uri->segment('4')==''){
				$dari = 0;
				}else{
					$dari = $this->uri->segment('4');
			}
			if ($row)
				{
					$data['posts']            = $this->Crud_m->get_by_id_post($id,'paketharga_id','paketharga','paketharga_judul_seo');
					$this->add_count($id);
					$data['identitas']= $this->Crud_m->get_by_id_identitas($id='1');
          $data['posts_paketharga']= $this->Crud_m->view_one_limit('paketharga','paketharga_status','paketharga_id','ASC',$dari,$config['per_page']=30);

          $this->load->view('fronts/harga/v_detail', $data);
				}
				else
						{
							$this->session->set_flashdata('message', '<div class="alert alert-dismissible alert-danger">
								<button type="button" class="close" data-dismiss="alert">&times;</button>Bisnis tidak ditemukan</b></div>');
							redirect(base_url());
						}
	}
	function add_count($id)
	{
			$check_visitor = $this->input->cookie(urldecode($id), FALSE);
			$ip = $this->input->ip_address();
			if ($check_visitor == false) {
					$cookie = array("name" => urldecode($id), "value" => "$ip", "expire" => time() + 10, "secure" => false);
					$this->input->set_cookie($cookie);
					$this->Crud_m->update_counter_paketharga(urldecode($id));
			}
	}
}
