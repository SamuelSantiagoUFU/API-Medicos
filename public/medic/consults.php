<?$title="Consultas";$js=["medic/MindFusion.Scheduling.js","medic/GoogleSchedule.js","medic/TimeForm.js"];
require '../includes/medicRequire.php'?>
<main>
  <div class="container">
    <div class="row">
      <h3 class="col s12 center">Consultas</h3>
    </div>
    <div class="row">
      <div class="col s12" style="height: 100vh">
        <div id="calendar" style="height: 100%; width: 100%;"></div>
      </div>
      <?include '../includes/loading.php'?>
    </div>
  </div>
</main>
<?require '../includes/footer.php';?>
