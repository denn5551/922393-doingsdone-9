'use strict';

var $checkbox = document.querySelector('.show_completed');

if ($checkbox) {
  $checkbox.addEventListener('change', function (evt) {
    var is_checked = +evt.target.checked;

    window.location = window.location.href + '&show_completed=' + is_checked;
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

