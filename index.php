<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

if(!isset($_SESSION['icepcp']['user'])){
$_SESSION['icepcp']['pagina']='View/login.php';
}


    if (isset($_SESSION['icepcp']['erro'])){
        
        if ($_SESSION['icepcp']['erro']==true) {
          
         $script="<script>";
         $script.="alert('";
         $script.=$_SESSION['icepcp']['mensagem'];
         $script.="')";
         $script.="</script>";
         echo $script;
   
        }
        unset($_SESSION['icepcp']['erro']);
        
     }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (!isset($_SESSION['icepcp']['titulo'])) {
            echo "Braslar Refrigeração -PCP";
        } else {
            echo $_SESSION['icepcp']['titulo'];
        }
        ?>
    </title>
    <link rel="icon" type="image/x-icon" href="content/icone.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-icons.css">
    
   
</head>

<body>
    <div style="background-color:#333; color:#fff;margin-top:-8px; padding:0">
    <div class="container">
      <?php
        include('template/header.php');
    ?>  
    </div>
    </div>
    <div class="container">
        <?php 
        include($_SESSION['icepcp']['pagina']);
        ?>
    </div>
   

 
</body>

</html>