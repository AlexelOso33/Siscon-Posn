<body class="hold-transition skin-blue-light sidebar-mini fixed">
<!-- Site wrapper -->

<!-- TERMINA SECCIÓN MODALES -->
<div class="wrapper">

<header class="main-header">
    <!-- Logo -->
    <a href="https://siscon-system.com/pages/main-sis.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="display: block!important;"><b>SISCON</b>&nbsp;System</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $nom1; ?></b><?php echo $nom2; ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

      <div class="navbar-custom-menu" style="display:none;">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo $_SESSION['avatar']; ?>" class="user-image" alt="User Image">
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div> -->
                <div style="position:relative;">
                  <a href="https://siscon-system.com" class="btn btn-default btn-flat bg-red pull-right"><i class="fa fa-sign-out"></i></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         <!--  <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
      <!-- <div class="navbar-custom-menu" style="float:left;margin-left: 20px;">
        <div class="system-bar">
          <img src="../img/siscon620.png" alt="Siscon system">
          <p><?php // echo $p_siscon; ?></p>
        </div>
      </div> -->
    </nav>
  </header>

  <!-- =============================================== -->