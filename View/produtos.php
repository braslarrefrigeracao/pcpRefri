<div class="container p-2">
    <div class="container m-1 p-2 bg-dark text-bg-dark rounded shadow" style="width: fit-content;">
        <form action="" id="cadastrolinha">
            <fieldset>
                <legend>Cadastro de Produto</legend>
                <div class="input-group m-1 m-1">
                    <span class="input-group-text">
                        Código
                    </span>
                    <input type="text" name="codigo" id="codigo" class="form form-control" required minlength="3">
                    <input type="hidden" id="idproduto" value="">
                    <input type="hidden" id="idcategoria" value="">
                    <input type="hidden" id="editando" value="false">
                    <span class="input-group-text">
                        Categorias
                    </span>
                    <select id="categorias"></select>
                    <span class="input-group-text">
                        Modelo
                    </span>
                    <input type="text" name="modelo" id="modelo" class="form form-control" required minlength="3">
                </div>
                <div class="input-group m-1 m-1">
                    <span class="input-group-text">
                        Descrição
                    </span>
                    <input type="text" name="descricao" id="descricao" class="form form-control" required minlength="3">
                </div>
                <div class="input-group m-1 m-1">
                    <span class="input-group-text">
                        Prefixo
                    </span>
                    <input type="text" name="prefixo" id="prefixo" class="form form-control" required minlength="3">
                    <input type="submit" value="Cadastra" class="btn btn-success">
                </div>
            </fieldset>
        </form>
    </div>
    <!-- tabela com as linhas existentes e botão pra editar -->
    <div class="container">
        <table class="table table-dark table-striped table-bordered shadow" style="width: fit-content;" id="produtos">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Modelo</th>
                    <th>Descrição</th>
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
        const novaLinha = document.getElementById('codigo').value;
        const editando = document.getElementById('editando').value === 'true';
        const idproduto = document.getElementById('idproduto').value;

        // Se estiver editando, chamar a função de atualização, senão chamar a de cadastro
        if (editando) {
            atualiza_produto(idproduto);
        } else {
            cadastra_produto();
        }
    });

    // Função de cadastro (simulação)


    async function faz_tabela() {
        url = "http://localhost/apicold/produtos"
        const response = await fetch(url)
        const data = await response.json();
        const d = document.getElementById('corpo')
        d.innerText = ''
        data.forEach((item) => {
            const r = document.createElement('tr')
            const col1 = document.createElement('td')
            const col2 = document.createElement('td')
            const col3 = document.createElement('td')
          
            const col5 = document.createElement('td')
            const bt = document.createElement('button')
            bt.innerText = "Edita"
            bt.value = item.id
            bt.className = "btn btn-warning"
            bt.addEventListener('click', () => {
                edita(item.id)
            })

            col1.innerText = item.codigo
            col2.innerText = item.modelo
            col3.innerText = item.descricao
           
            col5.appendChild(bt)
            r.appendChild(col1)
            r.appendChild(col2)
            r.appendChild(col3)
           
            r.appendChild(col5)
            d.appendChild(r)
        })
        const cp = document.getElementById('idcategoria').value
        categorias()

    }
    async function cadastra_produto() {
        const codigo = document.getElementById('codigo').value
        let  modelo = document.getElementById('modelo').value
        let descricao = document.getElementById('descricao').value
        const idcategoria = document.getElementById('categorias').value
        const prefixo = document.getElementById('prefixo').value
        descricao =descricao.replaceAll(' ','_',descricao)
        modelo =modelo.replaceAll(' ','_',modelo)
 
        const url = "http://localhost/apicold/postProduto/"+codigo+"/"+modelo+"/"+descricao+"/"+idcategoria+"/"+prefixo
        console.log(url)
        const insere = await fetch(url)
            .then(() => {
                document.getElementById('codigo').value = ''
                document.getElementById('prefixo').value = ''
                document.getElementById('modelo').value = ''
                document.getElementById('descricao').value = ''
                categorias()
                document.getElementById('editando').value = false

            })
            .then(() => {
                faz_tabela()
            })
    }
    async function categorias(idcat = 1) {

        url = "http://localhost/apicold/categorias/"
        const d = document.getElementById('categorias')
        const cat = document.getElementById('idcategoria')
        d.innerText = ""


        const response = await fetch(url)
        const data = await response.json()
        data.forEach((item) => {
            const op = document.createElement('option')
            op.value = item.id
            if (idcat === item.id) {
                op.selected = true
            }
            op.innerText = item.categoria
            d.appendChild(op)
        })
    }
    async function prefixo(id) {
        const url = "http://localhost/apicold/prefixos/"+id
        
        const d = document.getElementById('prefixo')
        d.innerText = ""
        const response = await fetch(url)
        const data = await response.json()
        data.forEach((item) => {
            console.log(item.prefixo)
            d.value = item.prefixo
        })
    }

    async function atualiza_produto() {
        const codigo = document.getElementById('codigo').value
        const id = document.getElementById('idproduto').value
        let  modelo = document.getElementById('modelo').value
        let descricao = document.getElementById('descricao').value
        const idcategoria = document.getElementById('categorias').value
        const prefixo = document.getElementById('prefixo').value
        descricao =descricao.replaceAll(' ','_',descricao)
        modelo =modelo.replaceAll(' ','_',modelo)
        const url = "http://localhost/apicold/updateProduto/" + id + "/" + codigo+"/" +modelo+"/" +descricao+"/" +idcategoria+"/" +prefixo
        console.log(url)
        const insere = await fetch(url)
            .then(() => {
                document.getElementById('codigo').value = ''
                document.getElementById('prefixo').value = ''
                document.getElementById('modelo').value = ''
                document.getElementById('descricao').value = ''
                categorias()
                document.getElementById('editando').value = false
            })
            .then(() => {
                faz_tabela()
            })
    }
    async function edita(id) {
        url = "http://localhost/apicold/produtos"

        const response = await fetch(url)
        const data = await response.json();
        const filtra = data.filter((dados) => {
            return dados.id == id;
        });
        document.getElementById('codigo').value =filtra[0].codigo
        document.getElementById('idproduto').value =filtra[0].id
        document.getElementById('modelo').value =filtra[0].modelo
        document.getElementById('descricao').value =filtra[0].descricao
        document.getElementById('editando').value =true
        categorias(filtra[0].idcategoria)
       
        prefixo(filtra[0].id)

    }
    faz_tabela()
</script>
