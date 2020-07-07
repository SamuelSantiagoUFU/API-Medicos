$(() => {
  loadTable();
});
function loadTable() {
  var table = document.getElementById('schedule');
  var body = table.tBodies[0];
  var loadingBar = document.getElementById('loading');
  $(body).empty();
  $(loadingBar).show();
  fetch('http://api.jefersson.net.br/schedule/list/'+window.medic, {credentials: 'include'})
  .then((data) => data.json())
  .then((data) => {
    if (!data.code)
      M.toast({html: data.msg, classes: 'rounded red lighten-3 red-text text-darken-4'});
    else if (data.code == 200) {
      var row = document.createElement('tr');
      for(var i = 0; i < 7; i++) {
        var day = document.createElement('td');
        var item = data.result[i] || null;
        if (!item) {
          var button = document.createElement('button');
          var icon = document.createElement('i');
          icon.classList.add('material-icons');
          icon.innerHTML = 'add';
          button.classList.add('btn','waves-effect','waves-light','blue','full-width');
          button.appendChild(icon);
          day.appendChild(button);
        } else {
          var init = item.hourInit.split(':').toNumber();
          var duration = item.duration.split(':').toNumber();
          var final = new Date();
          final.setHours(init[0] + duration[0]);
          final.setMinutes(init[1] + duration[1]);
          final.setSeconds(init[2] + duration[2]);
          day.innerHTML = 'Início: ' + item.hourInit + '<br>Final: ' + final.format("H:i:s");
        }
        row.appendChild(day);
      };
      body.appendChild(row);
    }
  }).then(() => $(loadingBar).hide()).catch((error) => console.error(error));
}
