<?php
if (!isset($_SESSION['icepcp']['diapcp'])) {
    $diapcp = new DateTime('now');
} else {
    $diapcp = new DateTime($_SESSION['icepcp']['diapcp']);
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
                <h6>Dia Ativo: <?php echo $diapcp->format('d/m/Y') ?> </h6>
            </div>
            <form action="Control/datapcp.php" method="post">
                <div class="input-group m-1 p-1">
                    <input type="date" name="diapcp" class="form form-control" value="<?php echo $diapcp->format('Y-m-d') ?>" required>
                </div>
                <div class="input-group m-1 p-1">
                    <input type="submit" value="Mude a data" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
    <div class="container" style="font-size:small">
        <table class="table table-sm table-light table-striped table-bordered" id="conteudo">
            <thead class="text-center">
                <th>Código</th>
                <th>Modelo</th>
                <th>Descricão</th>
                <th>Linha</th>
                <th>Etiqueta</th>
                <th>Hora</th>
                <th>Operação</th>
            </thead>

        </table>
    </div>
    <script src="datatables/dataTables.min.js"></script>
    <script>
         async function apaga(id) {
                const confirmed = confirm("Você tem certeza que deseja apagar a etiqueta?");
                if (confirmed) {
                    try {
                        const url = "http://localhost/apicold/apagaEtiqueta/" + id;
                        console.log('URL para apagar:', url);
                        await fetch(url, {
                            method: 'DELETE'
                        }); // Adiciona método DELETE
                        $('#conteudo').DataTable().ajax.reload(); // Recarrega a tabela
                        totaldia('<?php echo $diapcp->format('Y-m-d') ?>'); // Atualiza o total
                    } catch (error) {
                        console.error('Erro ao apagar a etiqueta:', error);
                    }
                }
            }

            async function totaldia(dia) {
                try {
                    const url = "http://localhost/apiCold/valorTotalDia/" + dia;
                    const response = await fetch(url);
                    const dado = await response.json();
                    const d = document.getElementById('numPlacar');
                    d.innerText = dado.total;
                } catch (error) {
                    console.error('Erro ao atualizar o total:', error);
                }
            }
        document.addEventListener('DOMContentLoaded', function() {
           

            // Inicializa o DataTables com AJAX
            $('#conteudo').DataTable({
                ajax: {
                    url: "http://localhost/apiCold/etiquetasDia/<?php echo $diapcp->format('Y-m-d') ?>",
                    dataSrc: '' // Caso os dados venham como um array diretamente
                },
                columns: [{
                        data: 'codigo'
                    },
                    {
                        data: 'modelo'
                    },
                    {
                        data: 'descricao'
                    },
                    {
                        data: 'linha'
                    },
                    {
                        data: 'etiqueta'
                    },
                    {
                        data: 'horaapont'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `<button class='btn btn-danger btn-sm' onclick='window.apaga(${data})'>
                                        <i class='bi bi-trash'></i>
                                    </button>`;
                        }
                    }
                ],
                search: true,
                info: false,
                paging: false,
                language: {
                    search: "Busca",
                    infoEmpty: 'Nenhum registro disponível',
                    zeroRecords: 'Nenhum registro corresponde a sua busca, desculpe! :)'
                }
            });

            // Atualiza o total com a data do PHP
          
        });
          totaldia('<?php echo $diapcp->format('Y-m-d') ?>');
    </script>