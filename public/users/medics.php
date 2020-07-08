<div class="col s12 m4 l3">
  <div class="card">
    <div class="card-image">
      <img src="/img/medic.jpg">
      <span class="card-title"><?=$_GET['name']?></span>
    </div>
    <div class="card-content">
      <p class="right-align flow-text">R$ <?=number_format($_GET['value'],2,',','.')?></p>
    </div>
    <div class="card-action">
      <a href="#<?=$_GET['id']?>" class="green-text">Agendar</a>
    </div>
  </div>
</div>
