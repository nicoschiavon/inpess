<head>

<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Bootstrap core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


<!-- Additional CSS Files -->
<link rel="stylesheet" href="../assets/css/fontawesome.css">
<link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
<link rel="stylesheet" href="../assets/css/owl.css">
<link rel="stylesheet" href="../assets/css/animate.css">
<link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>


    
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
	<span></span>
  </div>
</div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<nav class="header-area header-sticky background-header">
<div class="container">
    <div class="row">
		<div class="col-12">
			<nav class="main-nav">
                <!-- ***** Logo Start ***** -->
				<a href="../index.html" class="logo">
                    <h1>INPESS</h1>
				</a>
				<!-- ***** Logo End ***** -->

            <!-- ***** Menu Start ***** -->
				<ul class="nav">
				  <li class="scroll-to-section"><a href="../index.html" class="active">INICIO</a></li>
				  <!--<li class="scroll-to-section"><a href="#services">Services</a></li>-->

                  
				  <li class="scroll-to-section"><a href="../biblioteca.php">Libreria</a></li>

                  <?php if ($miembro->loggedIn() ) { ?>
				<li class="nav-item">
					<a class="nav-link"><?php echo ucfirst($_SESSION["nombre"]); ?></a>
				</li>
			<?php } else { ?>
				<?php if ($miembro->loggedIn() ) { ?>
					<li class="nav-item">
						<a class="nav-link"><?php echo ucfirst($_SESSION["nombre"]); ?></a>
					</li>
				<?php } ?>
			<?php } ?>

                </ul>   
				<a class='menu-trigger'>
                    <span>Menu</span>

				</a>

                
				<!-- ***** Menu End ***** -->
			</nav>
		</div>
	</div>
</div>
</nav>
<script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/js/isotope.min.js"></script>
  <script src="../assets/js/owl-carousel.js"></script>
  <script src="../assets/js/counter.js"></script>
  <script src="../assets/js/custom.js"></script>

