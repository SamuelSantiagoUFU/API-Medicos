<?$title="ADM Médicos";$js="admin/medic.js";
require '../includes/adminRequire.php'?>
<main>
  <div class="area">
    <form id="formulario" autocomplete="off">
      <fieldset>
        <legend>Formulário</legend>
        <div class="row">
            <label>Nome:</label><input class="form" name="name" type="text">
            <label>Usuário:</label><input class="form" name="user" type="text"><br>
        </div>
        <div class="row2">
            <label>Email:</label><input class="form" name="email" type="text">
            <label>Senha:</label><input class="form" name="pass" type="password"><br>
        </div>
        <div class="row3">
            <label>Endereço:</label><input class="form" name="adress" type="text">
            <label>Número:</label><input class="small" name="number" type="number"><br>
        </div>
        <div class="row4">
            <label>Título:</label><input class="small" name="title" type="text">
            <label>Especialização:</label><input class="form"  name="clinic" type="text"><br>
        </div>
        <div class="row5">
        <label>CRM:</label><input class="form" name="type" type="number"><br>
        <label>UF:</label><select class="small" name="uf">
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select> <br>
        <label>Numero Registro:</label><input class="form" name="register" type="number"><br>
        <label>CNS:</label><input class="form" name="cns" type="number"><br>
        </div>
        <input class="btn" type="submit" value="Enviar">
      </fieldset>
    </form>
  </div>
</main>
<?require '../includes/footer.php';?>
