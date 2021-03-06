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
      <?include '../includes/loading.php'?>
    </div>
  </div>
</main>
<?require '../includes/footer.php';?>
