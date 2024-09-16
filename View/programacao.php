<?php
if(!isset($_SESSION['icepcp']['diapcp'])){
    $diapcp = new DateTime('now');
}else{
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
        if (obs==''){
            obs="nulo";
        }
        cadastro(produto,linha,quantidade,inicio,fim, '<?php echo $diapcp->format('Y-m-d') ?>',obs)
        
        document.getElementById('produto').value='';
        document.getElementById('quantidade').value='';
        document.getElementById('obs').value='';
        document.getElementById('produto').focus();
        tabela()

    
    });

    // Função de cadastro (simulação)
    async function linhas(){
        const url = "http://localhost/apicold/linhas/"
        const request =await fetch(url)
        const data =await request.json()
        const linha = document.getElementById('linhas')
        data.forEach((item)=>{
            const op = document.createElement('option')
            op.innerText = item.linha
            op.value = item.id
            linha.appendChild(op)

        })
    }
    async function cadastro(codigo,linha,quantidade,hini,hfim,dia,obs){
       
        const url = "http://localhost/apicold/postProgramacao/"+codigo+"/"+linha+"/"+hini+"/"+hfim+"/"+dia+"/"+quantidade+"/"+obs
        console.log('URL: '+url)
        const response =await fetch(url)
    }
    async function tabela(){
        console.log('entrou tabela')
        const dia = '<?php echo $diapcp->format('Y-m-d')?>'
         const url = "http://localhost/apicold/programacao/"+dia
         const response = await fetch(url)
         const dados =await response.json();
         console.log(dados)
    }
    linhas()
    tabela()
</script>