<div id="placar" class="container  text-center" style="width: 50%;">
    <div class="row">
        <div class="col"
<div class="bg-dark text-bg-dark d-flex flex-column justify-content-center align-items-center m-1" style="min-height: 150px;">
    
            <h3>Total</h3>
            <h1 id="numPlacar">999</h1>
        </div>
        <div class="col">
            <form action="Control/datapcp.php" method="post">
                <div class="input-group">
                    <input type="date" name="diapcp" class="form form-control">
                </div>
                <div class="input-group">
                    <input type="submit" value="Mude a data" class="btn btn-success">
                </div>
            </form>
        </div>

    </div>
      </div>
</div>
<div class="container" style="font-size:small">
    <table class="table table-sm table-light table-striped table-bordered">
        <thead class="text-center">
            <th>Código</th>
            <th>Modelo</th>
            <th>Descricão</th>
            <th>Linha</th>
            <th>Valor</th>
        </thead>
        <tbody id="tbplacar">

        </tbody>

    </table>
</div>

<script>
    async function totaldia(dia){
        const url = "http://localhost/apiCold/"
    }
</script>