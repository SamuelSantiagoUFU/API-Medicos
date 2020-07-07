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
