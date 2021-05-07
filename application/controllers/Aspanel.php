<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Aspanel extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model(array('As_m','Crud_m'));
		$this->load->helper(array('form', 'url','custom'));
		$this->load->library(array('session', 'form_validation','mylibrary','email','upload'));
	}
	public function index()
	{
			redirect(base_url('login'));
	}
	public function home()
	{
		if ($this->session->level=='1'){
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = 'active';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';
			$this->load->view('backend/home', $data);
		}elseif ($this->session->level=='2'){
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = 'active';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';

			$this->load->view('backend/home', $data);
		}elseif ($this->session->level=='3'){
            $data['karyawan_menu_open']   = '';
			$data['home_stat']   = 'active';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';
				$this->load->view('backend/home', $data);
		}else{
			redirect(base_url());
		}
	}
	public function login()
	{
            $data['title'] = 'Sign In';

            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if($this->form_validation->run() === FALSE){
                $this->load->view('backend/index', $data);
            } else {

                $username = $this->input->post('username');
                $password = sha1($this->input->post('password'));
								$cek = $this->As_m->cek_login($username,$password,'user');
							    $row = $cek->row_array();
							    $total = $cek->num_rows();
									if ($total > 0){
										$this->session->set_userdata(
											array(
												'username'=>$row['username'],
												'level'=>$row['level'],
												'id_users'=>$row['id_users'],
												'id_session'=>$row['id_session']));

										 $this->session->set_flashdata('user_loggedin','Selamat Anda Berhasil Login');
										$id = array('id_session' => $this->session->id_session);
									 	$data = array('user_login_status'=>'online','user_login_tanggal'=> date('Y-m-d'),'user_login_jam'=> date('H:i:s'));
									 	$this->db->update('user', $data, $id);
										redirect('aspanel/home');
									}else {
                    // Set message
                    $this->session->set_flashdata('login_failed', 'Username Dan Password salah!');

                    redirect(base_url('login'));
                }
            }
        }
	public function register()
	{
						$data['title'] = 'Sign Up';
            $this->form_validation->set_rules('username','','required|min_length[5]|max_length[12]|is_unique[user.username]', array('required' => 'username masih kosong','is_unique' => 'Username telah digunakan, silahkan gunakan username lain.'));
						$this->form_validation->set_rules('nama','','required', array('required'=>'Nama masih kosong'));
            $this->form_validation->set_rules('email','','required|valid_email|is_unique[user.email]', array('required' => 'Email masih kosong','is_unique' => 'Email telah digunakan, silahkan gunakan email lain.'));
            $this->form_validation->set_rules('password','','required', array('required'=>'Password masih kosong'));
            $this->form_validation->set_rules('password2', '','required|matches[password]', array('required' => 'Konfirmasi password masih kosong','matches'=>'Password tidak sama! Cek kembali password Anda'));

            if($this->form_validation->run() === FALSE){
                $this->load->view('backend/register', $data);
            }else{
                $enc_password = sha1($this->input->post('password'));
								$data_user = array(
													'username' => $this->input->post('username'),
													'email' => $this->input->post('email'),
													'password' => $enc_password,
													'user_status' => '1',
													'level' => '4',
													'user_post_hari'=>hari_ini(date('w')),
													'user_post_tanggal'=>date('Y-m-d'),
													'user_post_jam'=>date('H:i:s'),
													'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
													'nama' => $this->input->post('nama'));
								$id_pelanggan = $this->Crud_m->tambah_user($data_user);
								$data_user_detail = array(
											   	'id_user' => $id_pelanggan);
								$this->Crud_m->tambah_user_detail($data_user_detail);

                $this->session->set_flashdata('user_registered', 'You are now registered and can log in');

                redirect(base_url("login"));
            }
			}
	public function check_username_exists($username)
	{
					 $this->form_validation->set_message('check_username_exists', 'Username Sudah diambil. Silahkan gunakan username lain');
					 if($this->As_m->check_username_exists($username)){
							 return true;
					 } else {
							 return false;
					 }
	}
	public function check_email_exists($email)
	{
            $this->form_validation->set_message('check_email_exists', 'Email Sudah diambil. Silahkan gunakan email lain');
            if($this->As_m->check_email_exists($email)){
                return true;
            } else {
                return false;
            }
  }
	public function logout()
	{
		$id = array('id_session' => $this->session->id_session);
						$data = array('user_login_status'=>'offline');
						$this->db->update('user', $data, $id);
            // Unset user data
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('username');

            // Set message
            $this->session->set_flashdata('user_logout', 'You are now logged out');
						$this->session->sess_destroy();
            redirect(base_url());
    }
	public function profil()
	{
		cek_session_akses($this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'assets/frontend/user/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/user/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '90%';
			$config['width']= 200;
			$config['height']= 200;
			$config['new_image']= './assets/frontend/user/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

				if ($hasil22['file_name']=='' AND $this->input->post('password')=='' ){
									          $data = array(
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
						    								$this->db->update('user',$data,$where);
															}else if ($this->input->post('password')=='' ){
																$data = array(
																'user_gambar'=>$hasil22['file_name'],
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
																$_image = $this->db->get_where('user',$where)->row();
																$query = $this->db->update('user',$data,$where);
																if($query){
																	unlink("assets/frontend/user/".$_image->user_gambar);
																}
															}else if ($hasil22['file_name']==''){
																$data = array(
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'password'=>sha1($this->input->post('password')),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
						    								$this->db->update('user',$data,$where);
															}else{
															$data = array(
																'user_gambar'=>$hasil22['file_name'],
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'password'=>sha1($this->input->post('password')),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
																$_image = $this->db->get_where('user',$where)->row();
																$query = $this->db->update('user',$data,$where);
																if($query){
																	unlink("assets/frontend/user/".$_image->user_gambar);
																}
															}
			redirect('aspanel/profil');
		}else{
		$proses = $this->As_m->edit('user', array('username' => $this->session->username))->row_array();
		$data = array('record' => $proses);
				$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
	    $data['jamkerja_stat']   = '';
	    $data['absen_stat']   = '';
	    $data['dataabsen_stat']   = '';
	    $data['cuti_stat']   = '';
	    $data['gaji_stat']   = '';
	    $data['pengumuman_stat']   = '';
	    $data['konfig_stat']   = 'active';
			$data['produk_menu_open']   = '';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = '';

			$data['post'] = $this->As_m->view_ordering('user_detail','id_user','ASC');
			if ($this->session->level=='1'){
					$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'1'),'id_user','DESC');
			}else{
			}
			$this->load->view('backend/profil/profilall', $data);
			}
		}
	public function user_update()
	{
				cek_session_akses($this->session->id_session);
				$id = $this->uri->segment(3);
				if (isset($_POST['submit'])){
					$config['upload_path'] = 'assets/frontend/user/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/user/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '90%';
					$config['width']= 200;
					$config['height']= 200;
					$config['new_image']= './assets/frontend/user/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($hasil22['file_name']=='' AND $this->input->post('password')=='' ){
										          $data = array(
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
							    								$this->db->update('user',$data,$where);
																}else if ($this->input->post('password')=='' ){
																	$data = array(
																	'user_gambar'=>$hasil22['file_name'],
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
																	$_image = $this->db->get_where('user',$where)->row();
																	$query = $this->db->update('user',$data,$where);
																	if($query){
																		unlink("assets/frontend/user/".$_image->user_gambar);
																	}
																}else if ($hasil22['file_name']==''){
																	$data = array(
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'password'=>sha1($this->input->post('password')),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
							    								$this->db->update('user',$data,$where);
																}else{
																$data = array(
																	'user_gambar'=>$hasil22['file_name'],
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'password'=>sha1($this->input->post('password')),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
																	$_image = $this->db->get_where('user',$where)->row();
																	$query = $this->db->update('user',$data,$where);
																	if($query){
																		unlink("assets/frontend/user/".$_image->user_gambar);
																	}
																}

					redirect('aspanel/profil');
				}else{
				if ($this->session->level=='1'){
							 $proses = $this->As_m->edit('user', array('id_session' => $id))->row_array();
					}else{
							$proses = $this->As_m->edit('user', array('id_session' => $id))->row_array();
					}
					$data = array('rows' => $proses);
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = 'active';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
					$data['post'] = $this->As_m->view_ordering('user_detail','id_user','ASC');
					if ($this->session->level=='1'){
							$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'active'),'id_user','DESC');
					}else{
					}
					$data['records'] = $this->Crud_m->view_ordering('user_level','user_level_id','DESC');
					$data['record_status'] = $this->Crud_m->view_ordering('user_status','user_status_id','DESC');
					$this->load->view('backend/profil/profiledit', $data);
					}
			}
	public function user_storage_bin()
	{
				cek_session_akses ($this->session->id_session);
				$data['karyawan_menu_open']   = '';
				$data['home_stat']   = '';
				$data['identitas_stat']   = '';
				$data['profil_stat']   = 'active';
				$data['sliders_stat']   = '';
				$data['products_stat']   = '';
				$data['cat_products_stat']   = '';
				$data['slider_stat']   = '';
				$data['blogs_stat']   = '';
				$data['message_stat']   = '';
				$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

						if ($this->session->level=='1'){
								$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'2'),'id_user','DESC');
						}else{
								$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'2'),'id_user','DESC');
						}
						$this->load->view('backend/profil/profilblock', $data);
			}
	public function user_delete()
	{
					cek_session_akses ('profil',$this->session->id_session);
					$id = $this->uri->segment(3);
					$_id = $this->db->get_where('user',['id_session' => $id])->row();
					 $query = $this->db->delete('user',['id_session'=>$id]);
				 	if($query){
									 unlink("./bahan/foto_profil/".$_id->user_gambar);
				 }
				redirect('aspanel/user_storage_bin');
			}

	function identitaswebsite()
	{
		cek_session_akses($this->session->id_session);
		if (isset($_POST['submit'])){
					$config['upload_path'] = 'assets/frontend/campur/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('logo');
					$hasillogo=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/campur/'.$hasillogo['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['height']= 48;
					$config['new_image']= './assets/frontend/campur/'.$hasillogo['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$this->upload->initialize($config);
					$this->upload->do_upload('favicon');
					$hasilfav=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/campur/'.$hasilfav['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '50%';
					$config['width']= 30;
					$config['height']= 30;
					$config['new_image']= './assets/frontend/campur/'.$hasilfav['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('meta_keyword')!=''){
								$tag_seo = $this->input->post('meta_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('meta_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
          if ($hasilfav['file_name']=='' && $hasillogo['file_name']==''){
            	$data = array(
            	                	'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
                                'email'=>$this->db->escape_str($this->input->post('email')),
                                'url'=>$this->db->escape_str($this->input->post('url')),
                                'facebook'=>$this->input->post('facebook'),
                                'instagram'=>$this->input->post('instagram'),
                                'youtube'=>$this->input->post('youtube'),
                                'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
                                'slogan'=>$this->input->post('slogan'),
                                'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
                                'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
                                'meta_keyword'=>$tag,
                                'maps'=>$this->input->post('maps'),
															);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
    														$query = $this->db->update('identitas',$data,$where);
            }else if ($hasillogo['file_name']==''){
            	$data = array(
																'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
																'email'=>$this->db->escape_str($this->input->post('email')),
																'url'=>$this->db->escape_str($this->input->post('url')),
																'facebook'=>$this->input->post('facebook'),
																'instagram'=>$this->input->post('instagram'),
																'youtube'=>$this->input->post('youtube'),
																'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
																'slogan'=>$this->input->post('slogan'),
																'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
																'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
																'meta_keyword'=>$tag,
																'maps'=>$this->input->post('maps'),
                                'favicon'=>$hasilfav['file_name']);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
						    								$_image = $this->db->get_where('identitas',$where)->row();
						    								$query = $this->db->update('identitas',$data,$where);
						    								if($query){
						    					                unlink("assets/frontend/campur/".$_image->favicon);
						    					                }
            }else if ($hasilfav['file_name']==''){
            	$data = array(
																'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
																'email'=>$this->db->escape_str($this->input->post('email')),
																'url'=>$this->db->escape_str($this->input->post('url')),
																'facebook'=>$this->input->post('facebook'),
																'instagram'=>$this->input->post('instagram'),
																'youtube'=>$this->input->post('youtube'),
																'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
																'slogan'=>$this->input->post('slogan'),
																'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
																'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
																'meta_keyword'=>$tag,
																'maps'=>$this->input->post('maps'),
                                'logo'=>$hasillogo['file_name']);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
						    								$_image = $this->db->get_where('identitas',$where)->row();
						    								$query = $this->db->update('identitas',$data,$where);
						    								if($query){
						    					                unlink("assets/frontend/campur/".$_image->logo);
						    					                }
            }else{
            	$data = array(
																'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
																'email'=>$this->db->escape_str($this->input->post('email')),
																'url'=>$this->db->escape_str($this->input->post('url')),
																'facebook'=>$this->input->post('facebook'),
																'instagram'=>$this->input->post('instagram'),
																'youtube'=>$this->input->post('youtube'),
																'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
																'slogan'=>$this->input->post('slogan'),
																'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
																'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
																'meta_keyword'=>$tag,
																'maps'=>$this->input->post('maps'),
																'favicon'=>$hasilfav['file_name'],
                                'logo'=>$hasillogo['file_name']);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
						    								$_image = $this->db->get_where('identitas',$where)->row();
						    								$query = $this->db->update('identitas',$data,$where);
						    								if($query){
						    					                unlink("assets/frontend/campur/".$_image->favicon);
																					unlink("assets/frontend/campur/".$_image->logo);
						    					                }
            }
			redirect('aspanel/identitaswebsite');
		}else{

			$proses = $this->As_m->edit('identitas', array('id_identitas' => 1))->row_array();
			$data = array('record' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = 'active';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';
			 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/identitas/views', $data);
		}
	}

    /* Data konsumen */

  public function konsumen()
  {
    	    if ($this->session->level=='1'){

    						$data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_status'=>'publish'),'konsumen_tgl_order','ASC');
    				}else if  ($this->session->level=='2'){
    						$data['record'] = $this->Crud_m->view_join_where_ordering_konsumen_leader('konsumen','perumahan','user','konsumen_perumahan_kode','perumahan_kode','id_user','perumahan_pl',array('konsumen_status'=>'publish'),'konsumen_tgl_order','ASC');
    				}else{
    						$data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_cs_fu'=>$this->session->username,'konsumen_status'=>'publish'),'konsumen_tgl_order','ASC');
    				}

    			    $this->load->view('backend/konsumen/v_daftar', $data);
    	}
  public function exportxlskonsumen()
  {
      $data = $this->Crud_m->view_ordering('konsumen','konsumen_tgl_order','ASC');

      include_once APPPATH.'/third_party/xlsxwriter.class.php';
      ini_set('display_errors', 0);
      ini_set('log_errors', 1);
      error_reporting(E_ALL & ~E_NOTICE);


      $filename = "report-".date('d-m-Y-H-i-s').".xlsx";
      header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');

      $styles = array('widths'=>[3,20,30,40], 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'center', 'border'=>'left,right,top,bottom');
      $styles2 = array( ['font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'left', 'border'=>'left,right,top,bottom','fill'=>'#ffc'],['fill'=>'#fcf'],['fill'=>'#ccf'],['fill'=>'#cff'],);

      $header = array(
        'No'=>'integer',
        'Nama Sales'=>'string',
        'Nama Konsumen'=>'string',
        'Tanggal Dealing'=>'string',
        'Minggu'=>'string',
        'Perumahan'=>'string',
        'Media Promosi' =>'string',
        'Nomor Telepon' =>'string',
        'Pembayaran'=>'string',
        'Tanggal FU'=>'string',
        'Status'=>'string',
        'Status Proses'=>'string',
        'Status Prospek'=>'string',
        'Status Update'=>'string',
        'Detail Kondisi'=>'string',
        'Solusi'=>'string',
        'Gaji Istri'=>'string',
        'Gaji Suami'=>'string',
        'Cicilan'=>'string',
        'Kantor Suami'=>'string',
        'Kantor Istri'=>'string',
        'Domisili'=>'string',
      );

      $writer = new XLSXWriter();
      $writer->setAuthor('Admin');

      $writer->writeSheetHeader('Sheet1', $header, $styles);
      $no = 1;
      foreach($data as $row){
        $writer->writeSheetRow('Sheet1', [$no, $row['konsumen_cs_fu'], $row['konsumen_nama'], $row['konsumen_tgl_order'], $row['konsumen_minggu'], $row['konsumen_perumahan_kode'], $row['konsumen_media_nama'], $row['konsumen_telp'], $row['konsumen_pembayaran'], $row['konsumen_tgl_fu'], $row['konsumen_stat'], $row['konsumen_statpros'], $row['konsumen_statprospek'], $row['konsumen_statupdate'], $row['konsumen_kondisi'], $row['konsumen_solusi'], $row['konsumen_gi'], $row['konsumen_gs'], $row['konsumen_cicilan'], $row['konsumen_ks'], $row['konsumen_ki'], $row['konsumen_domisili']], $styles2);
        $no++;
      }
      $writer->writeToStdOut();
    }
	public function konsumen_storage_bin()
	{


				if ($this->session->level=='1'){
				        $data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_status'=>'delete'),'konsumen_tgl_order','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_cs_fu'=>$this->session->username,'konsumen_status'=>'delete'),'konsumen_tgl_order','DESC');
				}
				$this->load->view('backend/konsumen/v_daftar_hapus', $data);
	}
	public function konsumen_tambahkan()
	{


             if (isset($_POST['submit'])){
							$data = array(
							                'konsumen_kode'=>$this->input->post('konsumen_kode'),
											'konsumen_nama'=>$this->input->post('konsumen_nama'),
											'konsumen_tgl_order'=>$this->input->post('konsumen_tgl_order'),
											'konsumen_minggu'=>$this->input->post('konsumen_minggu'),
											'konsumen_perumahan_kode'=>$this->input->post('konsumen_perumahan_kode'),
											'konsumen_media_nama'=>$this->input->post('konsumen_media_nama'),
											'konsumen_telp'=>$this->input->post('konsumen_telp'),
											'konsumen_pembayaran'=>$this->input->post('konsumen_pembayaran'),
											'konsumen_cs_fu'=>$this->input->post('konsumen_cs_fu'),
											'konsumen_tgl_fu'=>$this->input->post('konsumen_tgl_fu'),
											'konsumen_stat'=>$this->input->post('konsumen_stat'),
											'konsumen_statprospek'=>$this->input->post('konsumen_statprospek'),
											'konsumen_statpros'=>$this->input->post('konsumen_statpros'),
											'konsumen_statupdate'=>$this->input->post('konsumen_statupdate'),
											'konsumen_kondisi'=>$this->input->post('konsumen_kondisi'),
											'konsumen_solusi'=>$this->input->post('konsumen_solusi'),
											'konsumen_gi'=>$this->input->post('konsumen_gi'),
											'konsumen_gs'=>$this->input->post('konsumen_gs'),
											'konsumen_cicilan'=>$this->input->post('konsumen_cicilan'),
											'konsumen_ki'=>$this->input->post('konsumen_ki'),
											'konsumen_ks'=>$this->input->post('konsumen_ks'),
											'konsumen_domisili'=>$this->input->post('konsumen_domisili'),

											'konsumen_post_oleh'=>$this->session->username,
											'konsumen_hari'=>hari_ini(date('w')),
											'konsumen_tanggal'=>date('Y-m-d'),
											'konsumen_jam'=>date('H:i:s'),
											'konsumen_status'=>'publish');

								$this->As_m->insert('konsumen',$data);
								redirect('aspanel/konsumen');
				}else{

		            $data['record_cs'] = $this->Crud_m->view_ordering('user','id_user','DESC');
		            $data['record_stat'] = $this->Crud_m->view_ordering('konsumen_status','konsumen_status_id','ASC');
		            $data['record_statupdate'] = $this->Crud_m->view_ordering('konsumen_statupdate','konsumen_statupdate_id','ASC');
		            $data['record_statpros'] = $this->Crud_m->view_ordering('konsumen_statpros','konsumen_statpros_id','ASC');
		            $data['record_statprospek'] = $this->Crud_m->view_ordering('konsumen_statprospek','konsumen_statprospek_id','DESC');
		            $data['record_minggu'] = $this->Crud_m->view_ordering('konsumen_minggu','konsumen_minggu_id','ASC');
		            $data['record_kategori'] = $this->Crud_m->view_ordering('bisnis','bisnis_id','ASC');
		            $data['record_medpro'] = $this->Crud_m->view_ordering('media_promosi','media_promosi_id','ASC');
		            $data['record_bayar'] = $this->Crud_m->view_ordering('konsumen_pembayaran','konsumen_pembayaran_id','ASC');
					$this->load->view('backend/konsumen/v_tambahkan', $data);

				}
	}
	public function konsumen_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
						$data = array(
						                    'konsumen_kode'=>$this->input->post('konsumen_kode'),
											'konsumen_nama'=>$this->input->post('konsumen_nama'),
											'konsumen_tgl_order'=>$this->input->post('konsumen_tgl_order'),
											'konsumen_minggu'=>$this->input->post('konsumen_minggu'),
											'konsumen_perumahan_kode'=>$this->input->post('konsumen_perumahan_kode'),
											'konsumen_media_nama'=>$this->input->post('konsumen_media_nama'),
											'konsumen_telp'=>$this->input->post('konsumen_telp'),
											'konsumen_pembayaran'=>$this->input->post('konsumen_pembayaran'),
											'konsumen_cs_fu'=>$this->input->post('konsumen_cs_fu'),
											'konsumen_tgl_fu'=>$this->input->post('konsumen_tgl_fu'),
											'konsumen_stat'=>$this->input->post('konsumen_stat'),
											'konsumen_statprospek'=>$this->input->post('konsumen_statprospek'),
											'konsumen_statpros'=>$this->input->post('konsumen_statpros'),
											'konsumen_statupdate'=>$this->input->post('konsumen_statupdate'),
											'konsumen_kondisi'=>$this->input->post('konsumen_kondisi'),
											'konsumen_solusi'=>$this->input->post('konsumen_solusi'),
											'konsumen_gi'=>$this->input->post('konsumen_gi'),
											'konsumen_gs'=>$this->input->post('konsumen_gs'),
											'konsumen_cicilan'=>$this->input->post('konsumen_cicilan'),
											'konsumen_ki'=>$this->input->post('konsumen_ki'),
											'konsumen_ks'=>$this->input->post('konsumen_ks'),
											'konsumen_domisili'=>$this->input->post('konsumen_domisili'));
											$where = array('konsumen_id' => $this->input->post('konsumen_id'));
											$this->db->update('konsumen', $data, $where);

						redirect('aspanel/konsumen');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}
			 $data = array('rows' => $proses);
			 $data['record_cs'] = $this->Crud_m->view_ordering('user','id_user','DESC');
		     $data['record_stat'] = $this->Crud_m->view_ordering('konsumen_status','konsumen_status_id','ASC');
		     $data['record_statupdate'] = $this->Crud_m->view_ordering('konsumen_statupdate','konsumen_statupdate_id','ASC');
		     $data['record_statpros'] = $this->Crud_m->view_ordering('konsumen_statpros','konsumen_statpros_id','ASC');
		     $data['record_statprospek'] = $this->Crud_m->view_ordering('konsumen_statprospek','konsumen_statprospek_id','DESC');
		     $data['record_minggu'] = $this->Crud_m->view_ordering('konsumen_minggu','konsumen_minggu_id','ASC');
		     $data['record_kodeper'] = $this->Crud_m->view_ordering('perumahan','perumahan_id','ASC');
		     $data['record_medpro'] = $this->Crud_m->view_ordering('media_promosi','media_promosi_id','ASC');
		     $data['record_bayar'] = $this->Crud_m->view_ordering('konsumen_pembayaran','konsumen_pembayaran_id','ASC');
			$this->load->view('backend/konsumen/v_update', $data);
		}
	}
	public function konsumen_detail()
	{

		$id = $this->uri->segment(3);

			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}
				$data = array('rows' => $proses);

        $data['record_cs'] = $this->Crud_m->view_ordering('user','id_user','DESC');
	    $data['record'] = $this->Crud_m->view_ordering('perumahan','perumahan_id','DESC');
		$this->load->view('backend/konsumen/v_detail', $data);

	}
	function konsumen_delete_temp()
	{

			$data = array('konsumen_status'=>'delete');
			$where = array('konsumen_id' => $this->uri->segment(3));
			$this->db->update('konsumen', $data, $where);
			redirect('aspanel/konsumen');
	}
	function konsumen_restore()
	{

			$data = array('konsumen_status'=>'Publish');
			$where = array('konsumen_id' => $this->uri->segment(3));
			$this->db->update('konsumen', $data, $where);
			redirect('aspanel/konsumen');
	}
	public function konsumen_delete()
	{

			$id = $this->uri->segment(3);

			 $query = $this->db->delete('konsumen',['konsumen_id'=>$id]);

		redirect('aspanel/konsumen_storage_bin');
	}
	/* konsumen - tutup */


	/*	Bagian untuk slider - Pembuka	*/
	public function slider()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = 'active';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
		$data['jamkerja_stat']   = '';
		$data['absen_stat']   = '';
		$data['dataabsen_stat']   = '';
		$data['cuti_stat']   = '';
		$data['gaji_stat']   = '';
		$data['pengumuman_stat']   = '';
		$data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'publish'),'slider_id','DESC');
				}elseif ($this->session->level=='2'){
						$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'publish'),'slider_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_post_oleh'=>$this->session->username,'slider_status'=>'publish'),'slider_id','DESC');
				}
				$this->load->view('backend/slider/v_daftar', $data);
	}
	public function slider_storage_bin()
	{
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'delete'),'slider_id','DESC');
				}elseif ($this->session->level=='2'){
						$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'delete'),'slider_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_post_oleh'=>$this->session->username,'slider_status'=>'delete'),'slider_id','DESC');
				}

				$data['karyawan_menu_open']   = '';
				$data['home_stat']   = '';
				$data['identitas_stat']   = '';
				$data['profil_stat']   = '';
				$data['sliders_stat']   = '';
				$data['products_stat']   = '';
				$data['cat_products_stat']   = '';
				$data['slider_stat']   = 'active';
				$data['blogs_stat']   = '';
				$data['message_stat']   = '';
				$data['gallery_stat']   = '';
				$data['kehadiran_menu_open']   = '';
				$data['jamkerja_stat']   = '';
				$data['absen_stat']   = '';
				$data['dataabsen_stat']   = '';
				$data['cuti_stat']   = '';
				$data['gaji_stat']   = '';
				$data['pengumuman_stat']   = '';
				$data['konfig_stat']   = '';
				$data['produk_menu_open']   = '';
				$data['produk_category']   = '';
				$data['produk']   = '';
				$data['services']   = '';

				$this->load->view('backend/slider/v_daftar_hapus', $data);
	}
	public function slider_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/slider/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/slider/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './assets/frontend/slider/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('slider_keyword')!=''){
								$tag_seo = $this->input->post('slider_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('slider_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
										'slider_post_oleh'=>$this->session->username,
										'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
										'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),
										'slider_post_hari'=>hari_ini(date('w')),
										'slider_post_tanggal'=>date('Y-m-d'),
										'slider_post_jam'=>date('H:i:s'),
										'slider_dibaca'=>'0',
										'slider_status'=>'publish',
										'slider_meta_desk'=>'non');
											}else{
												$data = array(
													'slider_post_oleh'=>$this->session->username,
													'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
													'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),
													'slider_post_hari'=>hari_ini(date('w')),
													'slider_post_tanggal'=>date('Y-m-d'),
													'slider_post_jam'=>date('H:i:s'),
													'slider_dibaca'=>'0',
													'slider_status'=>'publish',
													'slider_gambar'=>$hasil22['file_name'],
													'slider_meta_desk'=>'non');
												}
								$this->As_m->insert('slider',$data);
								redirect('aspanel/slider');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = 'active';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = '';
					$data['produk_category']   = '';
					$data['produk']   = '';
					$data['services']   = '';

					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/slider/v_tambahkan', $data);
				}
	}
	public function slider_update()
	{
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/slider/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/slider/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './assets/frontend/slider/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('slider_keyword')!=''){
						$tag_seo = $this->input->post('slider_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('slider_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'slider_post_oleh'=>$this->session->username,
											'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
											'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),
											'slider_desk'=>$this->input->post('slider_desk'),
											'slider_post_hari'=>hari_ini(date('w')),
											'slider_post_tanggal'=>date('Y-m-d'),
											'slider_post_jam'=>date('H:i:s'),
											'slider_meta_desk'=>$this->input->post('slider_meta_desk'),
											'slider_keyword'=>$tag);
											$where = array('slider_id' => $this->input->post('slider_id'));
											$this->db->update('slider', $data, $where);
						}else{
										$data = array(
											'slider_post_oleh'=>$this->session->username,
											'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
											'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),
											'slider_desk'=>$this->input->post('slider_desk'),
											'slider_post_hari'=>hari_ini(date('w')),
											'slider_post_tanggal'=>date('Y-m-d'),
											'slider_post_jam'=>date('H:i:s'),
											'slider_gambar'=>$hasil22['file_name'],
											'slider_meta_desk'=>$this->input->post('slider_meta_desk'),
											'slider_keyword'=>$tag);
											$where = array('slider_id' => $this->input->post('slider_id'));
											$_image = $this->db->get_where('slider',$where)->row();
											$query = $this->db->update('slider',$data,$where);
											if($query){
												unlink("assets/frontend/slider/".$_image->sliders_gambar);
											}

						}
						redirect('aspanel/slider');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('slider', array('slider_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('slider', array('slider_id' => $id, 'slider_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = 'active';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = '';

			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/slider/v_update', $data);
		}
	}
	function slider_delete_temp()
	{


			$data = array('slider_status'=>'delete');
			$where = array('slider_id' => $this->uri->segment(3));
			$this->db->update('slider', $data, $where);
			redirect('aspanel/slider');
	}
	function slider_restore()
	{

			$data = array('slider_status'=>'Publish');
			$where = array('slider_id' => $this->uri->segment(3));
			$this->db->update('slider', $data, $where);
			redirect('aspanel/slider_storage_bin');
	}
	public function slider_delete()
	{

			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('slider',['slider_id' => $id])->row();
			 $query = $this->db->delete('slider',['slider_id'=>$id]);
			if($query){
							 unlink("./bahan/foto_slider/".$_id->sliders_gambar);
		 }
		redirect('aspanel/slider_storage_bin');
	}
	/*	Bagian untuk slider - Penutup	*/

	/*	Bagian untuk Message - Pembuka	*/
	public function message()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = 'active';
		cek_session_akses ('products',$this->session->id_session);
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('products',array('products_status'=>'publish'),'products_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('products',array('products_post_oleh'=>$this->session->username,'products_status'=>'publish'),'products_id','DESC');
				}
				$this->load->view('backend/products/v_daftar', $data);
	}
	/*	Bagian untuk Message - Penutup	*/

	/*	Bagian untuk Bisnis - Pembuka	*/
	public function bisnis()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['bisnis']   = 'active';
			$data['produk']   = '';
			$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('bisnis',array('bisnis_status'=>'publish'),'bisnis_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('bisnis',array('bisnis_post_oleh'=>$this->session->username,'bisnis_status'=>'publish'),'bisnis_id','DESC');
				}
				$this->load->view('backend/bisnis/v_daftar', $data);
	}
	public function bisnis_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['bisnis']   = 'active';
			$data['produk']   = '';
			$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('bisnis',array('bisnis_status'=>'delete'),'bisnis_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('bisnis',array('bisnis_post_oleh'=>$this->session->username,'bisnis_status'=>'delete'),'bisnis_id','DESC');
				}
				$this->load->view('backend/bisnis/v_daftar_hapus', $data);
	}
	public function bisnis_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/linibisnis/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/linibisnis/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './assets/frontend/linibisnis/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('bisnis_keyword')!=''){
								$tag_seo = $this->input->post('bisnis_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('bisnis_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'bisnis_post_oleh'=>$this->session->username,
													'bisnis_judul'=>$this->db->escape_str($this->input->post('bisnis_judul')),
													'bisnis_judul_seo'=>$this->mylibrary->seo_title($this->input->post('bisnis_judul')),
													'bisnis_desk'=>$this->input->post('bisnis_desk'),
													'bisnis_post_hari'=>hari_ini(date('w')),
													'bisnis_post_tanggal'=>date('Y-m-d'),
													'bisnis_post_jam'=>date('H:i:s'),
													'bisnis_dibaca'=>'0',
													'bisnis_status'=>'publish',
													'bisnis_meta_desk'=>$this->input->post('bisnis_meta_desk'),
													'bisnis_keyword'=>$tag);
											}else{
												$data = array(
													'bisnis_post_oleh'=>$this->session->username,
													'bisnis_judul'=>$this->db->escape_str($this->input->post('bisnis_judul')),
													'bisnis_judul_seo'=>$this->mylibrary->seo_title($this->input->post('bisnis_judul')),
													'bisnis_desk'=>$this->input->post('bisnis_desk'),
													'bisnis_post_hari'=>hari_ini(date('w')),
													'bisnis_post_tanggal'=>date('Y-m-d'),
													'bisnis_post_jam'=>date('H:i:s'),
													'bisnis_dibaca'=>'0',
													'bisnis_status'=>'publish',
													'bisnis_gambar'=>$hasil22['file_name'],
													'bisnis_meta_desk'=>$this->input->post('bisnis_meta_desk'),
													'bisnis_keyword'=>$tag);
												}
								$this->As_m->insert('bisnis',$data);
								redirect('aspanel/bisnis');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = 'menu-open';
					$data['bisnis']   = 'active';
					$data['produk']   = '';
					$data['services']   = '';

					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/bisnis/v_tambahkan', $data);
				}
	}
	public function bisnis_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/linibisnis/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/linibisnis/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './assets/frontend/linibisnis/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('bisnis_keyword')!=''){
						$tag_seo = $this->input->post('bisnis_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('bisnis_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'bisnis_update_oleh'=>$this->session->username,
											'bisnis_judul'=>$this->db->escape_str($this->input->post('bisnis_judul')),
											'bisnis_judul_seo'=>$this->mylibrary->seo_title($this->input->post('bisnis_judul')),
											'bisnis_desk'=>$this->input->post('bisnis_desk'),
											'bisnis_update_hari'=>hari_ini(date('w')),
											'bisnis_update_tanggal'=>date('Y-m-d'),
											'bisnis_update_jam'=>date('H:i:s'),
											'bisnis_meta_desk'=>$this->input->post('bisnis_meta_desk'),
											'bisnis_keyword'=>$tag);
											$where = array('bisnis_id' => $this->input->post('bisnis_id'));
											$this->db->update('bisnis', $data, $where);
						}else{
										$data = array(
											'bisnis_update_oleh'=>$this->session->username,
											'bisnis_judul'=>$this->db->escape_str($this->input->post('bisnis_judul')),
											'bisnis_judul_seo'=>$this->mylibrary->seo_title($this->input->post('bisnis_judul')),
											'bisnis_desk'=>$this->input->post('bisnis_desk'),
											'bisnis_update_hari'=>hari_ini(date('w')),
											'bisnis_update_tanggal'=>date('Y-m-d'),
											'bisnis_update_jam'=>date('H:i:s'),
											'bisnis_gambar'=>$hasil22['file_name'],
											'bisnis_meta_desk'=>$this->input->post('bisnis_meta_desk'),
											'bisnis_keyword'=>$tag);
											$where = array('bisnis_id' => $this->input->post('bisnis_id'));
											$_image = $this->db->get_where('bisnis',$where)->row();
											$query = $this->db->update('bisnis',$data,$where);
											if($query){
												unlink("assets/frontend/linibisnis/".$_image->bisnis_gambar);
											}

						}
						redirect('aspanel/bisnis');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('bisnis', array('bisnis_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('bisnis', array('bisnis_id' => $id, 'bisnis_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = 'menu-open';
				$data['jamkerja_stat']   = '';
				$data['absen_stat']   = '';
				$data['dataabsen_stat']   = 'active';
				$data['cuti_stat']   = '';
				$data['gaji_stat']   = '';
				$data['pengumuman_stat']   = '';
				$data['konfig_stat']   = '';
				$data['produk_menu_open']   = 'menu-open';
				$data['bisnis']   = 'active';
				$data['produk']   = '';
				$data['services']   = '';
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/bisnis/v_update', $data);
		}
	}
	function bisnis_delete_temp()
	{

			$data = array('bisnis_status'=>'delete');
			$where = array('bisnis_id' => $this->uri->segment(3));
			$this->db->update('bisnis', $data, $where);
			redirect('aspanel/bisnis');
	}
	function bisnis_restore()
	{

			$data = array('bisnis_status'=>'Publish');
			$where = array('bisnis_id' => $this->uri->segment(3));
			$this->db->update('bisnis', $data, $where);
			redirect('aspanel/bisnis_storage_bin');
	}
	public function bisnis_delete()
	{

			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('bisnis',['bisnis_id' => $id])->row();
			 $query = $this->db->delete('bisnis',['bisnis_id'=>$id]);
			if($query){
							 unlink("./bahan/foto_products/".$_id->bisnis_gambar);
		 }
		redirect('aspanel/bisnis_storage_bin');
	}
	/*	Bagian untuk Bisnis - Penutup	*/

	/*	Bagian untuk products cat - Pembuka	*/
	public function products_cat()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['produk_category']   = 'active';
			$data['produk']   = '';
			$data['services']   = '';

				if ($this->session->level=='1'){
						cek_session_akses ('products_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('products_category',array('products_cat_status'=>'publish'),'products_cat_id','DESC');
				}else{
						cek_session_staff ('products_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('products_category',array('products_cat_post_oleh'=>$this->session->username,'products_cat_status'=>'publish'),'products_cat_id','DESC');
				}
				$this->load->view('backend/products_cat/v_daftar', $data);
	}
	public function products_cat_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['produk_category']   = 'active';
			$data['produk']   = '';
			$data['services']   = '';

				if ($this->session->level=='1'){
						cek_session_akses ('products_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('products_category',array('products_cat_status'=>'delete'),'products_cat_id','DESC');
				}else{
						cek_session_staff ('products_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('products_category',array('products_cat_post_oleh'=>$this->session->username,'products_cat_status'=>'delete'),'products_cat_id','DESC');
				}
				$this->load->view('backend/products_cat/v_daftar_hapus', $data);
	}
	public function products_cat_tambahkan()
	{

		if (isset($_POST['submit'])){

					$config['upload_path'] = 'bahan/foto_products/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './bahan/foto_products/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '60%';
					$config['width']= 150;
					$config['height']= 150;
					$config['new_image']= './bahan/foto_products/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('products_cat_keyword')!=''){
								$tag_seo = $this->input->post('products_cat_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('products_cat_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'products_cat_post_oleh'=>$this->session->username,
													'products_cat_judul'=>$this->db->escape_str($this->input->post('products_cat_judul')),
													'products_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_cat_judul')),
													'products_cat_desk'=>$this->input->post('products_cat_desk'),
													'products_cat_post_hari'=>hari_ini(date('w')),
													'products_cat_post_tanggal'=>date('Y-m-d'),
													'products_cat_post_jam'=>date('H:i:s'),
													'products_cat_dibaca'=>'0',
													'products_cat_status'=>'publish',
													'products_cat_meta_desk'=>$this->input->post('products_cat_meta_desk'),
													'products_cat_keyword'=>$tag);
											}else{
												$data = array(
													'products_cat_post_oleh'=>$this->session->username,
													'products_cat_judul'=>$this->db->escape_str($this->input->post('products_cat_judul')),
													'products_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_cat_judul')),
													'products_cat_desk'=>$this->input->post('products_cat_desk'),
													'products_cat_post_hari'=>hari_ini(date('w')),
													'products_cat_post_tanggal'=>date('Y-m-d'),
													'products_cat_post_jam'=>date('H:i:s'),
													'products_cat_dibaca'=>'0',
													'products_cat_status'=>'publish',
													'products_catgambar'=>$hasil22['file_name'],
													'products_cat_meta_desk'=>$this->input->post('products_cat_meta_desk'),
													'products_cat_keyword'=>$tag);
												}
								$this->As_m->insert('products_category',$data);
								redirect('aspanel/products_cat');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = 'menu-open';
					$data['produk_category']   = 'active';
					$data['produk']   = '';
					$data['services']   = '';

					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/products_cat/v_tambahkan', $data);
				}
	}
	public function products_cat_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'bahan/foto_products/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './bahan/foto_products/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '100%';
			$config['width']= 150;
			$config['height']= 150;
			$config['new_image']= './bahan/foto_products/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('products_cat_keyword')!=''){
						$tag_seo = $this->input->post('products_cat_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('products_cat_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'products_cat_update_oleh'=>$this->session->username,
											'products_cat_judul'=>$this->db->escape_str($this->input->post('products_cat_judul')),
											'products_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_cat_judul')),
											'products_cat_desk'=>$this->input->post('products_cat_desk'),
											'products_cat_update_hari'=>hari_ini(date('w')),
											'products_cat_update_tanggal'=>date('Y-m-d'),
											'products_cat_update_jam'=>date('H:i:s'),
											'products_cat_meta_desk'=>$this->input->post('products_cat_meta_desk'),
											'products_cat_keyword'=>$tag);
											$where = array('products_cat_id' => $this->input->post('products_cat_id'));
											$this->db->update('products_category', $data, $where);
						}else{
										$data = array(
											'products_cat_update_oleh'=>$this->session->username,
											'products_cat_judul'=>$this->db->escape_str($this->input->post('products_cat_judul')),
											'products_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_cat_judul')),
											'products_cat_desk'=>$this->input->post('products_cat_desk'),
											'products_cat_update_hari'=>hari_ini(date('w')),
											'products_cat_update_tanggal'=>date('Y-m-d'),
											'products_cat_update_jam'=>date('H:i:s'),
											'products_cat_gambar'=>$hasil22['file_name'],
											'products_cat_meta_desk'=>$this->input->post('products_cat_meta_desk'),
											'products_cat_keyword'=>$tag);
											$where = array('products_cat_id' => $this->input->post('products_cat_id'));
											$_image = $this->db->get_where('products_category',$where)->row();
											$query = $this->db->update('products_category',$data,$where);
											if($query){
												unlink("bahan/foto_products/".$_image->products_cat_gambar);
											}

						}
						redirect('aspanel/products_cat');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('products_category', array('products_cat_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('products_category', array('products_cat_id' => $id, 'products_cat_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = 'menu-open';
				$data['jamkerja_stat']   = '';
				$data['absen_stat']   = '';
				$data['dataabsen_stat']   = 'active';
				$data['cuti_stat']   = '';
				$data['gaji_stat']   = '';
				$data['pengumuman_stat']   = '';
				$data['konfig_stat']   = '';
				$data['produk_menu_open']   = 'menu-open';
				$data['produk_category']   = 'active';
				$data['produk']   = '';
				$data['services']   = '';
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/products_cat/v_update', $data);
		}
	}
	function products_cat_delete_temp()
	{
			$data = array('products_cat_status'=>'delete');
			$where = array('products_cat_id' => $this->uri->segment(3));
			$this->db->update('products_category', $data, $where);
			redirect('aspanel/products_cat');
	}
	function products_cat_restore()
	{
			$data = array('products_cat_status'=>'Publish');
			$where = array('products_cat_id' => $this->uri->segment(3));
			$this->db->update('products_category', $data, $where);
			redirect('aspanel/products_cat_storage_bin');
	}
	public function products_cat_delete()
	{
			cek_session_akses ('products_cat',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('products_category',['products_cat_id' => $id])->row();
			 $query = $this->db->delete('products_category',['products_cat_id'=>$id]);
			if($query){
							 unlink("./bahan/foto_products/".$_id->products_cat_gambar);
		 }
		redirect('aspanel/products_cat_storage_bin');
	}
	/*	Bagian untuk Product Category - Penutup	*/

	/*	Bagian untuk Product - Pembuka	*/
	public function products()
	{
		 $data['karyawan_menu_open']   = '';
 		$data['home_stat']   = '';
 		$data['identitas_stat']   = '';
 		$data['profil_stat']   = '';
 		$data['sliders_stat']   = '';
 		$data['products_stat']   = '';
 		$data['cat_products_stat']   = '';
 		$data['slider_stat']   = '';
 		$data['blogs_stat']   = '';
 		$data['message_stat']   = '';
 		$data['gallery_stat']   = '';
 		$data['kehadiran_menu_open']   = '';
 			$data['jamkerja_stat']   = '';
 			$data['absen_stat']   = '';
 			$data['dataabsen_stat']   = '';
 			$data['cuti_stat']   = '';
 			$data['gaji_stat']   = '';
 			$data['pengumuman_stat']   = '';
 			$data['konfig_stat']   = '';
 			$data['produk_menu_open']   = 'menu-open';
 			$data['produk_category']   = '';
 			$data['produk']   = 'active';
 			$data['services']   = '';
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('products',array('products_status'=>'publish'),'products_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('products',array('products_post_oleh'=>$this->session->username,'products_status'=>'publish'),'products_id','DESC');
				}
				$this->load->view('backend/products/v_daftar', $data);
	}
	public function products_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
		$data['produk_menu_open']   = 'menu-open';
		$data['produk_category']   = '';
		$data['produk']   = 'active';
		$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('products',array('products_status'=>'delete'),'products_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('products',array('products_post_oleh'=>$this->session->username,'products_status'=>'delete'),'products_id','DESC');
				}
				$this->load->view('backend/products/v_daftar_hapus', $data);
	}
	public function products_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/produk/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';

					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/produk/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './assets/frontend/produk/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('products_keyword')!=''){
								$tag_seo = $this->input->post('products_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('products_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']=='' ){
									$data = array(
													'products_post_oleh'=>$this->session->username,
													'products_judul'=>$this->db->escape_str($this->input->post('products_judul')),
													'products_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_judul')),
													'products_desk'=>$this->input->post('products_desk'),
													'products_cat_id'=>$this->input->post('products_cat_id'),
													'products_post_hari'=>hari_ini(date('w')),
													'products_post_tanggal'=>date('Y-m-d'),
													'products_post_jam'=>date('H:i:s'),
													'products_dibaca'=>'0',
													'products_status'=>'publish',
													'products_meta_desk'=>$this->input->post('products_meta_desk'),
													'products_keyword'=>$tag);

												}else {
												$data = array(
													'products_post_oleh'=>$this->session->username,
													'products_judul'=>$this->db->escape_str($this->input->post('products_judul')),
													'products_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_judul')),
													'products_desk'=>$this->input->post('products_desk'),
													'products_cat_id'=>$this->input->post('products_cat_id'),
													'products_post_hari'=>hari_ini(date('w')),
													'products_post_tanggal'=>date('Y-m-d'),
													'products_post_jam'=>date('H:i:s'),
													'products_dibaca'=>'0',
													'products_status'=>'publish',
													'products_gambar'=>$hasil22['file_name'],
													'products_meta_desk'=>$this->input->post('products_meta_desk'),
													'products_keyword'=>$tag);
												}
								$this->As_m->insert('products',$data);
								redirect('aspanel/products');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

					$data['produk_menu_open']   = 'menu-open';
		 			$data['produk_category']   = '';
		 			$data['produk']   = 'active';
		 			$data['services']   = '';
					$data['records'] = $this->Crud_m->view_ordering('products_category','products_cat_id','DESC');
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/products/v_tambahkan', $data);
				}
	}
	public function products_update()
	{
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/produk/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/produk/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './assets/frontend/produk/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('products_keyword')!=''){
						$tag_seo = $this->input->post('products_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('products_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'products_update_oleh'=>$this->session->username,
											'products_judul'=>$this->db->escape_str($this->input->post('products_judul')),
											'products_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_judul')),
											'products_desk'=>$this->input->post('products_desk'),
											'products_cat_id'=>$this->input->post('products_cat_id'),
											'products_update_hari'=>hari_ini(date('w')),
											'products_update_tanggal'=>date('Y-m-d'),
											'products_update_jam'=>date('H:i:s'),
											'products_meta_desk'=>$this->input->post('products_meta_desk'),
											'products_keyword'=>$tag);
											$where = array('products_id' => $this->input->post('products_id'));
							 				$this->db->update('products', $data, $where);
						}else{
										$data = array(
											'products_update_oleh'=>$this->session->username,
											'products_judul'=>$this->db->escape_str($this->input->post('products_judul')),
											'products_judul_seo'=>$this->mylibrary->seo_title($this->input->post('products_judul')),
											'products_desk'=>$this->input->post('products_desk'),
											'products_cat_id'=>$this->input->post('products_cat_id'),
											'products_update_hari'=>hari_ini(date('w')),
											'products_update_tanggal'=>date('Y-m-d'),
											'products_update_jam'=>date('H:i:s'),
											'products_gambar'=>$hasil22['file_name'],
											'products_meta_desk'=>$this->input->post('products_meta_desk'),
											'products_keyword'=>$tag);
											$where = array('products_id' => $this->input->post('products_id'));
											$_image = $this->db->get_where('products',$where)->row();
											$query = $this->db->update('products',$data,$where);
											if($query){
												unlink("assets/frontend/produk/".$_image->products_gambar);
											}
						}
						redirect('aspanel/products');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('products', array('products_judul_seo' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('products', array('products_judul_seo' => $id, 'products_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

			$data['produk_menu_open']   = 'menu-open';
 			$data['produk_category']   = '';
 			$data['produk']   = 'active';
 			$data['services']   = '';
			$data['records'] = $this->Crud_m->view_ordering('products_category','products_cat_id','ASC');
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/products/v_update', $data);
		}
	}
	function products_delete_temp()
	{
			$data = array('products_status'=>'delete');
      $where = array('products_id' => $this->uri->segment(3));
			$this->db->update('products', $data, $where);
			redirect('aspanel/products');
	}
	function products_restore()
	{
			$data = array('products_status'=>'Publish');
      $where = array('products_id' => $this->uri->segment(3));
			$this->db->update('products', $data, $where);
			redirect('aspanel/products_storage_bin');
	}
	public function products_delete()
	{
			cek_session_akses ('products',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('products',['products_id' => $id])->row();
			 $query = $this->db->delete('products',['products_id'=>$id]);
		 	if($query){
							 unlink("./assets/frontend/produk/".$_id->products_gambar);
		 }
		redirect('aspanel/products_storage_bin');
	}

	/*	Bagian untuk Product - Penutup	*/


	/*	Bagian untuk Dat Karyawan - Pembuka	*/
	public function data_karyawan()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = 'active';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'publish'),'id_user','DESC');
				}elseif($this->session->level=='2'){
					$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'publish','level'=>'3'),'id_user','DESC');
				}else{
					redirect('aspanel/home');
				}
				$this->load->view('backend/data_karyawan/v_daftar', $data);
	}
	public function data_karyawan_storage_bin()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = 'active';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

			if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
				}elseif($this->session->level=='2'){
					$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
				}else{
					redirect('aspanel/home');
				}
			$this->load->view('backend/data_karyawan/v_daftar_hapus', $data);
	}
	public function data_karyawan_tambahkan()
	{

		if (isset($_POST['submit'])){

					$config['upload_path'] = 'bahan/foto_karyawan/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';

					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './bahan/foto_karyawan/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['width']= 800;
					$config['height']= 800;
					$config['new_image']= './bahan/foto_karyawan/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();


												if ($hasil22['file_name']==''){

												$data = array(
													'username' => $this->input->post('username'),
													'email' => $this->input->post('email'),
													'password' => sha1($this->input->post('password')),
													'user_status' => '1',
													'level' => $this->input->post('user_status'),
													'user_stat' => 'publish',
													'user_post_hari'=>hari_ini(date('w')),
													'user_post_tanggal'=>date('Y-m-d'),
													'user_post_jam'=>date('H:i:s'),
													'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
													'nama' => $this->input->post('nama'));
												}else {
												$data = array(
													'username' => $this->input->post('username'),
													'email' => $this->input->post('email'),
													'password' => sha1($this->input->post('password')),
													'user_status' => '1',
													'level' => $this->input->post('user_status'),
													'user_stat' => 'publish',
													'user_post_hari'=>hari_ini(date('w')),
													'user_post_tanggal'=>date('Y-m-d'),
													'user_post_jam'=>date('H:i:s'),
													'user_gambar'=>$hasil22['file_name'],
													'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
													'nama' => $this->input->post('nama'));
												}
											$id_pelanggan = $this->Crud_m->tambah_user($data);
											$data_user_detail = array(
													'id_user' => $id_pelanggan,
													'user_detail_jekel' => $this->input->post('user_detail_jekel'),
													'user_detail_agama' => $this->input->post('user_detail_agama'),
													'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
													'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
													'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
													'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
													'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
													'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
													'user_detail_divisi' => $this->input->post('user_detail_divisi'),
													'user_detail_ktp' => $this->input->post('user_detail_ktp'));
											$this->Crud_m->tambah_user_detail($data_user_detail);
											redirect('aspanel/data_karyawan');
				}else{
					$data['karyawan_menu_open']   = 'menu-open';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = 'active';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = 'active';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

					$data['produk_menu_open']   = '';
		 			$data['produk_category']   = '';
		 			$data['produk']   = '';
		 			$data['services']   = '';

					if ($this->session->level=='1'){
						$data['records'] = $this->Crud_m->view_ordering('user_level','user_level_id','DESC');
						$data['records_divisi'] = $this->Crud_m->view_ordering('divisi','divisi_id','DESC');
						$data['records_kel'] = $this->Crud_m->view_ordering('user_kelamin','user_kelamin_id','DESC');
						$data['records_agama'] = $this->Crud_m->view_ordering('user_agama','user_agama_id','ASC');
						$data['records_kawin'] = $this->Crud_m->view_ordering('user_perkawinan','user_perkawinan_id','ASC');

						$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
						}elseif($this->session->level=='2'){
							$data['records'] = $this->Crud_m->view_where_ordering('user_level',array('user_level_id'=>'3'),'user_level_id','DESC');
							$data['records_divisi'] = $this->Crud_m->view_ordering('divisi','divisi_id','DESC');
							$data['records_kel'] = $this->Crud_m->view_ordering('user_kelamin','user_kelamin_id','DESC');
							$data['records_agama'] = $this->Crud_m->view_ordering('user_agama','user_agama_id','ASC');
							$data['records_kawin'] = $this->Crud_m->view_ordering('user_perkawinan','user_perkawinan_id','ASC');
							$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
						}else{
							redirect('aspanel/home');
						}
					$this->load->view('backend/data_karyawan/v_tambahkan', $data);
				}
	}
	public function data_karyawan_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'bahan/foto_karyawan/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './bahan/foto_karyawan/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['width']= 800;
			$config['height']= 800;
			$config['new_image']= './bahan/foto_karyawan/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			$pass = sha1($this->input->post('password'));


						if ($hasil22['file_name']=='' AND $this->input->post('password')==''){
							$data = array(
								'username' => $this->input->post('username'),
								'email' => $this->input->post('email'),
								'level' => $this->input->post('user_status'),
								'user_update_hari'=>hari_ini(date('w')),
								'user_update_tanggal'=>date('Y-m-d'),
								'user_update_jam'=>date('H:i:s'),
								'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
								'nama' => $this->input->post('nama'));


							$data2 = array(
							'id_user' => $this->input->post('id_user'),
							'user_detail_jekel' => $this->input->post('user_detail_jekel'),
							'user_detail_agama' => $this->input->post('user_detail_agama'),
							'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
							'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
							'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
							'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
							'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
							'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
							'user_detail_divisi' => $this->input->post('user_detail_divisi'),
							'user_detail_ktp' => $this->input->post('user_detail_ktp'));

							$where = array('id_user' => $this->input->post('id_user'));
							$id = $this->db->update('user',$data,$where);
							$id2 = $this->db->update('user_detail',$data2,$where);


						}else if($this->input->post('password')==''){
								$data = array(
									'username' => $this->input->post('username'),
									'email' => $this->input->post('email'),
									'level' => $this->input->post('user_status'),
									'user_update_hari'=>hari_ini(date('w')),
									'user_update_tanggal'=>date('Y-m-d'),
									'user_update_jam'=>date('H:i:s'),
									'user_gambar'=>$hasil22['file_name'],
									'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
									'nama' => $this->input->post('nama'));


								$data2 = array(
								'id_user' => $this->input->post('id_user'),
								'user_detail_jekel' => $this->input->post('user_detail_jekel'),
								'user_detail_agama' => $this->input->post('user_detail_agama'),
								'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
								'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
								'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
								'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
								'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
								'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
								'user_detail_divisi' => $this->input->post('user_detail_divisi'),
								'user_detail_ktp' => $this->input->post('user_detail_ktp'));

								$where = array('id_user' => $this->input->post('id_user'));
								$_image = $this->db->get_where('user',$where)->row();
								$id2 = $this->db->update('user_detail',$data2,$where);
								$query = $this->db->update('user',$data,$where);
								if($query){
									unlink("bahan/foto_karyawan/".$_image->user_gambar);
								}

							}else if($hasil22['file_name']==''){
									$data = array(
										'username' => $this->input->post('username'),
										'email' => $this->input->post('email'),
										'password' => $pass,
										'level' => $this->input->post('user_status'),
										'user_update_hari'=>hari_ini(date('w')),
										'user_update_tanggal'=>date('Y-m-d'),
										'user_update_jam'=>date('H:i:s'),
										'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
										'nama' => $this->input->post('nama'));


									$data2 = array(
									'id_user' => $this->input->post('id_user'),
									'user_detail_jekel' => $this->input->post('user_detail_jekel'),
									'user_detail_agama' => $this->input->post('user_detail_agama'),
									'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
									'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
									'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
									'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
									'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
									'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
									'user_detail_divisi' => $this->input->post('user_detail_divisi'),
									'user_detail_ktp' => $this->input->post('user_detail_ktp'));

									$where = array('id_user' => $this->input->post('id_user'));
									$id = $this->db->update('user',$data,$where);
									$id2 = $this->db->update('user_detail',$data2,$where);


								}else{
							$data = array(
								'username' => $this->input->post('username'),
								'email' => $this->input->post('email'),
								'password' => sha1($this->input->post('password')),
								'level' => $this->input->post('user_status'),
								'user_update_hari'=>hari_ini(date('w')),
								'user_update_tanggal'=>date('Y-m-d'),
								'user_update_jam'=>date('H:i:s'),
								'user_gambar'=>$hasil22['file_name'],
								'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
								'nama' => $this->input->post('nama'));

								$data2 = array(
								'id_user' => $this->input->post('id_user'),
								'user_detail_jekel' => $this->input->post('user_detail_jekel'),
								'user_detail_agama' => $this->input->post('user_detail_agama'),
								'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
								'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
								'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
								'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
								'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
								'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
								'user_detail_divisi' => $this->input->post('user_detail_divisi'),
								'user_detail_ktp' => $this->input->post('user_detail_ktp'));

								$where = array('id_user' => $this->input->post('id_user'));
								$_image = $this->db->get_where('user',$where)->row();

								$id2 = $this->db->update('user_detail',$data2,$where);
								$query = $this->db->update('user',$data,$where);
								if($query){
									unlink("bahan/foto_karyawan/".$_image->user_gambar);
								}
							}
						redirect('aspanel/data_karyawan');
		}else{
			if ($this->session->level=='1'){
						 $proses = $this->Crud_m->view_join_where2('user','user_detail','id_user',array('id_session' => $id))->row_array();
				}else{
						$proses = $this->Crud_m->view_join_where2('user','user_detail','id_user',array('id_session' => $id))->row_array();
				}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = 'menu-open';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = 'active';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';

			$data['records'] = $this->Crud_m->view_ordering('user_level','user_level_id','DESC');
			$data['records_divisi'] = $this->Crud_m->view_ordering('divisi','divisi_id','DESC');
			$data['records_kel'] = $this->Crud_m->view_ordering('user_kelamin','user_kelamin_id','DESC');
			$data['records_agama'] = $this->Crud_m->view_ordering('user_agama','user_agama_id','ASC');
			$data['records_kawin'] = $this->Crud_m->view_ordering('user_perkawinan','user_perkawinan_id','ASC');
			$this->load->view('backend/data_karyawan/v_update', $data);
		}
	}
	function data_karyawan_delete_temp()
	{

			$data = array('user_stat'=>'delete');
			$where = array('id_user' => $this->uri->segment(3));
			$this->db->update('user', $data, $where);
			redirect('aspanel/data_karyawan');
	}
	function data_karyawan_restore()
	{

			$data = array('user_stat'=>'Publish');
			$where = array('id_user' => $this->uri->segment(3));
			$this->db->update('user', $data, $where);
			redirect('aspanel/data_karyawan_storage_bin');
	}
	public function data_karyawan_delete()
	{

			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('user',['id_user' => $id])->row();
			$query = $this->db->delete('user',['id_user'=> $id]);
			$_id2 = $this->db->get_where('user_detail',['id_user' => $id])->row();
			$query2 = $this->db->delete('user_detail',['id_user'=> $id]);
			if($query){
							 unlink("./bahan/foto_karyawan/".$_id->user_gambar);
		 }
		redirect('aspanel/data_karyawan_storage_bin');
	}
	/*	Bagian untuk Data Karyawan - Penutup	*/





	/*	Bagian untuk products cat - Pembuka	*/
	public function services()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = 'active';
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_status'=>'publish'),'services_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_post_oleh'=>$this->session->username,'services_status'=>'publish'),'services_id','DESC');
				}
				$this->load->view('backend/services/v_daftar', $data);
	}
	public function services_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = 'active';
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_status'=>'delete'),'services_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_post_oleh'=>$this->session->username,'servicest_status'=>'delete'),'services_id','DESC');
				}
				$this->load->view('backend/services/v_daftar_hapus', $data);
	}
	public function services_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'bahan/foto_products/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './bahan/foto_products/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './bahan/foto_products/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('services_keyword')!=''){
								$tag_seo = $this->input->post('services_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('services_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'services_post_oleh'=>$this->session->username,
													'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
													'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
													'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
													'bisnis_id'=>$this->input->post('bisnis_id'),
													'services_desk'=>$this->input->post('services_desk'),
													'services_post_hari'=>hari_ini(date('w')),
													'services_post_tanggal'=>date('Y-m-d'),
													'services_post_jam'=>date('H:i:s'),
													'services_dibaca'=>'0',
													'services_status'=>'publish',
													'services_meta_desk'=>$this->input->post('services_meta_desk'),
													'services_keyword'=>$tag);
											}else{
												$data = array(
													'services_post_oleh'=>$this->session->username,
													'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
													'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
													'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
													'bisnis_id'=>$this->input->post('bisnis_id'),
													'services_desk'=>$this->input->post('services_desk'),
													'services_post_hari'=>hari_ini(date('w')),
													'services_post_tanggal'=>date('Y-m-d'),
													'services_post_jam'=>date('H:i:s'),
													'services_dibaca'=>'0',
													'services_status'=>'publish',
													'services_gambar'=>$hasil22['file_name'],
													'services_meta_desk'=>$this->input->post('services_meta_desk'),
													'services_keyword'=>$tag);
												}
								$this->As_m->insert('services',$data);
								redirect('aspanel/services');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = 'menu-open';
					$data['produk_category']   = '';
					$data['produk']   = '';
					$data['services']   = 'active';
					$data['records'] = $this->Crud_m->view_ordering('bisnis','bisnis_id','DESC');
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/services/v_tambahkan', $data);
				}
	}
	public function services_update()
	{
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'bahan/foto_products/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './bahan/foto_products/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './bahan/foto_products/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('services_keyword')!=''){
						$tag_seo = $this->input->post('services_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('services_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'services_update_oleh'=>$this->session->username,
											'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
											'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
											'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
											'bisnis_id'=>$this->input->post('bisnis_id'),
											'services_desk'=>$this->input->post('services_desk'),
											'services_update_hari'=>hari_ini(date('w')),
											'services_update_tanggal'=>date('Y-m-d'),
											'services_update_jam'=>date('H:i:s'),
											'services_meta_desk'=>$this->input->post('services_meta_desk'),
											'services_keyword'=>$tag);
											$where = array('services_id' => $this->input->post('services_id'));
											$this->db->update('services', $data, $where);
						}else{
										$data = array(
											'services_update_oleh'=>$this->session->username,
											'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
											'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
											'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
											'bisnis_id'=>$this->input->post('bisnis_id'),
											'services_desk'=>$this->input->post('services_desk'),
											'services_update_hari'=>hari_ini(date('w')),
											'services_update_tanggal'=>date('Y-m-d'),
											'services_update_jam'=>date('H:i:s'),
											'services_gambar'=>$hasil22['file_name'],
											'services_meta_desk'=>$this->input->post('services_meta_desk'),
											'services_keyword'=>$tag);
											$where = array('services_id' => $this->input->post('services_id'));
											$_image = $this->db->get_where('services',$where)->row();
											$query = $this->db->update('services',$data,$where);
											if($query){
												unlink("bahan/foto_products/".$_image->services_gambar);
											}

						}
						redirect('aspanel/services');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('services', array('services_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('services', array('services_id' => $id, 'services_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = '';
				$data['jamkerja_stat']   = '';
				$data['absen_stat']   = '';
				$data['dataabsen_stat']   = '';
				$data['cuti_stat']   = '';
				$data['gaji_stat']   = '';
				$data['pengumuman_stat']   = '';
				$data['konfig_stat']   = '';
				$data['produk_menu_open']   = 'menu-open';
				$data['produk_category']   = '';
				$data['produk']   = '';
				$data['services']   = 'active';
			$data['records'] = $this->Crud_m->view_ordering('bisnis','bisnis_id','DESC');
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/services/v_update', $data);
		}
	}
	function services_delete_temp()
	{
			$data = array('services_status'=>'delete');
			$where = array('services_id' => $this->uri->segment(3));
			$this->db->update('services', $data, $where);
			redirect('aspanel/services');
	}
	function services_restore()
	{
			$data = array('services_status'=>'Publish');
			$where = array('services_id' => $this->uri->segment(3));
			$this->db->update('services', $data, $where);
			redirect('aspanel/services_storage_bin');
	}
	public function services_delete()
	{
			cek_session_akses ('services',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('services',['services_id' => $id])->row();
			 $query = $this->db->delete('services',['services_id'=>$id]);
			if($query){
							 unlink("./bahan/foto_products/".$_id->bisnis_gambar);
		 }
		redirect('aspanel/services_storage_bin');
	}
	/*	Bagian untuk Product Category - Penutup	*/



	/*	Bagian untuk Divisi - Pembuka	*/
	public function divisi()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = 'active';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';
				if ($this->session->level=='1' OR $this->session->level=='2'){
						$data['record'] = $this->Crud_m->view_where_ordering('divisi',array('divisi_status'=>'publish'),'divisi_id','DESC');
				}else{
					redirect('aspanel/home');
				}
				$this->load->view('backend/divisi/v_daftar', $data);
	}
	public function divisi_storage_bin()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = 'active';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';
		cek_session_akses ('divisi',$this->session->id_session);
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('divisi',array('divisi_status'=>'delete'),'divisi_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('divisi',array('divisi_post_oleh'=>$this->session->username,'divisi_status'=>'delete'),'divisi_id','DESC');
				}
				$this->load->view('backend/divisi/v_daftar_hapus', $data);
	}
	public function divisi_tambahkan()
	{
		cek_session_akses('divisi',$this->session->id_session);
		if (isset($_POST['submit'])){

									$data = array(
													'divisi_post_oleh'=>$this->session->username,
													'divisi_judul'=>$this->db->escape_str($this->input->post('divisi_judul')),
													'divisi_judul_seo'=>$this->mylibrary->seo_title($this->input->post('divisi_judul')),
													'divisi_desk'=>$this->input->post('divisi_desk'),
													'divisi_post_hari'=>hari_ini(date('w')),
													'divisi_post_tanggal'=>date('Y-m-d'),
													'divisi_post_jam'=>date('H:i:s'),
													'divisi_dibaca'=>'0',
													'divisi_status'=>'publish',
													'divisi_meta_desk'=>$this->input->post('divisi_meta_desk'));

								$this->As_m->insert('divisi',$data);
								redirect('aspanel/divisi');
				}else{
					$data['karyawan_menu_open']   = 'menu-open';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['cat_products_stat']   = 'active';
					$data['message_stat']   = 'active';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
					$data['produk_menu_open']   = '';
		 			$data['produk_category']   = '';
		 			$data['produk']   = '';
		 			$data['services']   = '';
					cek_session_akses ('divisi',$this->session->id_session);
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/divisi/v_tambahkan', $data);
				}
	}
	public function divisi_update()
	{
		cek_session_akses('divisi',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
										$data = array(
											'divisi_update_oleh'=>$this->session->username,
											'divisi_judul'=>$this->db->escape_str($this->input->post('divisi_judul')),
											'divisi_judul_seo'=>$this->mylibrary->seo_title($this->input->post('divisi_judul')),
											'divisi_desk'=>$this->input->post('divisi_desk'),
											'divisi_update_hari'=>hari_ini(date('w')),
											'divisi_update_tanggal'=>date('Y-m-d'),
											'divisi_update_jam'=>date('H:i:s'),
											'divisi_meta_desk'=>$this->input->post('divisi_meta_desk'));
											$where = array('divisi_id' => $this->input->post('divisi_id'));
							 				$this->db->update('divisi', $data, $where);

						redirect('aspanel/divisi');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('divisi', array('divisi_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('divisi', array('divisi_id' => $id, 'divisi_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = 'menu-open';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = 'active';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';
			cek_session_akses ('divisi',$this->session->id_session);
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/divisi/v_update', $data);
		}
	}
	function divisi_delete_temp()
	{
      cek_session_akses ('divisi',$this->session->id_session);
			$data = array('divisi_status'=>'delete');
      $where = array('divisi_id' => $this->uri->segment(3));
			$this->db->update('divisi', $data, $where);
			redirect('aspanel/divisi');
	}
	function divisi_restore()
	{
      cek_session_akses ('divisi',$this->session->id_session);
			$data = array('divisi_status'=>'Publish');
      $where = array('divisi_id' => $this->uri->segment(3));
			$this->db->update('divisi', $data, $where);
			redirect('aspanel/divisi_storage_bin');
	}
	public function divisi_delete()
	{
			cek_session_akses ('divisi',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('divisi',['divisi_id' => $id])->row();
			 $query = $this->db->delete('divisi',['divisi_id'=>$id]);
		 	if($query){
							 unlink("./bahan/foto_products/".$_id->divisi_gambar);
		 }
		redirect('aspanel/divisi_storage_bin');
	}
	/*	Bagian untuk Divisi - Penutup	*/

	/*	Bagian untuk Blogs - Pembuka	*/
	public function blogs()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = 'active';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
		$data['jamkerja_stat']   = '';
		$data['absen_stat']   = '';
		$data['dataabsen_stat']   = '';
		$data['cuti_stat']   = '';
		$data['gaji_stat']   = '';
		$data['pengumuman_stat']   = '';
		$data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_status'=>'publish'),'blogs_id','DESC');
				}elseif ($this->session->level=='2'){
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_status'=>'publish'),'blogs_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_post_oleh'=>$this->session->username,'blogs_status'=>'publish'),'blogs_id','DESC');
				}
				$this->load->view('backend/blogs/v_daftar', $data);
	}
	public function blogs_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['products_stat']   = '';
		$data['cat_products_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = 'active';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
		$data['jamkerja_stat']   = '';
		$data['absen_stat']   = '';
		$data['dataabsen_stat']   = '';
		$data['cuti_stat']   = '';
		$data['gaji_stat']   = '';
		$data['pengumuman_stat']   = '';
		$data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_status'=>'delete'),'blogs_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_post_oleh'=>$this->session->username,'blogs_status'=>'delete'),'blogs_id','DESC');
				}
				$this->load->view('backend/blogs/v_daftar_hapus', $data);
	}
	public function blogs_tambahkan()
	{

		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/blogs/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/blogs/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['width']= 700;
					$config['height']= 475;
					$config['new_image']= './assets/frontend/blogs/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('blogs_keyword')!=''){
								$tag_seo = $this->input->post('blogs_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('blogs_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'blogs_post_oleh'=>$this->session->username,
													'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
													'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
													'blogs_desk'=>$this->input->post('blogs_desk'),
													'blogs_post_hari'=>hari_ini(date('w')),
													'blogs_post_tanggal'=>date('Y-m-d'),
													'blogs_post_jam'=>date('H:i:s'),
													'blogs_dibaca'=>'0',
													'blogs_status'=>'publish',
													'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
													'blogs_keyword'=>$tag);
											}else{
												$data = array(
													'blogs_post_oleh'=>$this->session->username,
													'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
													'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
													'blogs_desk'=>$this->input->post('blogs_desk'),
													'blogs_post_hari'=>hari_ini(date('w')),
													'blogs_post_tanggal'=>date('Y-m-d'),
													'blogs_post_jam'=>date('H:i:s'),
													'blogs_dibaca'=>'0',
													'blogs_status'=>'publish',
													'blogs_gambar'=>$hasil22['file_name'],
													'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
													'blogs_keyword'=>$tag);
												}
								$this->As_m->insert('blogs',$data);
								redirect('aspanel/blogs');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['products_stat']   = '';
					$data['cat_products_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = 'active';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = '';
					$data['produk_category']   = '';
					$data['produk']   = '';
					$data['services']   = '';

					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/blogs/v_tambahkan', $data);
				}
	}
	public function blogs_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/blogs/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/blogs/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['width']= 700;
			$config['height']= 475;
			$config['new_image']= './assets/frontend/blogs/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('blogs_keyword')!=''){
						$tag_seo = $this->input->post('blogs_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('blogs_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'blogs_update_oleh'=>$this->session->username,
											'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
											'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
											'blogs_desk'=>$this->input->post('blogs_desk'),
											'blogs_update_hari'=>hari_ini(date('w')),
											'blogs_update_tanggal'=>date('Y-m-d'),
											'blogs_update_jam'=>date('H:i:s'),
											'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
											'blogs_keyword'=>$tag);
											$where = array('blogs_id' => $this->input->post('blogs_id'));
											$this->db->update('blogs', $data, $where);
						}else{
										$data = array(
											'blogs_update_oleh'=>$this->session->username,
											'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
											'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
											'blogs_desk'=>$this->input->post('blogs_desk'),
											'blogs_update_hari'=>hari_ini(date('w')),
											'blogs_update_tanggal'=>date('Y-m-d'),
											'blogs_update_jam'=>date('H:i:s'),
											'blogs_gambar'=>$hasil22['file_name'],
											'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
											'blogs_keyword'=>$tag);
											$where = array('blogs_id' => $this->input->post('blogs_id'));
											$_image = $this->db->get_where('blogs',$where)->row();
											$query = $this->db->update('blogs',$data,$where);
											if($query){
												unlink("assets/frontend/blogs/".$_image->blogs_gambar);
											}

						}
						redirect('aspanel/blogs');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('blogs', array('blogs_id' => $id))->row_array();
			}elseif($this->session->level=='2'){
				$proses = $this->As_m->edit('blogs', array('blogs_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('blogs', array('blogs_id' => $id, 'blogs_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['products_stat']   = '';
			$data['cat_products_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = 'active';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = '';

			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/blogs/v_update', $data);
		}
	}
	function blogs_delete_temp()
	{

			$data = array('blogs_status'=>'delete');
			$where = array('blogs_id' => $this->uri->segment(3));
			$this->db->update('blogs', $data, $where);
			redirect('aspanel/blogs');
	}
	function blogs_restore()
	{
			$data = array('blogs_status'=>'Publish');
			$where = array('blogs_id' => $this->uri->segment(3));
			$this->db->update('blogs', $data, $where);
			redirect('aspanel/blogs_storage_bin');
	}
	public function blogs_delete()
	{
			cek_session_akses ('blogs',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('blogs',['blogs_id' => $id])->row();
			 $query = $this->db->delete('blogs',['blogs_id'=>$id]);
			if($query){
							 unlink("./assets/frontend/blogs/".$_id->blogs_gambar);
		 }
		redirect('aspanel/blogs_storage_bin');
	}
	/*	Bagian untuk Blogs - Penutup	*/



}