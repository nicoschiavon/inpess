<?php
include_once 'biblioteca/config/Database.php';
include_once 'biblioteca/class/Libro.php';
include_once 'biblioteca/class/Revista.php';
include_once 'biblioteca/class/TextoCientifico.php';


$database = new Database();
$db = $database->getConnection();

$book = new Libro($db);
$revista = new Revista($db);
$textoCientifico = new TextoCientifico($db);


?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>INPESS</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="assets/images/inpess.ico" type="inpess/ico">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  </head>

<body>

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
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <h1>INPESS</h1>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Serach Start ***** -->
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Buscar" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <!-- ***** Serach Start ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li class=""><a href="index.html" class="active">INICIO</a></li>
                      <li class=""><a href="biblioteca/index.php">Login</a></li>

                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="main-banner" id="top" style="padding:10px">
    <div class="col-lg-12 text-center">
      <div class="section-heading">
        <h1>Repositorio</h1>
      </div>
    </div>

    <ul class="event_filter">
      
      <li>
        <a href="#!" data-filter=".todo">Mostrar todo</a>
      </li>
      <li>
        <a href="#!" data-filter=".libro">Libros</a>
      </li>
      <li>
        <a href="#!" data-filter=".revista">Revistas</a>
      </li>
      <li>
        <a href="#!" data-filter=".wordpress">Tesis</a>
      </li>
    </ul>

  </div>
  <div class="section fun-facts" style="padding:10px; margin:10px">
    <div class="section events" id="events" style="padding:10px; margin:10px; width:100%; position: relative; height:100%">
      <div class="container-fluid">
        <div class="row event_box">

          <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 todo">
            <h2>Documentos</h2>
            <table id="textoCientificoListingBiblio" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>ISBN/ISSN/ACTA</th>
                  <th>Resumen</th>
                  <th>Tipo</th>
                  <th>PDF</th>

                </tr>
              </thead>
            </table>
          </div>



          <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 libro">
            <h2>Libros</h2>
            <table id="libroListingbiblio" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <td></td>
                  <th>Titulo</th>
                  <th>Editorial</th>
                  <th>Resumen</th>
                  <th>PDF</th>
                  <th>Año Publicacion</th>							
                </tr>
              </thead>
            </table>
          </div>


          <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 revista">
            <h2>Revistas</h2>
            <table id="revistaListingBiblio" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>ISBN/ISSN/ACTA</th>
                  <th>Resumen</th>
                  <th>Tipo</th>
                  <th>Nombre de la Revista</th>
                  <th>Número de la Revista</th>
                  <th>Primera Página</th>
                  <th>Última Página</th>
                  <th>Mes de Publicación</th>
                  <th>Año de Publicación</th>
                  <th>PDF</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="col-lg-12 col-md-6">
          
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2036 Scholar Organization. All rights reserved. &nbsp;&nbsp;&nbsp; Design: <a href="https://templatemo.com" rel="nofollow" target="_blank">TemplateMo</a> Distribution: <a href="https://themewagon.com" rel="nofollow" target="_blank">ThemeWagon</a></p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Load jQuery first -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="biblioteca/js/libro.js"></script>
  <script src="biblioteca/js/revista.js"></script>
  <script src="biblioteca/js/textoCientifico.js"></script>
  <script src="main.js"></script> <!-- Asegúrate de que el path sea correcto -->

  </body>
</html>
