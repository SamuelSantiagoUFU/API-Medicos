document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.modal');
  var instances = M.Modal.init($('.modal'), {
    onCloseEnd: function() {
      $('#exame h4').text('Novo exame');
      $('#exam').each (function(){
        this.reset();
      });
    }
  });
  const consult = getParams('id');
  const loadingBar = document.getElementById('loading');
  $(loadingBar).show();
  fetch(apiLink+'/consult/get/'+consult, {credentials: 'include'})
    .then(data => data.json())
    .then((data) => {
      if (data.code == 0)
        M.toast({html: data.msg, classes: 'rounded red lighten-3 red-text text-darken-4'});
      else {
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
          newCard.addEventListener('dblclick', (e) => {editExam(item.id, e)});
          cardsContainer.appendChild(newCard);
        });
      }
  }).then(() => $(loadingBar).hide()).catch(error => console.error(error));
});

function editExam(id, e) {
  e.preventDefault();
  fetch(apiLink+'/exam/get/'+id, {credentials: 'include'})
    .then(data => data.json())
    .then(data => {
      if (data.code == 0)
        M.toast({html: data.msg, classes: 'rounded red lighten-3 red-text text-darken-4'});
      else {
        var input = document.getElementById('id');
        if (!input)
          input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.id = 'id';
        input.value = id;
        document.getElementById('exam').appendChild(input);
        $('#desc').val(data.description);
        $('#qtd').val(data.qtd);
        $('#type').val($('#type option:contains("'+data.type+'")').val());
        var instances = M.FormSelect.init($('#type'));
        M.updateTextFields();
        var modal = M.Modal.getInstance($('#exame'));
        $('#exame h4').text('Editar exame');
        modal.open();
      }
    }).catch(error => console.error(error));
}
