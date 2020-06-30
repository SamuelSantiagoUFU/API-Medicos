function appendChilds(el, childs) {
  var _this = el;
  childs.forEach((item, i) => {
    _this.appendChild(item);
  });
  return _this;
}
