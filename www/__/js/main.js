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

/* ================================  
  # Action Window
================================  */
function closeHelper() {
  $("#helperFrame").attr("src", "about:blank");
  //$("#helper").dialog("close");
  closeWait();
}

function enableSubmit(){
	$('.modal-confirm').removeAttr('disabled');
}

var activeWait = [];
var actionLoaded = false;

function setWait() {
  activeWait[activeWait.length] = 1;
  if (activeWait.length == 1) {
    $("#wait").dialog({
      resizable: false,
      show: 'fade',
      hide: 'fade',
      title: "Loading, please wait...",
      modal: true
    });

    $("#wait").dialog({
      show: 'fadeIn'
    });

    $("#wait").css("height", 100);
    $("#wait").css("width", 230);
  }
}

function arraySlice(array, from, to) {
  var rest = array.slice((to || from) + 1 || array.length);
  return rest;
}

function closeWait() {
  //Test to see if any wait functions have been called
  if (activeWait[0]) {
    activeWait = arraySlice(activeWait, activeWait.length, activeWait.length);
    //alert("remove slice");
    if (activeWait.length == 0) {
      $("#wait").dialog("close");
    }
  }
}

var currentTab;

/* ================================  
  # Panels from theme.js
================================ */
(function ($) {

  $(function () {
    $('.panel')
      .on('panel:toggle', function () {
        var $this,
        direction;

        $this = $(this);
        direction = $this.hasClass('panel-collapsed') ? 'Down' : 'Up';

        $this.find('.panel-body, .panel-footer')[ 'slide' + direction ](200, function () {
          $this[ (direction === 'Up' ? 'add' : 'remove') + 'Class' ]('panel-collapsed')
        });
      })
      .on('panel:dismiss', function () {
        var $this = $(this);

        if (!!($this.parent('div').attr('class') || '').match(/col-(xs|sm|md|lg)/g) && $this.siblings().length === 0) {
          $row = $this.closest('.row');
          $this.parent('div').remove();
          if ($row.children().length === 0) {
            $row.remove();
          }
        } else {
          $this.remove();
        }
      })
      .on('click', '[data-panel-toggle]', function (e) {
        e.preventDefault();
        $(this).closest('.panel').trigger('panel:toggle');
      })
      .on('click', '[data-panel-dismiss]', function (e) {
        e.preventDefault();
        $(this).closest('.panel').trigger('panel:dismiss');
      })
      /* Deprecated */
      .on('click', '.panel-actions a.fa-caret-up', function (e) {
        e.preventDefault();
        var $this = $(this);

        $this
          .removeClass('fa-caret-up')
          .addClass('fa-caret-down');

        $this.closest('.panel').trigger('panel:toggle');
      })
    .on('click', '.panel-actions a.fa-caret-down', function (e) {
      e.preventDefault();
      var $this = $(this);

      $this
        .removeClass('fa-caret-down')
        .addClass('fa-caret-up');

      $this.closest('.panel').trigger('panel:toggle');
    })
    .on('click', '.panel-actions a.fa-times', function (e) {
      e.preventDefault();
      var $this = $(this);

      $this.closest('.panel').trigger('panel:dismiss');
    })
    .on('click', 'header.panel-heading', function (e) {  //Greg - make the whole panel clickable
      e.preventDefault();
      var $this = $(this);

      $this.closest('.panel').trigger('panel:toggle');
    });
  });
})(jQuery);

/* ================================  
  # Bootstrap Toggle - theme.js
================================ */
(function ($) {

  'use strict';

  var $window = $(window);

  var toggleClass = function ($el) {
    if (!!$el.data('toggleClassBinded')) {
      return false;
    }

    var $target,
            className,
            eventName;

    $target = $($el.attr('data-target'));
    className = $el.attr('data-toggle-class');
    eventName = $el.attr('data-fire-event');


    $el.on('click.toggleClass', function (e) {
      e.preventDefault();
      $target.toggleClass(className);

      var hasClass = $target.hasClass(className);

      if (!!eventName) {
        $window.trigger(eventName, {
          added: hasClass,
          removed: !hasClass
        });
      }
      // TODO: $('#solodev-tabs').tabs() -- Move out of this file and into theme-custom.js
      $('#solodev-tabs').tabs(); // Added by CVL, kicks off JS resize of the container from EasyUI
    });

    $el.data('toggleClassBinded', true);

    return true;
  };

  $(function () {
    $('[data-toggle-class][data-target]').each(function () {
      toggleClass($(this));
    });
  });

})(jQuery);

(function ($) {
  $(function () {
    /* ================================  
      # Scrollable Navigation
    ================================ */
    $(".nano").nanoScroller();
    $('html').addClass("custom-scroll");

    /* ================================  
      # Dropdown / Search
    ================================ */
    $(".chosen-select").chosen({
      no_results_text: "Website not found!",
      width: '195px'
    });

    /* ================================  
      # Datepicker
    ================================ */
    $('#datetimepicker1').datetimepicker({format: 'MM/DD/YYYY hh:mm A', widgetPositioning: {vertical: 'bottom'}, icons: {time: "far fa-clock", date: "far fa-calendar-alt"}}).attr('autocomplete','off');
    $('#datetimepicker2').datetimepicker({format: 'MM/DD/YYYY hh:mm A', widgetPositioning: {vertical: 'bottom'}, icons: {time: "far fa-clock", date: "far fa-calendar-alt"}}).attr('autocomplete','off');
    $('.datetimepicker').datetimepicker({format: 'MM/DD/YYYY hh:mm A', widgetPositioning: {vertical: 'bottom'}, icons: {time: "far fa-clock", date: "far fa-calendar-alt"}}).attr('autocomplete','off');
    $('.datedatepicker').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: {vertical: 'bottom'}, icons: {time: "far fa-clock", date: "far fa-calendar-alt"}}).attr('autocomplete','off');
    
    /* ================================  
      # Apply the wysiwyg
    ================================ */
      $('.wysiwyg').each(function () {
        $(this).ckeditor({
          customConfig: '/__/js/ck/config.js',
          toolbar:'Basic',
        });
      });
      $('.wysiwyg-wp').each(function () {
        $(this).ckeditor({
          customConfig: '/__/js/ck/config.js',
          toolbar:'WP',
          height: '75vh'
        });
      });
      $('.wysiwyg-basic').each(function () {
        $(this).ckeditor({
          customConfig: '/__/js/ck/config.js',
          toolbar:'Basic',
          height:'200px'
        });
      });
      $('#solodev-tabs').find('iframe #mainArea').css('margin-left', '0');
  });
})(jQuery);


/* ================================  
  # Codemirror
================================ */
function applyCodemirror(htmlelement) {
  this._cmeditor = CodeMirror.fromTextArea(htmlelement, {
    mode: "javascript",
    lineNumbers: true,
    lineWrapping: true,
    styleActiveLine: true,
    matchBrackets: true,
    enableCodeFolding: true,
    enableCodeFormatting: true,
    electricChars:false,
    highlightSelectionMatches: true,
    smartIndent: false,
    autoRefresh: true
  });
  var keymap = {"Ctrl-F": "findPersistent"}
  this._cmeditor.addKeyMap(keymap);

  var refreshTime_cm = 0;

  this._cmeditor.on("keydown", function () {
    var nowTime_cm = parseInt(Math.round(new Date().getTime() / 1000));
    var timeCheck_cm = parseInt(nowTime_cm - refreshTime_cm);

    if(timeCheck_cm > 10 ){ //can be increased or descreased. just trying to limit the number of ajax calls.
      refreshTime_cm = nowTime_cm;
      //console.log('adsf');
      $.ajax({url: "/api.php/refresh", success: function(result){ }}); 
    }
  });
}

/* ================================  
  # Responsive navigation
================================ */
$(document).ready(function() {
  $(document).on('click','.sidenav-open',function() {
    $('.sidebar-left').addClass('active');
    $('.sidebar-left').addClass('fadeInLeft');
    $('.sidenav-close').addClass('open');
  });
  $(document).on('click','.sidenav-close',function() {
    $('.sidebar-left').removeClass('active');
    $('.sidebar-left').removeClass('fadeInLeft');
    $('.sidenav-close').removeClass('open');
  });
});