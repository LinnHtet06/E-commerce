<?php 
if(!isset($_SESSION['auth']))
{
    header("Location: index.php");
    redirect("loginUi.php","Log in to continue");
}
?>