$(() => {
  loadTable();
});
$('#query').keydown((e) => {
  if (e.which == 13) {
    loadTable(e.target.value);
  }
});
function loadTable(query = '') {
  var table = document.getElementById('pacientsTable');
  var body = table.tBodies[0];
  var loadingBar = document.getElementById('loading');
  $(body).empty();
  $(loadingBar).show();
  if (query != '') {
    query = '/' + query;
  }
  fetch('http://api.jefersson.net.br/pacient/list' + query)
  .then((data) => data.json())
  .then((data) => {
    if (!data.code)
      M.toast({html: data.msg, classes: 'rounded red lighten-3 red-text text-darken-4'});
    else if (data.code == 200) {
      data.result.forEach((item, i) => {
        fetch('https://maps.googleapis.com/maps/api/geocode/json?latlng='+item.lat+','+item.lng+'&key=AIzaSyCCgJgOP49oSDKdTmfI3s6HXdozi9U_8xE')
        .then(data => data.json()).then((data) => {
          var address = data.results[0].formatted_address;
          var row = document.createElement('tr');
          var id = document.createElement('td');
          var name = document.createElement('td');
          var sex = document.createElement('td');
          var tel = document.createElement('td');
          var end = document.createElement('td');
          var born = document.createElement('td');
          var email = document.createElement('td');
          var edit = document.createElement('td');
          id.innerHTML = item.id;
          name.innerHTML = item.name;
          sex.innerHTML = item.sex;
          tel.innerHTML = item.phone || '-';
          end.innerHTML = address;
          born.innerHTML = item.born || '-';
          email.innerHTML = item.email || '-';

          var editButton = document.createElement('button');
          var blockButton = document.createElement('button');
          var editIcon = document.createElement('i');
          var blockIcon = document.createElement('i');
          editButton.classList.add('btn','btn-small','blue','waves-effect','waves-light');
          blockButton.classList.add('btn','btn-small',(item.isActive?'red':'green'),'waves-effect','waves-light');
          editIcon.classList.add('material-icons');
          blockIcon.classList.add('material-icons');
          editIcon.innerHTML = 'edit';
          blockIcon.innerHTML = item.isActive?'perm_identity':'person';
          editButton.appendChild(editIcon);
          blockButton.appendChild(blockIcon);
          appendChilds(edit, [editButton, blockButton]);
          appendChilds(row, [id, name, sex, tel, end, born, email, edit]);
          body.appendChild(row);
          $(loadingBar).hide();
        }).catch((error) => M.toast({html: error.message, classes: 'rounded red-text'}));
      });
    }
    $(loadingBar).hide();
  }).catch((error) => console.error(error));
}
