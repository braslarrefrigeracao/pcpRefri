<?php 
session_start();
$teste=false;
if(isset($_SESSION['icepcp']['logado'])){
    if(isset($_SESSION['icepcp']['nivel'])){
        if($_SESSION['icepcp']['nivel']==0){
        $teste=true;
        }  
    }
}
if($teste){
    $_SESSION['icepcp']['pagina']='View/produtos.php';
}


header('location:../');
?>