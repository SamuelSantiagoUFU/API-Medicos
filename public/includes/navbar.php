<?
$logged = isset($_COOKIE['login']) && $_COOKIE['login'];
$admin = $logged && $_COOKIE['admin'];
?>
<nav class="white">
  <div class="nav-wrapper black-text">
    <a href="/" class="brand-logo">Médicos</a>
    <?=$admin?'<a href="#" data-target="navbar-admin" class="show-on-med-and-down sidenav-trigger right"><i class="material-icons">menu</i></a>':''?>
    <ul class="right hide-on-med-and-down">
      <?if (!$logged):?>
      <li><a href="/register.php" class="tooltipped" data-tooltip="Registrar"><i class="material-icons">person_add</i></a></li>
      <li><a href="/login.php" class="tooltipped" data-tooltip="Login"><i class="material-icons">https</i></a></li>
      <?else:?>
      <li><a href="/logout.php" class="tooltipped" data-tooltip="Logout"><i class="material-icons">power_settings_new</i></a></li>
      <?endif;?>
    </ul>
  </div>
</nav>
<?if ($admin):?>
<ul class="sidenav sidenav-fixed" id="navbar-admin">
  <li><a href="/admin/medics.php"><i class="material-icons">medical_services</i>Médicos</a></li>
  <li><a href="badges.html"><i class="material-icons">local_hospital</i>Consultas</a></li>
  <li><a href="collapsible.html"><i class="material-icons">maps_ugc</i>Exames</a></li>
  <li><a href="/admin/pacients.php"><i class="material-icons">sick</i>Pacientes</a></li>
  <li><a href="mobile.html"><i class="material-icons">schedule</i>Horários</a></li>
  <li><a href="/logout.php"><i class="material-icons">power_settings_new</i>Sair</a></li>
</ul>
<?endif;?>
