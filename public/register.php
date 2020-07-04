<?require 'includes/header.php'; require 'includes/navbar.php'?>
<div class="container">
  <main>
    <div class="row">
      <div class="col s12">
        <h1 class="center">Registro</h1>
      </div>
    </div>
    <div class="row">
      <form method="post" class="col s12" id="registro">
        <div class="row">
          <div class="input-field col s12 m3">
            <input type="text" name="cpf" id="cpf" class="validate">
            <label for="cpf">CPF</label>
          </div>
          <div class="input-field col s12 m4">
            <input type="text" name="name" required id="name" class="validate">
            <label for="name">Nome</label>
          </div>
          <div class="input-field col s12 m5">
            <input type="email" name="email" required id="email" class="validate">
            <label for="email">Email</label>
          </div>
          <div class="input-field col s12 m6">
            <input type="text" name="address" required id="address" class="validate">
            <label for="address">Endereço</label>
          </div>
          <div class="input-field col s12 m3">
            <input type="text" name="number" required id="number" class="validate">
            <label for="number">Número</label>
          </div>
          <div class="input-field col s12 m3">
            <input type="text" name="complement" id="complement" class="validate">
            <label for="complement">Complemento</label>
          </div>
          <div class="input-field col s12 m4">
            <input type="text" name="phone" id="phone" class="validate">
            <label for="phone">Telefone</label>
          </div>
          <div class="input-field col s12 m4">
            <input type="text" name="cellphone" id="cellphone" class="validate">
            <label for="cellphone">Celular</label>
          </div>
          <div class="input-field col s12 m4">
            <input type="text" name="rg" id="rg" class="validate">
            <label for="rg">RG</label>
          </div>
          <div class="input-field col s12 m4">
            <input type="text" name="user" required id="user" class="validate">
            <label for="user">Usuário</label>
          </div>
          <div class="input-field col s12 m4">
            <input type="password" name="pass" required id="pass" class="validate" onfocusout="verifyPass()">
            <label for="pass">Senha</label>
            <span class="helper-text" data-error="As senhas não conferem" data-success=""></span>
          </div>
          <div class="input-field col s12 m4">
            <input type="password" name="pass2" required id="pass2" class="validate" onfocusout="verifyPass()">
            <label for="pass2">Confirmação de Senha</label>
            <span class="helper-text" data-error="As senhas não conferem" data-success=""></span>
          </div>
          <div class="col s12 m4 xl3">
            <div class="col s12 m6">
              <label>
                <input name="sex" value="M" type="radio" checked />
                <span>Masculino</span>
              </label>
            </div>
            <div class="col s12 m6">
              <label>
                <input name="sex" value="F" type="radio" />
                <span>Feminino</span>
              </label>
            </div>
          </div>
          <div class="col s12 m4">
            <input type="text" class="datepicker" name="born" id="born" placeholder="Data de Nascimento">
          </div>
          <div class="col s12 m4 xl5 right-align">
            <button type="submit" class="btn green waves-effect waves-light">Cadastrar</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    var registro = document.getElementById("registro");
    registro.addEventListener('submit', (e) => {
      console.clear();
      e.preventDefault();
      if(!verifyPass()) {
        M.toast({html: 'As senhas estão diferentes!'})
        return;
      } else {
        var data = new FormData(registro);
        console.log(data);
        fetch(apiLink+'/pacient/post', {
          method: "POST",
          body: data,
          credentials: 'include'
        }).then(data =>
          console.log(data.json()))
        .then(data => {
          M.toast({html: data.msg})
          if (data.code) {
            window.location.href = '/login.php'
          }
        }).catch(error => console.error(error));
      }
    });
  });
  function verifyPass() {
    var pass1 = document.getElementById('pass');
    var pass2 = document.getElementById('pass2');
    if (pass1.value != pass2.value) {
      pass1.classList.add('invalid')
      pass1.classList.remove('valid');
      pass2.classList.add('invalid')
      pass2.classList.remove('valid');
      return false;
    } else {
      pass1.classList.add('valid')
      pass1.classList.remove('invalid');
      pass2.classList.add('valid')
      pass2.classList.remove('invalid');
      return true;
    }
  }
</script>
<?require 'includes/footer.php';?>
