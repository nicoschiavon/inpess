<?php
include_once 'config/Database.php';
include_once 'class/Miembro.php';
include_once 'class/Administrador.php';


$database = new Database();
$db = $database->getConnection();

$miembro = new Miembro($db);
$administrador = new Administrador($db);

if (!$miembro->loggedIn() && !$administrador->loggedIn()) {
  header("Location: index.php");
}

include('components/header4.php');
?>
<title>Dashboard</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/dashboard.css" />
</head>

<body>

  <div class="container-fluid" id="main">
    <?php include('top_menus.php'); ?>
    <div class="row row-offcanvas row-offcanvas-left">
      <?php include('left_menus.php'); ?>
      <div class="col-md-9 col-lg-10 main">
        <h2>Dashboard</h2>
        <div class="row mb-3">
         
        </div>
        <hr>
      </div>
    </div>
  </div>
  <?php
  include("./footer.php");
  ?>
</body>

</html>