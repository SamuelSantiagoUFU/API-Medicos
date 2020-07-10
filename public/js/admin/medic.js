$(() => {
  loadTable();
});
$('#query').keydown((e) => {
  if (e.which == 13) {
    loadTable(e.target.value);
  }
});
function loadTable(query = '') {
  var table = document.getElementById('medicsTable');
  var body = table.tBodies[0];
  var loadingBar = document.getElementById('loading');
  $(body).empty();
  loading.classList.remove('hide')
  if (query != '') {
    query = '/' + query;
  }
  fetch(apiLink+'/medic/list' + query)
  .then((data) => data.json())
  .then((data) => {
    if (!data.code)
      M.toast({html: data.msg, classes: 'rounded red lighten-3 red-text text-darken-4'});
    else if (data.code == 200) {
      data.result.forEach((item, i) => {
        var row = document.createElement('tr');
        var id = document.createElement('td');
        var name = document.createElement('td');
        var sex = document.createElement('td');
        var type = document.createElement('td');
        var reg = document.createElement('td');
        var spec = document.createElement('td');
        var cns = document.createElement('td');
        var edit = document.createElement('td');
        id.innerHTML = item.id;
        name.innerHTML = item.title + ' ' + item.name;
        sex.innerHTML = item.sex;
        type.innerHTML = item.type || '-';
        reg.innerHTML = item.register +'-'+ item.uf;
        spec.innerHTML = item.clinic || '-';
        cns.innerHTML = item.cns || '-';

        var editButton = document.createElement('a');
        var blockButton = document.createElement('a');
        var editIcon = document.createElement('i');
        var blockIcon = document.createElement('i');
        editButton.href = "/admin/editMedic.php?medic="+item.id;
        blockButton.href = "#block";
        editButton.classList.add('btn','btn-small','blue','waves-effect','waves-light');
        blockButton.classList.add('btn','btn-small',(item.isActive?'red':'green'),'waves-effect','waves-light');
        editIcon.classList.add('material-icons');
        blockIcon.classList.add('material-icons');
        editIcon.innerHTML = 'edit';
        blockIcon.innerHTML = item.isActive?'perm_identity':'person';
        editButton.appendChild(editIcon);
        blockButton.appendChild(blockIcon);
        appendChilds(edit, [editButton, blockButton]);
        appendChilds(row, [id, name, sex, type, reg, spec, cns, edit]);
        body.appendChild(row);
      });
    }
  }).then(() => loading.classList.add('hide')).catch((error) => console.error(error));
}
