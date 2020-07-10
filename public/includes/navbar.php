<nav class="white">
  <div class="nav-wrapper black-text">
    <a href="/" class="brand-logo">Médicos</a>
    <?=$admin?'<a href="#" data-target="navbar-admin" class="show-on-med-and-down sidenav-trigger right"><i class="material-icons">menu</i></a>':
    '<a href="#" data-target="navbar" class="sidenav-trigger right"><i class="material-icons">menu</i></a>'?>
    <ul class="right hide-on-med-and-down">
      <?if (!$logged):?>
      <li><a href="/register.php" class="tooltipped" data-tooltip="Registrar"><i class="material-icons">person_add</i></a></li>
      <li><a href="/login.php" class="tooltipped" data-tooltip="Login"><i class="material-icons">https</i></a></li>
      <?elseif (!$admin):?>
        <?if ($medic):?>
        <li><a href="/medic/consults.php" class="tooltipped" data-tooltip="Consultas"><i class="material-icons">local_hospital</i></a></li>
        <li><a href="/medic/schedule.php" class="tooltipped" data-tooltip="Horários"><i class="material-icons">schedule</i></a></li>
        <?endif;?>
      <li><a href="/logout.php" class="tooltipped" data-tooltip="Logout"><i class="material-icons">power_settings_new</i></a></li>
      <?endif;?>
    </ul>
  </div>
</nav>
<?if ($admin):?>
<ul class="sidenav sidenav-fixed" id="navbar-admin">
  <li><a href="/admin/medics.php"><i class="material-icons">medical_services</i>Médicos</a></li>
  <li><a href="/admin/pacients.php"><i class="material-icons">sick</i>Pacientes</a></li>
  <li><a href="/admin/schedule.php"><i class="material-icons">schedule</i>Horários</a></li>
  <li><a href="/logout.php"><i class="material-icons">power_settings_new</i>Sair</a></li>
</ul>
<?elseif (!$logged):?>
<ul class="sidenav" id="navbar">
  <li><a href="/register.php"><i class="material-icons">person_add</i>Registrar</a></li>
  <li><a href="/login.php"><i class="material-icons">https</i>Login</a></li>
</ul>
<?elseif ($medic):?>
<ul class="sidenav" id="navbar">
  <li><a href="/medic/consults.php"><i class="material-icons">local_hospital</i>Consultas</a></li>
  <li><a href="/medic/schedule.php"><i class="material-icons">schedule</i>Horários</a></li>
</ul>
<?endif;?>
