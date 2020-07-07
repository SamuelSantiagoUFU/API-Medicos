<?$title="Horários";$js=["medic/MindFusion.Scheduling.js","medic/GoogleSchedule.js","medic/TimeForm.js"];
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
<?require '../includes/footer.php';?>
