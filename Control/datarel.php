<?php 
session_start();
$_SESSION['icepcp']['rel1']=$_POST['inicio'];
$_SESSION['icepcp']['rel2']=$_POST['fim'];
header('location:../');
?>  