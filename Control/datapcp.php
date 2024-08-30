<?php 
session_start();
$_SESSION['icepcp']['diapcp']=$_POST['diapcp'];
header('location:../');
?>