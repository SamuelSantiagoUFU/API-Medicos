$(() => {
  var table = document.getElementById('medicsTable');
  var loadingBar = document.getElementById('loading');
  fetch('http://api.jefersson.net.br/medic/list')
  .then((data) => data.json())
  .then((data) => {
    loadingBar.style.display = "none";
    M.toast({html: data.msg, classes: 'rounded'});
  }).catch((error) => console.error(error));
});
