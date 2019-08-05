'use strict';

var $checkbox = document.querySelector('.show_completed');

var arUrl1 = window.location.pathname.split('/');

var arUrl = window.location.search.split('&');

if ($checkbox) {
  $checkbox.addEventListener('change', function (evt) {
    var is_checked = +evt.target.checked;
    window.location = window.location.href + '&show_completed=' + is_checked;
  });
}

if (arUrl[3] === 'show_completed=1') {
  $checkbox.addEventListener('change', function (evt) {
    var is_checked = +evt.target.checked;
    window.location = 'http://mybisnes.local/' + arUrl1[1] + arUrl[0] + '&' + arUrl[1] + '&' + arUrl[2];

  });
} else if(arUrl[2] === 'show_completed=1') {
  $checkbox.addEventListener('change', function (evt) {
    var is_checked = +evt.target.checked;
    window.location = 'http://mybisnes.local/' + arUrl1[1] + arUrl[0] + '&' + arUrl[1];
  });
}

var $taskTable = document.querySelector('.tasks');

if ($taskTable) {

  $taskTable.addEventListener('change', function (evt) {
    if (evt.target.classList.contains('checkbox__input')) {
      var el = evt.target;

      var is_checked = +el.checked;
      var task_id = el.getAttribute('value');

      var url = 'index.php?task_id=' + task_id + '&check=' + is_checked;
      window.location = url;
    }
  });
}

flatpickr('#date', {
  enableTime: false,
  dateFormat: "Y-m-d",
  locale: "ru"
});

// Автоматическое закрытие алертов
$(document).ready(function () {
  window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
      $(this).remove();
    });
  }, 5000);

});

// Выбираем файл
$(document).ready(function() {

  $('input[type="file"]').change(function(){
    var value = $("input[type='file']").val();
    $('.js-value').text(value);
  });

});
