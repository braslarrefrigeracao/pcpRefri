<?php
if (!isset($_SESSION['icepcp']['diapcp'])) {
    $diapcp = new DateTime('now');
} else {
    $diapcp = new DateTime($_SESSION['icepcp']['diapcp']);
}
?>
<div class="container p-2 m-2">
    <!-- formulario  CADASTRO-->
    <form id="cad_programacao">
        <fieldset class="bg-dark text-white p-2">Insere Programação
            <div class="input-group input-group-sm p-1 m-1">
                <label for="linha" class="input-group-text">Linha</label>
                <select name="linhas" class="form-select" id="linhas" required>

                </select>
            </div>
            <div class="input-group input-group-sm p-1 m-1">
                <label for="produto" class="input-group-text">Produto</label>
                <input type="text" id="produto" class="form form-control" autofocus required minlength="5" maxlength="8">
                <label for="quantidade" class="input-group-text">Quantidade</label>
                <input type="text" id="quantidade" class="form form-control" required>

            </div>
            <div class="input-group input-group-sm p-1 m-1">
                <label for="horainicio" class="input-group-text">Hora Início</label>
                <input type="time" value="07:40" id="horainicio" class="form form-control" required>
                <label for="horafim" class="input-group-text">Hora Fim</label>
                <input type="time" value="17:10" id="horafim" class="form form-control" required>
                <label for="obs" class="input-group-text">Observação</label>
                <input type="text" id="obs" class="form form-control">


            </div>
            <div class="input-group input-group-sm p-1 m-1">
                <input type="submit" value="CADASTRA" class="btn btn-success">

            </div>
        </fieldset>
    </form>
    <!-- formulario -->
</div>
<div class="container">
    <table class="table table=bg-light table-striped table-bordered" style="font-size:small">
        <thead class="text-center">
            <tr>
                <th colspan="9">Dia ativo: <?php echo $diapcp->format('d/m/Y') ?></th>
            </tr>
            <tr>
                <th>Intervalo</th>
                <th>Código</th>
                <th>Modelo</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Produzido</th>
                <th>Observação</th>
                <th>Eficiência</th>
                <th>Operação</th>
            </tr>
        </thead>
        <tbody id="corpo">

        </tbody>

    </table>
</div>
<script>
    document.getElementById('cad_programacao').addEventListener('submit', function(event) {
        // Prevenir o comportamento padrão do formulário
        event.preventDefault();


        const linha = document.getElementById('linhas').value;
        const produto = document.getElementById('produto').value;
        const quantidade = document.getElementById('quantidade').value;
        const inicio = document.getElementById('horainicio').value;
        const fim = document.getElementById('horafim').value;
        let obs = document.getElementById('obs').value;
        if (obs == '') {
            obs = "nulo";
        }
        cadastro(produto, linha, quantidade, inicio, fim, '<?php echo $diapcp->format('Y-m-d') ?>', obs)

        document.getElementById('produto').value = '';
        document.getElementById('quantidade').value = '';
        document.getElementById('obs').value = '';
        document.getElementById('produto').focus();
        tabela()


    });

    // Função de cadastro (simulação)
    async function linhas() {
        const url = "http://localhost/apicold/linhas/"
        const request = await fetch(url)
        const data = await request.json()
        const linha = document.getElementById('linhas')
        data.forEach((item) => {
            const op = document.createElement('option')
            op.innerText = item.linha
            op.value = item.id
            linha.appendChild(op)

        })
    }


    async function cadastro(codigo, linha, quantidade, hini, hfim, dia, obs) {

        const url = "http://localhost/apicold/postProgramacao/" + codigo + "/" + linha + "/" + hini + "/" + hfim + "/" + dia + "/" + quantidade + "/" + obs
        const response = await fetch(url)
    }

    async function total_produzido(linha, codigo) {
        const dia = '<?php echo $diapcp->format('Y-m-d') ?>';
        const url = "http://localhost/apicold/getProgramacao/" + dia + "/" + linha.replace(' ', '_') + "/" + codigo
        const request = await fetch(url)
        const data = await request.json()
        return data[0].total;
    }

    async function tabela() {
    const dia = '<?php echo $diapcp->format('Y-m-d') ?>';
    const url = "http://localhost/apicold/programacao/" + dia;
    const response = await fetch(url);
    const dados = await response.json();

    const linhas = dados.reduce((acumulador, item) => {
        if (!acumulador.includes(item.linha)) {
            acumulador.push(item.linha);
        }
        return acumulador;
    }, []);

    /* elementos da tabela */
    const corpo = document.getElementById('corpo');
    
    for (const linha of linhas) {
        const existeLinha = dados.some(item => item.linha === linha);
        if (existeLinha) {
            const trh = document.createElement('tr');
            const tdh = document.createElement('td');
            tdh.colSpan = 9;
            tdh.className = "text-center bg-dark text-bg-dark";
            tdh.innerText = linha;
            trh.appendChild(tdh);
            corpo.appendChild(trh);

            for (const item of dados) {
                if (item.linha === linha) {
                    const rowP = document.createElement('tr');
                    const td1 = document.createElement('td');
                    const td2 = document.createElement('td');
                    const td3 = document.createElement('td');
                    const td4 = document.createElement('td');
                    const td5 = document.createElement('td');
                    const td6 = document.createElement('td');
                    const td7 = document.createElement('td');
                    const td8 = document.createElement('td');
                    const td9 = document.createElement('td');
                    let eficiencia = 0
                    const produzido = await total_produzido(linha, item.codigo);  // await aqui só funciona em um loop assíncrono
                    if(produzido>0){
                        eficiencia = (produzido/item.quantidade )*100
                    }else{
                        eficiencia = 0
                    }
                    let obs = item.observacao || '';  // se undefined, atribui ''
                    td5.className = "text-end";
                    td6.className = "text-end";
                    td8.className = "text-end";

                    td1.innerText = item.horainicio + "-" + item.horafim;
                    td2.innerText = item.codigo;
                    td3.innerText = item.modelo;
                    td4.innerText = item.descricao;
                    td5.innerText = item.quantidade;
                    td6.innerText = produzido;
                    td7.innerText = obs;
                    td8.innerText = eficiencia.toFixed(1).replace('.',',')+' %'
                    td9.innerHTML = "<a href='Control/apagaPrograma.php?id=" + item.idprogramacao + "' class='btn btn-primary'><i class='bi bi-trash'></i></a>";

                    rowP.appendChild(td1);
                    rowP.appendChild(td2);
                    rowP.appendChild(td3);
                    rowP.appendChild(td4);
                    rowP.appendChild(td5);
                    rowP.appendChild(td6);
                    rowP.appendChild(td7);
                    rowP.appendChild(td8);
                    rowP.appendChild(td9);

                    corpo.appendChild(rowP);
                }
            }
        }
    }
}

    linhas()
    tabela()
</script>