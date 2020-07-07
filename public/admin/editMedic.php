<?$title="ADM Médicos";$js="admin/editMedic.js";
require '../includes/adminRequire.php';
$ch = curl_init('http://api.jefersson.net.br/medic/get/'.$_GET['medic']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$medic = json_decode(curl_exec($ch));
include '../includes/uf.php';
?>
<main>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <h3 class="center">Editar Médico</h3>
      </div>
    </div>
    <div class="row">
      <form id="formulario" autocomplete="off" method="post" class="col s12">
        <input type="hidden" name="id" value="<?=$medic->id?>">
        <div class="row">
          <fieldset class="col s12">
            <legend>Dados pessoais</legend>
            <div class="row">
              <div class="input-field col s12 m3">
                <input type="text" name="cpf" id="cpf" class="validate" value="<?=$medic->cpf?>">
                <label for="cpf">CPF</label>
              </div>
              <div class="input-field col s12 m4">
                <input type="text" name="name" required id="name" class="validate" value="<?=$medic->name?>">
                <label for="name">Nome</label>
              </div>
              <div class="input-field col s12 m5">
                <input type="email" name="email" required id="email" class="validate" value="<?=$medic->email?>">
                <label for="email">Email</label>
              </div>
              <div class="input-field col s12 m6">
                <input type="text" name="address" required id="address" class="validate" value="<?=$medic->address?>">
                <label for="address">Endereço</label>
              </div>
              <div class="input-field col s12 m3">
                <input type="text" name="number" required id="number" class="validate" value="<?=$medic->number?>">
                <label for="number">Número</label>
              </div>
              <div class="input-field col s12 m3">
                <input type="text" name="complement" id="complement" class="validate" value="<?=$medic->complement?>">
                <label for="complement">Complemento</label>
              </div>
              <div class="input-field col s12 m4">
                <input type="text" name="phone" id="phone" class="validate" value="<?=$medic->phone?>">
                <label for="phone">Telefone</label>
              </div>
              <div class="input-field col s12 m4">
                <input type="text" name="cellphone" id="cellphone" class="validate" value="<?=$medic->cellphone?>">
                <label for="cellphone">Celular</label>
              </div>
              <div class="input-field col s12 m4">
                <input type="text" name="rg" id="rg" class="validate" value="<?=$medic->rg?>">
                <label for="rg">RG</label>
              </div>
              <div class="input-field col s12 m4">
                <input type="text" name="user" required id="user" class="validate" value="<?=$medic->user?>">
                <label for="user">Usuário</label>
              </div>
              <div class="input-field col s12 m4">
                <input type="text" class="datepicker" name="born" id="born" placeholder="Data de Nascimento" value="<?=$medic->born?>">
              </div>
              <div class="input-field col s12 m4 xl3">
                <div class="col s12 m6 l12">
                  <label>
                    <input name="sex" value="M" type="radio" <?=$medic->sex == 'M'?'checked':''?>/>
                    <span>Masculino</span>
                  </label>
                </div>
                <div class="col s12 m6 l12">
                  <label>
                    <input name="sex" value="F" type="radio" <?=$medic->sex == 'F'?'checked':''?>/>
                    <span>Feminino</span>
                  </label>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="col s12">
            <legend>Dados médicos</legend>
            <div class="row">
              <div class="input-field col s12 m5">
                <input type="text" name="title" required id="title" class="validate" value="<?=$medic->title?>">
                <label for="title">Título</label>
              </div>
              <div class="input-field col s12 m7">
                <input type="text" name="clinic" required id="clinic" class="validate" value="<?=$medic->clinic?>">
                <label for="clinic">Especialização</label>
              </div>
              <div class="input-field col s12 m3">
                <input type="text" name="type" required id="type" class="validate" value="<?=$medic->type?>">
                <label for="type">Tipo</label>
              </div>
              <div class="input-field col s12 m5">
                <input type="text" name="register" required id="register" class="validate" value="<?=$medic->register?>">
                <label for="register">Registro</label>
              </div>
              <div class="input-field col s12 m4">
                <select name="uf" class="validate" required>
                  <?
                  foreach ($ufs as $uf => $state) {
                    $selected = $uf == $medic->uf ? ' selected' : '';
                    echo "<option value='$uf'$selected>$uf</option>";
                  }
                  ?>
                </select>
                <label>UF</label>
              </div>
              <div class="input-field col s12">
                <input type="text" name="cns" required id="cns" class="validate" value="<?=$medic->cns?>">
                <label for="cns">CNS</label>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="row">
          <div class="col s12 right-align">
            <button class="btn waves-effect waves-light" type="submit">Enviar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>
<?require '../includes/footer.php';?>
