<?require 'includes/header.php'; require 'includes/navbar.php'?>
<div class="container">
  <main>
    <div class="row">
      <div class="col s12">
        <h1 class="center">Login</h1>
      </div>
    </div>
    <div class="row">
      <form method="post" class="col s12" id="login">
        <div class="row">
          <div class="input-field col s12">
            <input type="email" name="email" required id="email">
            <label for="email">Email</label>
          </div>
          <div class="input-field col s12">
            <input type="password" name="pass" required id="pass">
            <label for="pass">Senha</label>
          </div>
        </div>
        <div class="row">
          <div class="col s12 right-align">
            <button type="submit" class="btn green waves-effect waves-light">Entrar</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    var login = document.getElementById("login");
    login.addEventListener('submit', (e) => {
      e.preventDefault();
      var data = new FormData(login);
      fetch(apiLink+'/login', {
        method: "POST",
        body: data,
        credentials: 'include'
      }).then(data => data.json())
      .then(data => {
        console.log(data.user);
        if (data.logado) {
          window.location.href = '/';
        }
        M.toast({html: data.msg})
      }).catch(error => console.error(error));
    });
  });
</script>
<?require 'includes/footer.php';?>
