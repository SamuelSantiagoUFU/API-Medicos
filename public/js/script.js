const apiLink = ""; // Colocar o link para a pasta da api aqui
const timepickerOptions = {
  twelveHour: false
}
const datepickerOptions = {
  minDate: new Date(),
  defaultDate: new Date(),
  i18n: {
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
    today: 'Hoje',
    clear: 'Limpar',
    cancel: 'Sair',
    done: 'Confirmar'
  },
  format: 'dd mmmm, yyyy',
  parse: (e) => {
    return e.format('Y-m-d')
  }
}
function appendChilds(el, childs) {
  var _this = el;
  childs.forEach((item, i) => {
    _this.appendChild(item);
  });
  return _this;
}
function card(options = {tam:'s12 m6',bg:'blue-grey darken-1',color:'white',title:'',content:'',actions:[]}) {
  if (!options.tam) options.tam = 's12 m6';
  if (!options.bg) options.bg = 'blue-grey darken-1';
  if (!options.color) options.color = 'white';
  if (!options.title) options.title = '';
  if (!options.content) options.content = '';
  if (!options.actions) options.actions = [];

  const tam = options.tam.split(' ')
  const bg = options.bg.split(' ')
  tam.push('col');
  bg.push('card');
  var cardParent = document.createElement('div');
  var card = document.createElement('div');
  var content = document.createElement('div');
  var title = document.createElement('span');
  var p = document.createElement('p');

  tam.forEach((item, i) => {
    cardParent.classList.add(item);
  });
  bg.forEach((item, i) => {
    card.classList.add(item);
  });
  content.classList.add('card-content',options.color+'-text');
  title.classList.add('card-title');
  title.innerHTML = options.title;
  if (typeof options.content == 'string')
    p.innerHTML = options.content;
  else
    p.appendChild(options.content);
  appendChilds(content, [title, p]);
  card.appendChild(content);

  if (options.actions.length > 0) {
    var actionDiv = document.createElement('div');
    for (var action of options.actions) {
      var link = document.createElement('a');
      a.href = action.link;
      a.innerHTML = action.text;
      actionDiv.appendChild(a);
    }
    card.appendChild(actionDiv);
  }
  cardParent.appendChild(card);

  return cardParent;
}
document.addEventListener('DOMContentLoaded', function() {
  M.AutoInit();
  var sidenav = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(sidenav, {edge:'right'});
});
Date.prototype.format = function(format = 'Y-m-d H:i:s') {
  var date = new Date(this.valueOf());
  var formatted = '';
  for (var i = 0; i < format.length; i++) {
    formatted += date.getStringDate(format[i]);
  }
  return formatted;
}
Date.prototype.getStringDate = function(string) {
  var date = new Date(this.valueOf());
  if (string == 'Y') {
    return date.getFullYear();
  }
  if (string == 'm') {
    return (date.getMonth()+1).toString().padStart(2, '0');
  }
  if (string == 'd') {
    return date.getDate().toString().padStart(2, '0');
  }
  if (string == 'H') {
    return date.getHours().toString().padStart(2, '0');
  }
  if (string == 'i') {
    return date.getMinutes().toString().padStart(2, '0');
  }
  if (string == 's') {
    return date.getSeconds().toString().padStart(2, '0');
  }
  return string;
}
Node.prototype.insertAfter = function(newNode) {
  this.parentNode.insertBefore(newNode, this.nextSibling);
  return this;
}
Array.prototype.toNumber = function() {
  for (var i = 0; i < this.length; i++) {
    this[i] = Number(this[i]);
  }
  return this;
}
function getParams(param) {
  var query = location.search.slice(1);
  var partes = query.split('&');
  var data = {};
  partes.forEach(function (parte) {
      var chaveValor = parte.split('=');
      var chave = chaveValor[0];
      var valor = chaveValor[1];
      data[chave] = valor;
  });
  if (param) return data[param];
  return data;
}
