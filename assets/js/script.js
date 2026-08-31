// Sweet Crumbs Cake Shop — front-end interactions

document.addEventListener('DOMContentLoaded', function () {

  // Confirm before destructive actions (delete product, cancel order, remove cart item)
  document.querySelectorAll('.sc-confirm').forEach(function (el) {
    el.addEventListener('submit', function (e) {
      const msg = el.getAttribute('data-confirm') || 'Are you sure?';
      if (!confirm(msg)) {
        e.preventDefault();
      }
    });
  });

  // Quantity steppers on product/detail/cart pages
  document.querySelectorAll('.sc-qty-box').forEach(function (box) {
    const input = box.querySelector('input[type="number"]');
    const minus = box.querySelector('.sc-qty-minus');
    const plus = box.querySelector('.sc-qty-plus');
    const max = parseInt(input.getAttribute('max') || '999', 10);

    minus.addEventListener('click', function () {
      let val = parseInt(input.value || '1', 10);
      if (val > 1) input.value = val - 1;
    });

    plus.addEventListener('click', function () {
      let val = parseInt(input.value || '1', 10);
      if (val < max) {
        input.value = val + 1;
      } else {
        input.value = max;
      }
    });
  });

  // Auto-dismiss alerts after 4 seconds
  document.querySelectorAll('.alert').forEach(function (alertEl) {
    setTimeout(function () {
      const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
      bsAlert.close();
    }, 4000);
  });
});
