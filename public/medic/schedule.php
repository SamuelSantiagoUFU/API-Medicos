<?$title="Horários";$js="medic/medic.js";
require '../includes/medicRequire.php'?>
<main>
  <div class="container">
    <div class="row">
      <h3 class="col s12 center">Horários</h3>
    </div>
    <div class="row">
      <ul class="tabs tabs-fixed-width" id="schedule">
        <li class="tab"><a href="#day0">Domingo</a></li>
        <li class="tab"><a href="#day1">Segunda</a></li>
        <li class="tab"><a href="#day2">Terça</a></li>
        <li class="tab"><a href="#day3">Quarta</a></li>
        <li class="tab"><a href="#day4">Quinta</a></li>
        <li class="tab"><a href="#day5">Sexta</a></li>
        <li class="tab"><a href="#day6">Sábado</a></li>
      </ul>
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
<script>
  window.medic = <?=$medic->id?>
</script>
<?require '../includes/footer.php';?>
