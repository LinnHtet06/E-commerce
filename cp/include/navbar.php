<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <?php
        if(isset($_SESSION['auth']))
        {
          ?>
          <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <?= $_SESSION['auth_user']['c_name'];?>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="logOut.php">LogOut</a></li>
                  </ul>
                </li>
          <?php
        }
        else
        {
          ?>
          <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="loginUi.php">LogIN</a>
        </li>
        <?php
        }
        ?>
        
        
      </ul>
    </div>
  </div>
</nav> -->

<!-- //nav2 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">DIOR</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        <a class="nav-link" aria-current="page" href="#">Men</a>
        <a class="nav-link" aria-current="page" href="#">Women</a>
        <!-- Cart -->
        <?php 
        if(isset($_SESSION['auth'])){
        ?>
          <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-bag"></i></button>
          <?php }?>
        <a class="nav-link" aria-current="page" href="wishUi.php"><i class="fa bi bi-heart"></i></a>
        
        <?php
        if(isset($_SESSION['auth']))
        {
          ?>
          <a class="nav-link" href="#"><i class="bi bi-person"></i>-<?= $_SESSION['auth_user']['c_name'];?></a>
          <a class="nav-link" href="myOrder.php">My Orders</a>
          <a class="nav-link" href="logOut.php">LogOut</a>
          <?php
        }
        else
        {
          ?>
    <a class="nav-link" href="register.php">Register</a>
    <a class="nav-link" href="loginUi.php">Login</a>
        <?php
        }
        ?>
         
      </div>
    </div>
  </div>
</nav>