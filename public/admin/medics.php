<?$title="ADM Médicos";$js="admin/medic.js";
require '../includes/adminRequire.php'?>
<main>
  <div class="container">
    <div class="row">
      <h3 class="col s12 center">Médicos</h3>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input type="text" name="query" placeholder="Ex. Adelina, Pascoal, Kaique" id="query">
        <label for="query">Pesquisar pelo nome</label>
      </div>
    </div>
    <div class="row">
      <table class="col s12 centered responsive-table" id="medicsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Tipo</th>
            <th>Registro</th>
            <th>Especialização</th>
            <th>CNS</th>
            <th><i class="material-icons">edit</i></th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
      <?include '../includes/loading.php'?>
    </div>
  </div>
</main>
<?require '../includes/footer.php';?>
