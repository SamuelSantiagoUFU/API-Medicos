document.addEventListener('DOMContentLoaded', () => {
  var fields = document.getElementsByTagName('input');
  for (var field of fields) {
    if (field.value)
      field.classList.add('valid');
    else if (field.required)
      field.classList.add('invalid');
  }
  var edit = document.getElementById("formulario");
  edit.addEventListener('submit', (e) => {
    console.clear();
    e.preventDefault();
    var data = new FormData(edit);
    fetch(apiLink+'/medic/put', {
      method: "POST",
      body: data,
      credentials: 'include'
    }).then(data => data.json())
    .then(data => {
      M.toast({html: data.msg})
    }).catch(error => console.error(error));
  });
});
