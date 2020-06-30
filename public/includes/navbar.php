<?
$logged = true;//isset($_SESSION['login']) && $_SESSION['login'];
?>
<nav class="white">
  <div class="nav-wrapper black-text">
    <a href="/" class="brand-logo">Médicos</a>
    <?=$logged?'<a href="#" data-target="navbar-admin" class="show-on-med-and-down sidenav-trigger right"><i class="material-icons">menu</i></a>':''?>
    <ul class="right hide-on-med-and-down">
      <li><?=!$logged?'<a href="#" class="tooltipped" data-tooltip="Login"><i class="material-icons">https</i></a>':''?></li>
    </ul>
  </div>
</nav>
<ul class="sidenav sidenav-fixed" id="navbar-admin">
  <li><a href="/admin/medics.php"><i class="material-icons">medical_services</i>Médicos</a></li>
  <li><a href="badges.html"><i class="material-icons">local_hospital</i>Consultas</a></li>
  <li><a href="collapsible.html"><i class="material-icons">maps_ugc</i>Exames</a></li>
  <li><a href="/admin/pacients.php"><i class="material-icons">sick</i>Pacientes</a></li>
  <li><a href="mobile.html"><i class="material-icons">schedule</i>Horários</a></li>
</ul>
