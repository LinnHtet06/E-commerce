  </div><!-- page-body-wrapper -->
  </div><!-- container-scroller -->

  <!-- vendor.bundle.base.js contains jQuery and Bootstrap for the admin theme -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/js/uikit.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.uikit.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Searchable, sortable tables on pages that have one.
      if (window.DataTable && document.querySelector('#tableID')) {
        new DataTable('#tableID', { scrollX: true });
      }
      // Ask before deleting anything.
      document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
          if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
      });
      <?php flash_script(); ?>
    });
  </script>
</body>
</html>
