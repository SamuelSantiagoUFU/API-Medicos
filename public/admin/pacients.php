<?$title="ADM Pacientes";$js="admin/pacient.js";
require '../includes/adminRequire.php'?>
<main>
  <div class="container">
    <div class="row">
      <h3 class="col s12 center">Pacientes</h3>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input type="text" name="query" placeholder="Ex. Adelina, Pascoal, Kaique" id="query">
        <label for="query">Pesquisar pelo nome</label>
      </div>
    </div>
    <div class="row">
      <table class="col s12 centered responsive-table" id="pacientsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Nascimento</th>
            <th>Email</th>
            <th><i class="material-icons">edit</i></th>
          </tr>
        </thead>
        <tbody></tbody>
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
