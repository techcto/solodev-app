/* Add here all your JS customizations */

/**
* Add a URL parameter 
* @param {string} url 
* @param {string} param the key to set
* @param {string} value 
*/
var addParam = function(url, param, value) {
  var a = document.createElement('a');
  param += (value ? "=" + value : ""); 
  a.href = url;
  if(a.search.indexOf(param) == -1){
    a.search += (a.search ? "&" : "") + param;
  }
  return a.href;
}

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

function function_exists(function_name)
{
    return eval('window.parent.typeof ' + function_name) === 'function';
}

/* ================================  
  # Toggle dropdowns - (Elena R.)
================================ */
var toClose = false;

function dropdownToggle(e) {
  e.stopPropagation();
  var btn = this;
  var menu = btn.nextSibling;

  while(menu && menu.nodeType != 1) {
    menu = menu.nextSibling;
  }

  // console.log(menu);
  if (!menu) return;
  if (menu.style.display !== 'block') {
    menu.style.display = 'block';
    if(toClose) menu.style.display="none";
    toClose  = menu;
  }  else {
    menu.style.display = 'none';
    toClose = false;
  }
};

function closeAll() {
   toClose.style.display='none';
   toClose = false;
};

window.onclick = function(event){
  if (toClose){
    closeAll.call(event.target);
  }
};
