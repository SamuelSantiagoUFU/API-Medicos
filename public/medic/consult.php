<?$title="Consulta #".$_GET['id']; $js="medic/consult.js";
require '../includes/medicRequire.php'?>
<div id="exame" class="modal">
  <div class="modal-content">
    <h4 class="center">Novo exame</h4>
    <div class="row">
      <form id="exam" autocomplete="off" class="col s12" method="post">
        <input type="hidden" name="consult" value="<?=$_GET['id']?>">
        <div class="row">
          <div class="input-field col s12 m7">
            <input class="validate" name="desc" type="text" id="desc" required>
            <label for="desc">Descrição do Exame</label>
          </div>
          <div class="input-field col s12 m5">
            <input class="validate" name="qtd" type="number" id="qtd" required>
            <label for="qtd">Quantidade de Amostras</label>
          </div>
          <div class="input-field col s12">
            <select name="type" class="validate browser-default" id="type" required>
              <option value="S">Sangue</option>
              <option value="F">Fezes</option>
              <option value="U">Urina</option>
            </select>
            <label>Tipo de exame</label>
          </div>
        </div>
        <div class="row">
          <div class="col s12 right-align">
            <button class="btn waves-effect waves-light" type="submit">Enviar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<main>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <h1 class="center"><?=$title?></h1>
      </div>
    </div>
    <div class="row">
      <div class="col s12"><a href="#exame" class="waves-effect waves-light btn modal-trigger">Exame</a></div>
    </div>
    <div class="row">
      <fieldset>
        <legend>Exames</legend>
        <div class="col s12" id="exams"></div>
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
      </fieldset>
    </div>
    <div class="row">

    </div>
  </div>
</main>
<?require '../includes/footer.php';?>
