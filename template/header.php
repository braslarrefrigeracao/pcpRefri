<div class="container m-2 p-2">
    <div class="container m2-p-2">
        <div class="row">
            <div class="col-3">
                <img src="content/logobranco.png" width="200px;" class="">
            </div>
            <div class="col-6">
            </div>
            <div class="col-3">
                <a href="Control/sair.php" class="btn btn-sm btn-warning">Sair</a>
            </div>
        </div>
    </div>
</div>
<?php 
if(isset($_SESSION['icepcp']['logado'])){
    ?>
    <header>
    <ul class="nav justify-content-center">
      <li class="nav-item">
          <a class="nav-link  link-light" href="Control/placar.php"><i class="bi bi-check2-circle"></i> Placar</a>
          </li>
      <li class="nav-item">
        <a class="nav-link link-light" href="Control/programacao.php"><i class="bi bi-clipboard-check"></i> Programação</a>
      </li>
      <li class="nav-item">
        <a class="nav-link link-light" href="Control/produtos.php"><i class="bi bi-device-ssd"></i> Produtos</a>
      </li>
      <li class="nav-item link-light">
        <a class="nav-link  link-light" href="Control/linhas.php"><i class="bi bi-hammer"></i> Linhas</a>
      </li>
      <li class="nav-item link-light">
        <a class="nav-link  link-light" href="Control/apontamento.php"><i class="bi bi-bar-chart-steps"></i> Apontamento</a>
      </li>
      <li class="nav-item link-light">
        <a class="nav-link  link-light" href="Control/relatorio.php"><i class="bi bi-list-task"></i> Relatórios</a>
      </li>
    </ul>
      </header>     
    <?php
}
?>
