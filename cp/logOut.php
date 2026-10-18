<?php
session_start();
include('functions/myfunction.php');
if(isset($_SESSION['auth']))
{
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
}
redirect("index.php","Logged Out successful");
?>