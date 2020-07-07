const apiLink = "http://api.jefersson.net.br";
function appendChilds(el, childs) {
  var _this = el;
  childs.forEach((item, i) => {
    _this.appendChild(item);
  });
  return _this;
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
Array.prototype.toNumber = function() {
  for (var i = 0; i < this.length; i++) {
    this[i] = Number(this[i]);
  }
  return this;
}
