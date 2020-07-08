document.addEventListener('DOMContentLoaded', function() {
  getSpecs();
  var datepickers = document.querySelectorAll('.datepicker');
  var instancesD = M.Datepicker.init(datepickers, datepickerOptions);
  var timepickers = document.querySelectorAll('.timepicker');
  var instancesT = M.Timepicker.init(timepickers, timepickerOptions);
  var edit = document.getElementById("consulta");
  edit.addEventListener('submit', (e) => {
    console.clear();
    e.preventDefault();
    var data = new FormData(edit);
    data.set('data', M.Datepicker.getInstance($('#data')).date.format('Y-m-d'));
    fetch(apiLink+'/medic/list/area/8', {
      method: "POST",
      body: data,
      credentials: 'include'
    }).then(data => console.log(data.json()))
    .then(data => {
      console.log(data);
      M.toast({html: data.msg})
    }).catch(error => console.error(error));
  });
});
function getSpecs() {
  var specs = {};
  fetch(apiLink + '/medic/list', {credentials: 'include'})
    .then(data => data.json())
    .then((data) => {
      if (data.total > 0) {
        data.result.forEach((item, i) => {
          specs[item.clinic] = null;
        });
      }
  }).then(() => {
    var autocomplete = document.querySelectorAll('.autocomplete');
    var instances = M.Autocomplete.init(autocomplete, {
      data: specs
    });
  }).catch(error => console.error(error));
}
