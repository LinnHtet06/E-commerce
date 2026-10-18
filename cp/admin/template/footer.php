
<!-- <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer> -->

          

	<!-- Data Table -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/js/uikit.min.js" defer></script>
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js" defer></script>
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.uikit.js" defer></script>

   
    <script src="assets/vendors/js/vendor.bundle.base.js" defer></script>
 
    <!-- endinject -->
    <!-- Plugin js for this page --> 
    <script src="assets/vendors/chart.js/Chart.min.js" defer></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js" defer></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js" defer></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" defer></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js" defer></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js" defer></script>
    <script src="assets/js/hoverable-collapse.js" defer></script>
    <script src="assets/js/misc.js" defer></script>
    <script src="assets/js/settings.js" defer></script>
    <script src="assets/js/todolist.js" defer></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js" defer></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js" defer></script>
    <script  src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script> 
new DataTable('#tableID');
</script> 
    
    <script>
      <?php 
      
      if(isset($_SESSION['message'])) {?>
      alertify.set('notifier','position', 'top-right');
      alertify.success('<?= $_SESSION['message']; ?>');

  <?php 
   unset($_SESSION['message']);
} ?>
    </script>
