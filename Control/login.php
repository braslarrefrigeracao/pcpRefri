<?php 
session_start();
$dados = file_get_contents('http://localhost/apicold/getUser/'.$_POST['nick'].'/'.$_POST['senha']);
$dados = json_decode($dados, true);
try{
    if (is_array($dados)) {
        # code...
    }
if (count($dados)==2&&$dados['nivel']==0) {
    $_SESSION['ice']['pagina']='View/placar.php';
    $_SESSION['ice']['user']=$dados['user'];
    $_SESSION['ice']['nivel']=$dados['nivel'];
    $_SESSION['ice']['logado']=true;
} else{
    $_SESSION['ice']['erro']=true;
    $_SESSION['ice']['mensagem']="Usuário não possui permissão";

}
}catch(Exception $e){
    echo 'erro';

}

header('location:../');
?>