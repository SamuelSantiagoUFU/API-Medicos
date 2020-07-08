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
      <?include '../includes/loading.php'?>
    </div>
  </div>
</main>
<script>
  window.medic = <?=$medic->id?>
</script>
<?require '../includes/footer.php';?>
