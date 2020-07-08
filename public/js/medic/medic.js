$(() => {
  loadTable();
});
function loadTable() {
  var tabs = document.getElementById('schedule');
  var loadingBar = document.getElementById('loading');
  loading.classList.remove('hide')
  fetch('http://api.jefersson.net.br/schedule/list/'+window.medic, {credentials: 'include'})
  .then((data) => data.json())
  .then((data) => {
    if (!data.code)
      M.toast({html: data.msg, classes: 'rounded red lighten-3 red-text text-darken-4'});
    else if (data.code == 200) {
      for(var i = 0, weekday = 0; weekday < 7; weekday++) {
        var day = document.createElement('div');
        var item = data.result[i] || null;
        day.id = 'day' + weekday;
        day.classList.add('hours');
        if (!item || item.weekday != weekday) {
          var button = document.createElement('button');
          var icon = document.createElement('i');
          icon.classList.add('material-icons');
          icon.innerHTML = 'add';
          button.classList.add('btn','btn-large','waves-effect','waves-light','blue','full-width');
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
          i++;
        }
        tabs.insertAfter(day);
      }
      var instance = M.Tabs.init(tabs, {swipeable:true});
    }
  }).then(() => loading.classList.add('hide')).catch((error) => console.error(error));
}
