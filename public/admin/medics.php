<?session_start();$title="ADM Médicos";$js="admin/medic.js";
require '../includes/header.php'; require '../includes/navbar.php'?>
<main>
  <div class="container">
    <div class="row">
      <h3 class="col s12 center">Médicos</h3>
    </div>
    <div class="row">
      <table class="col s12" id="medicsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Tipo</th>
            <th>Registro</th>
            <th>Especialização</th>
            <th>CNS</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
      <div class="center" id="loading">
        <div class="preloader-wrapper big active">
          <div class="spinner-layer spinner-blue">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div><div class="gap-patch">
              <div class="circle"></div>
            </div><div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-red">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div><div class="gap-patch">
              <div class="circle"></div>
            </div><div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-yellow">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div><div class="gap-patch">
              <div class="circle"></div>
            </div><div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-green">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div><div class="gap-patch">
              <div class="circle"></div>
            </div><div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?require '../includes/footer.php';?>
