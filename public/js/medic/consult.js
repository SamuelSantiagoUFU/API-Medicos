document.addEventListener('DOMContentLoaded', function() {
  const consult = getParams('id');
  const loadingBar = document.getElementById('loading');
  $(loadingBar).show();
  fetch(apiLink+'/consult/get/'+consult, {credentials: 'include'})
    .then(data => data.json())
    .then((data) => {
      // exames
      const cardsContainer = document.getElementById('exams')
      data.exams.forEach((item, i) => {
        var content = document.createElement('div');
        content.classList.add('row');
        var col1 = document.createElement('div');
        col1.classList.add('col','s12','m6');
        col1.innerHTML = 'Quantidade: ' + item.qtd;
        var col2 = document.createElement('div');
        col2.classList.add('col','s12','m6');
        col2.innerHTML = 'Tipo: ' + item.type;
        appendChilds(content, [col1, col2]);
        var newCard = card({tam:'s12 m6 l3',title:item.description,content:content});
        cardsContainer.appendChild(newCard);
      });
  }).then(() => $(loadingBar).hide()).catch(error => console.error(error));
});
