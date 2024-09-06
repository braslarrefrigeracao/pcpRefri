<div class="container p-2">
    <div class="container m-1 p-1 bg-dark text-bg-dark rounded shadow" style="width: fit-content;">
        <form action="" id="cadastrolinha"> 
            <fieldset>
            <div class="input-group">               
                    <legend>Cadastro de Linha</legend>
                <span class="input-group-text">
                    Nova linha
                </span>
                <input type="text" name="nova" id="nova" class="form form-control" required minlength="3">
                <input type="submit" value="OK" class="btn btn-success ">
                <input type="hidden" id="idlinha" value="">
                <input type="hidden" id="editando" value="false">            
            </div>
        </fieldset>
        </form>
    </div>
    <!-- tabela com as linhas existentes e botão pra editar -->
     <div class="container">
        <table class="table table-dark table-striped table-bordered shadow" style="width: fit-content;">
            <thead>
                <tr>
                    <th style="min-width: 200px;">Linha</th>
                    <th>Operação</th>
                </tr>
            </thead>
            <tbody id="corpo">

            </tbody>

        </table>
     </div>
</div>
<script>
    document.getElementById('cadastrolinha').addEventListener('submit', function(event) {
        // Prevenir o comportamento padrão do formulário
        event.preventDefault();

        // Obter o valor do campo 'nova' e 'editando'
        const novaLinha = document.getElementById('nova').value;
        const editando = document.getElementById('editando').value === 'true';
        const idLinha = document.getElementById('idlinha').value;

        // Se estiver editando, chamar a função de atualização, senão chamar a de cadastro
        if (editando) {
            atualiza_linha(idLinha, novaLinha);
        } else {
            cadastra_linha(novaLinha);
        }
    });

    // Função de cadastro (simulação)
    

    async function faz_tabela() {
        url = "http://localhost/apicold/linhas"
        const response = await fetch(url)
        const data = await response.json();
        const d = document.getElementById('corpo')
        d.innerText = ''
        data.forEach((item)=>{
            const r = document.createElement('tr')
            const col1 = document.createElement('td')
            const col2 = document.createElement('td')
            const bt = document.createElement('button')
            bt.innerText = "Edita"
            bt.value = item.id
            bt.className = "btn btn-warning"
            bt.addEventListener('click',()=>{
                edita(item.id, item.linha)
            })
            
            col1.innerText = item.linha
            col2.appendChild (bt)
            r.appendChild(col1)
            r.appendChild(col2)
            d.appendChild(r)
        })
        
    }
    async function cadastra_linha(linha){
        linha = linha.replaceAll(' ', '_');
        url = "http://localhost/apicold/postLinha/"+linha
        const insere =await fetch(url)
        .then(()=>{
            const nova = document.getElementById('nova')
            const ed = document.getElementById('editando')
            ed.value = false
            nova.value = ''
        })
        .then(()=>{
            faz_tabela()
        })
    }

    async function atualiza_linha(id, linha){
        linha = linha.replaceAll(' ', '_');
        url =  "http://localhost/apicold/updateLinha/"+id+"/"+linha
        console.log(url)
        const insere =await fetch(url)
        .then(()=>{
            const nova = document.getElementById('nova')
            const ed = document.getElementById('editando')
            ed.value = false
            nova.value = ''
        })
        .then(()=>{
            faz_tabela()
        })
    }
    function edita(id, linha){
       
        const ed = document.getElementById('editando')
        const nova = document.getElementById('nova')
        const idlinha = document.getElementById('idlinha')
        idlinha.value = id
        nova.value = linha
        ed.value = true
 console.log("aqui "+linha)
    }
    faz_tabela()
</script>