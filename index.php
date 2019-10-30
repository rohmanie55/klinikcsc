<?php include_once "header.php";
include_once "admin/library/inc.connection.php";

?>

  <!--banner-->
  <section id="banner" class="banner">
    <div class="bg-color">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="col-md-12">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
              <a class="navbar-brand" href="#"><h2 class="white">CSC</h2></a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#banner">Home</a></li>
                <li class=""><a href="#service">Services</a></li>
                <li class=""><a href="#product">Product</a></li>
                <li class=""><a href="#about">About</a></li>
                <li class=""><a href="#contact">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <div class="container">
        <?php 
      if(isset($_GET['p'])){
      echo "<div class='alert alert-primary'>".$_GET['p']."</div>";
      }
      ?>

        <div class="row">
          <div class="banner-info">
            <div class="banner-logo text-center">
              <img src="assets/img/logo.png" class="img-responsive">
            </div>
            <div class="banner-text text-center">
              <h1 class="white">Healthcare at your desk!!</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod <br>tempor incididunt ut labore et dolore magna aliqua.</p>
              <a href="#appointment" class="btn btn-appoint">Make an Appointment.</a>
            </div>
            <div class="overlay-detail text-center">
              <a href="#service"><i class="fa fa-angle-down"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ banner-->
  <!--service-->
  <section id="service" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3">
          <h2 class="ser-title">Our Service</h2>
          <hr class="botm-line">
          <p>We are proud to serve you.</p>
        </div>
        <div class="col-md-9 col-sm-9">
          <div class="service-info col-md-4">
            <div class="icon">
              <i class="fa fa-stethoscope"></i>
            </div>
            <div class="icon-info">
              <h4>Dermatologi Umum</h4>
              <p>Konsultasi dengan dokter kesehatan kulit untuk permasalahan kulit.</p>
            </div>
          </div>
          <div class="service-info col-md-4">
            <div class="icon">
              <i class="fa fa-user-md"></i>
            </div>
            <div class="icon-info">
              <h4>Dermatologi Kosmetik</h4>
              <p>Chemical peeling, kenacort intralesi, ekstrasi komedo, botox, dll.</p>
            </div>
          </div>
          <div class="service-info col-md-4">
            <div class="icon">
              <i class="fa fa-medkit"></i>
            </div>
            <div class="icon-info">
              <h4>Farmasi</h4>
              <p>CSC menyediakan apotek yang menyediakan berbagai macam obat-obatan dan lotion.</p>
            </div>
          </div>
          <div class="service-info col-md-4">
            <div class="icon">
              <i class="fa fa-female"></i>
            </div>
            <div class="icon-info">
              <h4>Fat Reduction & Body Contouring</h4>
              <p>Untuk menghilangkan lemak dan pembentukan pengencangan tubuh.</p>
            </div>
          </div>
          <div class="service-info col-md-4">
            <div class="icon">
              <i class="fa fa-bed"></i>
            </div>
            <div class="icon-info">
              <h4>Akupuntur</h4>
              <p>Teknik pengobatan dengan menggunakan jarum yang ditusukkan di titik akupuntur.</p>
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </section>
  <!--/ service-->
  <!--cta-->
  <section id="product" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Produk Krim Andalan Kami!</h2>
          <hr class="botm-line">
        </div>
        <div class="schedule-tab">
        <?php
          $mySql = "SELECT * FROM obat LIMIT 5";
          $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
          while ($myData = mysql_fetch_array($myQry)) {
          ?>
          <div class="col-md-3 col-sm-3 bor-left">
            <div class="mt-boxy-color"></div>
            <div class="medi-info">
              <h3><?php echo $myData['nm_obat']; ?></h3>
              <img src="<?php echo $myData['gambar']; ?>" style="height: 150px;">
              <a href="#" class="medi-info-btn">READ MORE</a>
            </div>
          </div>
      <?php } ?>
          
        </div>
      </div>
    </div>
  </section>
  <!--cta-->
  <!--about-->
  <section id="about" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
          <div class="section-title">
            <h2 class="head-title lg-line">Klinik <br>Cikarang Skin Centre</h2>
            <hr class="botm-line">
            <p class="sec-para">Kami hanya menggunakan peralatan terbaik, dokter terbaik dan memberikan pelayanan terbaik...</p>
            <a href="" style="color: #0cb8b6; padding-top:10px;">Know more..</a>
          </div>
        </div>
        <div class="col-md-9 col-sm-8 col-xs-12">
          <div style="visibility: visible;" class="col-sm-9 more-features-box">
            <div class="more-features-box-text">
              <div class="more-features-box-text-icon"> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
              <div class="more-features-box-text-description">
                <h3>It's something important you want to know.</h3>
                <p>Kami memiliki kebanggaan sebagai salah satu pioner klinik kesehatan kulit yang menitikberatkan pada kepuasan dan hasil maksimal dan juga penggunaan prosedur pelayanan yang baku sesuai dengan kode etik kedokteran Indonesia.</p>
              </div>
            </div>
            <div class="more-features-box-text">
              <div class="more-features-box-text-icon"> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
              <div class="more-features-box-text-description">
                <h3>It's something important you want to know.</h3>
                <p>Klinik spesialis kulit Cikarang Skin Centre mempunyai dokter spesialis kulit dan kelamin yang sangat kompeten dibidangnya, yang akan selalu siap melayani masyarakat yang memiliki permasalahan dengan kulit dan juga yang menginginkan kulit sehat.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ about-->
  <!--doctor team-->

  <!--/ doctor team-->

  <!--cta 2-->
  <section id="appointment" style="color: white">
    <div id="paralax" class="section-padding">
    <div class="container">
      <div class=" row">

        <div class="col-md-4 col-sm-4">
          <h2 style="color: white">Make apointment</h2>
          <hr class="botm-line">
          <p>Untuk membuat janji kamu harus login atau mendaftar terlebih dahulu<br>Kamu bisa membuat janji bertemu dengan mudah tanpa harus datang ketempat secara langsung</p>
        </div>
        <div class="col-md-5 col-sm-8 marb20">
          <div class="contact-info" >
            <div class="panel with-nav-tabs panel-success">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1success" data-toggle="tab">LOGIN</a></li>
                            <li><a href="#tab2success" data-toggle="tab">SIGNUP</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1success">
                          <form action="login.php" method="post" role="form">
                            <div class="form-group">
                              <input type="text" name="username" class="form-control br-radius-zero" placeholder="Your Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                              <div class="validation"></div>
                            </div>
                            <div class="form-group">
                              <input type="password" class="form-control br-radius-zero" name="password"  placeholder="Your Password" data-rule="email" data-msg="Please enter a valid email" />
                              <div class="validation"></div>
                            </div>

                            <div class="form-action">
                              <button type="submit" class="btn btn-success pull-right">Masuk</button>
                            </div>
                          </form>
                        </div>
                        <div class="tab-pane fade" id="tab2success">
                          <form action="signup.php" method="post" role="form">
                            <div class="form-group">
                              <input type="text" name="username" class="form-control br-radius-zero"  placeholder="Your Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                              <div class="validation"></div>
                            </div>
                            <div class="form-group">
                              <input type="password" class="form-control br-radius-zero" name="password" placeholder="Your Password" data-rule="email" data-msg="Please enter a valid email" />
                              <div class="validation"></div>
                            </div>

                            <div class="form-action">
                              <button type="submit" class="btn btn-primary pull-right">Daftar</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </div>
  </section>
  <!--cta-->
     <!--testimonial-->
  <section id="testimonial" class="section-padding">
    <div class="container">
      <div class="row">
        
        <div class="col-md-4 col-sm-4">
          <div class="testi-details">
            <!-- Paragraph -->
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
          <div class="testi-info">
            <!-- User Image -->
            <a href="#"><img src="img/thumb.png" alt="" class="img-responsive"></a>
            <!-- User Name -->
            <h3>Alex<span>Texas</span></h3>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="testi-details">
            <!-- Paragraph -->
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
          <div class="testi-info">
            <!-- User Image -->
            <a href="#"><img src="img/thumb.png" alt="" class="img-responsive"></a>
            <!-- User Name -->
            <h3>Alex<span>Texas</span></h3>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="testi-details">
            <!-- Paragraph -->
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
          <div class="testi-info">
            <!-- User Image -->
            <a href="#"><img src="img/thumb.png" alt="" class="img-responsive"></a>
            <!-- User Name -->
            <h3>Alex<span>Texas</span></h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ testimonial-->
  <!--contact-->
  <section id="contact" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Contact us</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-4 col-sm-4">
          <h3>Contact Info</h3>
          <div class="space"></div>
          <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i>Ruko Cortes B21/28 <br> , Simpangan, Cikarang Utara,<br> Bekasi, Jawa Barat 17530</p>
          <div class="space"></div>
          <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i>info@companyname.com</p>
          <div class="space"></div>
          <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i>+1 800 123 1234</p>
        </div>
        <div class="col-md-8 col-sm-8 marb20">
         
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8782743388515!2d107.17517641412151!3d-6.2797297954548315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6984b6d7c0dd3f%3A0x39efb8a42d284dd8!2sCikarang+skin+center!5e0!3m2!1sid!2sid!4v1545619114801" height="300" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
       
        </div>
      </div>
    </div>
  </section>
  <!--/ contact-->
<?php include_once "footer.php";?>
