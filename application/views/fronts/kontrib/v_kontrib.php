
<!DOCTYPE html>
<html lang="en">
<!-- START SECTION HEAD -->
<?php $this->load->view('fronts/head.php')?>
<!-- END SECTION HEAD -->

<body>



<!-- START HEADER -->
<?php $this->load->view('fronts/header.php')?>
<!-- END HEADER -->

<!-- START SECTION BANNER -->
<section class="background_bg breadcrumb_section overlay_bg2 page-title-light" data-img-src="assets/images/about_bg.jpg">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12 text-center">
            	<div class="page-title">
            		<h1><?php echo $judul; ?></h1>
                </div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Kontribusi Sosial</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $judul; ?></li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BANNER -->

<!-- START SECTION FEATURE -->
<section class="p-md-0 pt-3 overflow_hide">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-sm-12 p-0 animation" data-animation="fadeInLeft" data-animation-delay="0.2s">
            	<div class="medium_padding">
                    <div class="heading_s3 mb-lg-4">
                      <h2><?php echo $judul; ?></h2>
                    </div>
                    <p><?php echo $deskripsi; ?></p>
                  </div>
            </div>
            <div class="col-lg-6 p-0 animation" data-animation="fadeInRight" data-animation-delay="0.4s">
            	<div class="h-100 background_bg md-height-300" data-img-src="assets/images/about_img8.jpg"></div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION FEATURE -->

<!-- START SECTION SUBCRIBE -->
<?php $this->load->view('fronts/home/v_subcribe')?>
<!-- END SECTION SUBCRIBE -->

<!-- START FOOTER SECTION -->
<?php $this->load->view('fronts/footer')?>
<!-- END FOOTER SECTION -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

<!-- Latest jQuery -->
<script src="<?php echo base_url()?>assets/js/jquery-1.12.4.min.js"></script>
<!-- jquery-ui -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>
<!-- popper min js -->
<script src="<?php echo base_url()?>assets/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- owl-carousel min js  -->
<script src="<?php echo base_url()?>assets/owlcarousel/js/owl.carousel.min.js"></script>
<!-- magnific-popup min js  -->
<script src="<?php echo base_url()?>assets/js/magnific-popup.min.js"></script>
<!-- waypoints min js  -->
<script src="<?php echo base_url()?>assets/js/waypoints.min.js"></script>
<!-- parallax js  -->
<script src="<?php echo base_url()?>assets/js/parallax.js"></script>
<!-- countdown js  -->
<script src="<?php echo base_url()?>assets/js/jquery.countdown.min.js"></script>
<!-- fit video  -->
<script src="<?php echo base_url()?>assets/js/jquery.fitvids.js"></script>
<!-- jquery.counterup.min js -->
<script src="<?php echo base_url()?>assets/js/jquery.counterup.min.js"></script>
<!-- isotope min js -->
<script src="<?php echo base_url()?>assets/js/isotope.min.js"></script>
<!-- elevatezoom js -->
<script src='<?php echo base_url()?>assets/js/jquery.elevatezoom.js'></script>
<!-- scripts js -->
<script src="<?php echo base_url()?>assets/js/scripts.js"></script>

</body>
</html>