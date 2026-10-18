<?php
session_start();
include('../functions/myfunction.php');
if(isset($_SESSION['authenticate']))
{
    unset($_SESSION['authenticate']);
    unset($_SESSION['auth_admin']);
    
}
redirect("adminRegister.php","Logged Out successful");
?>