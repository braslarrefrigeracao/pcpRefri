<?php 
session_start();
try{
    $url = 'http://localhost/apicold/getUser/'.$_POST['nick'].'/'.$_POST['senha'];
$dados = file_get_contents($url);
$dados = json_decode($dados, true);

    if (is_array($dados)) {
     if (count($dados)==2&&$dados['nivel']==0) {
    $_SESSION['icepcp']['pagina']='View/placar.php';
    $_SESSION['icepcp']['user']=$dados['user'];
    $_SESSION['icepcp']['nivel']=$dados['nivel'];
    $_SESSION['icepcp']['logado']=true;
} else{
    $_SESSION['icepcp']['erro']=true;
    $_SESSION['icepcp']['mensagem']="Usuário não possui permissão";

}   
    }else{
        $_SESSION['icepcp']['erro']=true;
        $_SESSION['icepcp']['mensagem']="Teste a url {$url}";   
    }

}catch(Exception $e){
    $_SESSION['icepcp']['erro']=true;
    $_SESSION['icepcp']['mensagem']="Teste a url {$url}";


}

header('location:../');
?>