<?php
if (!isset($_SESSION['icepcp']['rel1'])) {
    $d1 = new DateTime('now');
    $d2 = new DateTime('now');
} else {
    $d1 = new DateTime($_SESSION['icepcp']['rel1']);
    $d2 = new DateTime($_SESSION['icepcp']['rel2']);
}
?>

<div id="placar" class="container  text-center" style="width: 80%;">
    <div class="row">
        <div class="col">
            <div class="bg-dark text-bg-dark d-flex flex-column justify-content-center align-items-center m-1" style="min-height: 150px;">
                <h3>Total</h3>
                <h1 id="numPlacar">0</h1>
            </div>
        </div>
        <div class="col p-1 m-1">
            <div class="m-1 p-1">
                <h6>Data Inicial: <?php echo $d1->format('d/m/Y') ?> </h6>
                <h6>Data Final: <?php echo $d2->format('d/m/Y') ?> </h6>
            </div>
            <form action="Control/datarel.php" method="post">
                <div class="input-group m-1 p-1">
                    <input type="date" name="inicio" class="form form-control" value="<?php echo $d1->format('Y-m-d') ?>" required>
                </div>
                <div class="input-group m-1 p-1">
                    <input type="date" name="fim" class="form form-control" value="<?php echo $d2->format('Y-m-d') ?>" required>
                </div>
                <div class="input-group m-1 p-1">
                    <input type="submit" value="Mude a data" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
    <div class="container" style="font-size:small">
        <table class="table table-sm table-light table-striped table-bordered" style="font-size=small">
            <thead class="text-center">
                <th>Código</th>
                <th>Modelo</th>
                <th>Descricão</th>
                <th>Produzido</th>
                <th>Programado</th>
                <th>Eficiência</th>
            </thead>
            <tbody id="tbrelatorio">

            </tbody>

        </table>
    </div>

    <script>
        async function montatabela() {
            const dia1 = '<?php echo $d1->format('Y-m-d') ?>'
            const dia2 = '<?php echo $d2->format('Y-m-d') ?>'
            const url = "http://localhost/apiCold/dadosProducao/" + dia1 + "/" + dia2;


            const response = await fetch(url);
            const dado = await response.json();
            const d = document.getElementById('tbrelatorio');
            d.innerHTML = ''; // Usar innerHTML para remover todos os elementos

            for (const item of dado) {
                const tr = document.createElement('tr');

                const codigo = document.createElement('td');
                const modelo = document.createElement('td');
                const descricao = document.createElement('td');
                const quantidade = document.createElement('td');
                const produzido = document.createElement('td');
                const pro = document.createElement('td');
                const eficiencia = document.createElement('td');
                quantidade.className = 'text-end'
                produzido.produzido = 'text-end'
                eficiencia.eficiencia = 'text-end'
                pro.eficiencia = 'text-end'
                n_prog = await programados(item.codigo)
                let v_programado = 0
                if (n_prog !== undefined) {
                    if (n_prog > 0) {
                        v_programado = n_prog
                    } else {
                        v_programado = 0
                    }
                }
                let p_eficiencia =0
                if(v_programado>0){
                    p_eficiencia = (item.total /v_programado)*100
                }

                // Preenchendo os dados das células
                codigo.innerText = item.codigo;
                modelo.innerText = item.modelo; // Adicionar os outros itens aqui
                descricao.innerText = item.descricao;
                quantidade.innerText = item.total;
                pro.innerText = v_programado;
                eficiencia.innerText = p_eficiencia.toFixed(1).replace('.',',')+" %"


                // Adicionando as células à linha
                tr.appendChild(codigo);
                tr.appendChild(modelo);
                tr.appendChild(descricao);
                tr.appendChild(quantidade);
                tr.appendChild(pro);
                tr.appendChild(eficiencia);


                // Adicionando a linha ao corpo da tabela
                d.appendChild(tr);
            }



        }
        async function programados(codigo) {
            const dia1 = '<?php echo $d1->format('Y-m-d') ?>'
            const dia2 = '<?php echo $d2->format('Y-m-d') ?>'
            const url = "http://localhost/apiCold/dadosProgramados/" + dia1 + "/" + dia2 + "/" + codigo;


            const response = await fetch(url);
            const dado = await response.json();
            return dado[0].total;


        }
        async function totaldatas() {
            const dia1 = '<?php echo $d1->format('Y-m-d') ?>'
            const dia2 = '<?php echo $d2->format('Y-m-d') ?>'
            const url = "http://localhost/apiCold/totalDatas/" + dia1 + "/" + dia2;
            

            const response = await fetch(url);
            const dado = await response.json()
        
            document.getElementById('numPlacar').innerText=dado.total


        }

        // Chamar a função com a data do PHP
        montatabela()
        totaldatas()
    </script>