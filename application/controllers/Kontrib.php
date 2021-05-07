<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kontrib extends CI_Controller {

    function __construct()
  {
    parent::__construct();
    /* memanggil model untuk ditampilkan pada masing2 modul */
    $this->load->model(array('Crud_m'));
    /* memanggil function dari masing2 model yang akan digunakan */
  }

  public function index()
  {
    $data['status']   = '';
    $data['status_produk']   = '';
    $data['status_lini']   = 'active';
    $data['judul']   = 'Kesatriaan Entrepreneur Indonesia';
    $data['deskripsi']   = '<p style="text-align:justify;">Kesatriaan Entrepreneur Indonesia (KEI)  yang berpusat di Joglo Tumiyono, Desa Ngerangan, Kabupaten Klaten ini merupakan wadah komunitas bagi petani dan peternak milenial untuk meningkatkan pengetahuan dan wawasannya melalui pengadaan workshop secara berkesinambungan dan membantu mendapatkan pendanaan dari perbankan dan lembaga keuangan.  Widodo Makmur Perkasa bertindak sebagai off taker dari produk yang dihasilkan.</p>
    <p style="text-align:justify;">Kesatriaan Entreprenenur Indonesia konsen dalam membangun sumberdaya manusia yang memiliki jiwa kepemimpinan di masa depan. Mencetak entrepreneur muda untuk menopang kemandirian perekonomian nasional . Desa harus menjadi titik tolak dalam membangun dan menciptakan kemakmuran bangsa. </p>';
    $data['posts_bisnis'] = $this->Crud_m->view_where_orders('bisnis','bisnis_status','bisnis_id','ASC');
    $this->load->view('fronts/kontrib/v_kontrib',$data);
  }

  public function kemitraan()
  {
    $data['status']   = '';
    $data['status_produk']   = '';
    $data['status_lini']   = 'active';
    $data['judul']   = 'Kemitraan Sapi ';
    $data['deskripsi']   = '<p style="text-align:justify;">Gerakan kemitraan peternak sapi potong Indonesia pertama kali digulirkan oleh PT Pasir Tengah sebagai bentuk dukungan terhadap produk pemerintah dalam peningkatan jumlah stok sapi dalam negeri dengan melibatkan para peternak sebagai mitra. Program ini diinagurasi oleh wakil gubernur Jawa Tengah, di Wonogiri pada tahun 2017. Program kemitraan ini menyinergi kan berbagai stakeholder diantaranya perbankan sebagai penyedia modal, Perusahaan Asuransi sebagai penjamin, Peternak sebagai pelaku dan mitra PT Pasir Tengah. Berikut peran PT Pasir Tengah:</p>
    <p style="text-align:justify;">Peran PT Pasir Tengah : 1. Pemberi referensi peternak pada Bank atau lembaga keuangan 2. Penyedia bibit sapi 3. Penyedia pakan konsentrat bernutrisi tinggi 4. Pendampingan & transfer knowledge 5. Off taker sebagai pengambil hasil panen</p>';
    $data['posts_bisnis'] = $this->Crud_m->view_where_orders('bisnis','bisnis_status','bisnis_id','ASC');
    $this->load->view('fronts/kontrib/v_kontrib',$data);
  }
  public function kemitraan_unggas()
  {
    $data['status']   = '';
    $data['status_produk']   = '';
    $data['status_lini']   = 'active';
    $data['judul']   = 'Kemitraan Unggas';
    $data['deskripsi']   = '<h3>PT Widodo Makmur Unggas Komitmen Dukung Penguatan 10.000 UMKM</h3>
    <p style="text-align:justify;">Perusahaan peternakan ayam terintegrasi, PT Widodo Makmur Unggas (WMU) menjalin kerja sama dengan Mitra Usaha Kecil Mikro dan Menengah (Mitra UMKM) Daerah guna mendukung penguatan 10.000 UMKM di Indonesia. Kerja sama ini merupakan bagian dari komitmen WMU untuk maju dan tumbuh bersama dalam menyediakan produk pangan hewani berkualitas bagi seluruh masyarakat Indonesia.</p>
    <p style="text-align:justify;">Melalui kerja sama ini, WMU akan menjamin pengadaan bahan baku yang halal dan berkualitas. Tidak hanya itu, WMU akan memberikan benefit bagi UMKM seperti adanya potongan harga dan kemudahan dalam skema pembayaran.</p>
    <p style="text-align:justify;">Seremonial penandatanganan MoU kerja sama ini dilakukan secara virtual bersama 3 mitra pengelola UMKM, yaitu Holistika Institute, The Local Enablers dan Lokalkarya. Mitra UMKM ini mayoritas bergerak di industri makanan olahan. Dengan memastikan kualitas bahan baku serta pendampingan dalam peningkatan kualitas produk yang diberikan oleh WMU bisa menjadi salah satu solusi bangkitnya UMKM di tengah era adaptasi normal baru.</p>';
    $data['posts_bisnis'] = $this->Crud_m->view_where_orders('bisnis','bisnis_status','bisnis_id','ASC');
    $this->load->view('fronts/kontrib/v_kontrib',$data);
  }
  public function laporan()
  {
    $data['status']   = '';
    $data['status_produk']   = '';
    $data['status_lini']   = 'active';
    $data['judul']   = 'Laporan Berkelanjutan';
    $data['deskripsi']   = '<p style="text-align:justify;">Kalimat masih dalam perancangan</p>
    ';
    $data['posts_bisnis'] = $this->Crud_m->view_where_orders('bisnis','bisnis_status','bisnis_id','ASC');
    $this->load->view('fronts/kontrib/v_kontrib',$data);
  }

}