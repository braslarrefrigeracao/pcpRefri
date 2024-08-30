<?php
if(!isset($_SESSION['icepcp']['diapcp'])){
    $diapcp = new DateTime('now');
}else{
    $diapcp = new DateTime($_SESSION['icepcp']['diapcp']);
}
?>
<div id="placar" class="container  text-center" style="width: 50%;">
    <div class="row">
        <div class="col">
            <div class="bg-dark text-bg-dark d-flex flex-column justify-content-center align-items-center m-1" style="min-height: 150px;">  
                <h3>Total</h3>
                <h1 id="numPlacar">0</h1>
            </div>
        </div>
        <div class="col p-1 m-1">
            <div class="m-1 p-1">
                <h6>Dia Ativo: <?php echo $diapcp->format('d/m/Y')?> </h6>
            </div>
            <form action="Control/datapcp.php" method="post">
                <div class="input-group m-1 p-1">
                    <input type="date" name="diapcp" class="form form-control" value="<?php echo $diapcp->format('Y-m-d')?>" required>
                </div>
                <div class="input-group m-1 p-1">
                    <input type="submit" value="Mude a data" class="btn btn-success">
                </div>
                </form>
            </div>
        </div>
<div class="container" style="font-size:small">
    <table class="table table-sm table-light table-striped table-bordered">
        <thead class="text-center">
            <th>Código</th>
            <th>Modelo</th>
            <th>Descricão</th>
            <th>Quantidade</th>
            <th>Valor</th>
        </thead>
        <tbody id="tbplacar">

        </tbody>

    </table>
</div>

<script>
    async function totaldia(dia){
        const url = "http://localhost/apiCold/valorTotalDia/"+dia       
        const data = await fetch(url)
        const dado = await data.json()
        const d = document.getElementById('numPlacar')
        d.innerText = dado.total
    }
    totaldia('<?php echo $diapcp->format('Y-m-d')?>')

    async function montatabela(dia) {
    const url = "http://localhost/apiCold/produzidosDia/" + dia;
    console.log(url);
    
    try {
        const response = await fetch(url);
        const dado = await response.json();
        const d = document.getElementById('tbplacar');
        d.innerHTML = ''; // Usar innerHTML para remover todos os elementos

        dado.forEach((item) => {
            const tr = document.createElement('tr');
            
            const codigo = document.createElement('td');
            const modelo = document.createElement('td');
            const descricao = document.createElement('td');
            const quantidade = document.createElement('td');
            const valor = document.createElement('td');

            // Preenchendo os dados das células
            codigo.innerText = item.codigo;
            modelo.innerText = item.modelo; // Adicionar os outros itens aqui
            descricao.innerText = item.descricao;
            quantidade.innerText = item.total;
            let soma = item.total * item.valor
            valor.innerText = soma;
            // Adicionando as células à linha
            tr.appendChild(codigo);
            tr.appendChild(modelo);
            tr.appendChild(descricao);
            tr.appendChild(quantidade);
            tr.appendChild(valor);

            // Adicionando a linha ao corpo da tabela
            d.appendChild(tr);
        });
    } catch (error) {
        console.error('Erro ao carregar os dados:', error);
    }
}

// Chamar a função com a data do PHP
montatabela('<?php echo $diapcp->format('Y-m-d')?>');

    
</script>