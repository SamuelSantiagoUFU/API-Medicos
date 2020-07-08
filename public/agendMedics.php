<?require 'includes/header.php'; require 'includes/navbar.php'; $js = 'user/agend.js';include 'includes/uf.php';?>
<main>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <h2 class="center">Agendar uma consulta</h2>
      </div>
    </div>
    <div class="row">
      <form id="consulta" class="col s12" method="post" autocomplete="off">
        <div class="row">
          <div class="input-field col s12 m6 l5">
            <input type="text" class="autocomplete validate" id="spec" name="clinic" required>
            <label for="spec">Especialização</label>
          </div>
          <div class="input-field col s12 m6 l2">
            <select name="uf" class="validate" required>
              <?
              foreach ($ufs as $uf => $state) {
                $selected = $uf == $medic->uf ? ' selected' : '';
                echo "<option value='$uf'$selected>$state</option>";
              }
              ?>
            </select>
            <label>UF</label>
          </div>
          <div class="input-field col s12 m6 l3">
            <input type="text" class="datepicker validate" name="data" id="data" required>
            <label for="data">Data</label>
          </div>
          <div class="input-field col s12 m6 l2">
            <input type="text" class="timepicker validate" name="hora" id="time" required>
            <label for="time">Hora</label>
          </div>
        </div>
        <div class="row">
          <div class="col s12 right-align">
            <button class="btn waves-effect waves-light" type="submit">Procurar</button>
          </div>
        </div>
      </form>
    </div>
    <?$hidden = 'hide';include 'includes/loading.php'?>
    <div class="row">
      <div class="col s12" id="medicos"></div>
    </div>
  </div>
</main>
<?require 'includes/footer.php';?>
