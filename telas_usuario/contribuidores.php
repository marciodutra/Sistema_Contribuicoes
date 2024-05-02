<!DOCTYPE html>

<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Inicio</title>

        <link rel="stylesheet" type = "text/css" href="css/index.css">

    </head>

    <body>

        <!--INPUT PARA PESQUISAR NO BANCO DE DADOS-->

        <div id="buscar" class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

                <div class="input-group mb-3">

                    <input type="text" class="form-control" id = "campo_busca" autocomplete = "off" placeholder = "Buscar contribuidor por nome ou apelido">

                    <div class="input-group-append">
                        <button class="btn btn-success" type="button" id = "btn-buscar-contribuidor"><i class="fas fa-search fa-1x"></i></button>
                    </div>

                </div>

        </div>

        <!--TABELA COM LISTA DE TODOS OS CONTRIBUIDORES-->

        <div id = "visualizar_contribuidores">
            
            <table class="table table-hover table-secondary">

                <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Apelido</th>
                        <th>Informações</th>
                        <th>Contribuir</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>

                </thead>

                <tbody>

                    <!--PEGAR INFORMAÇÔES DOS CONTRIBUIDORES E MOSTRAR NA TELA-->

                    <?php
                        require '../conexao/conexao_bd.php';

                        //INICIO DA BUSCA NO BANCO DE DADOS

                        $campo_busca = @$_POST['campo_busca'];

                        if($campo_busca){

                            $comando_buscar = "SELECT * FROM contribuidores WHERE nome LIKE '%$campo_busca%' OR apelido LIKE '%$campo_busca%' ORDER BY id DESC";

                        }else{

                            $comando_buscar = "SELECT * FROM contribuidores ORDER BY id DESC";

                        }
                        //FIM DA BUSCA NO BANCO DE DADOS

                        $buscar_contribuidor = mysqli_query($conexao, $comando_buscar);
                        $valor_da_pesquisa = mysqli_num_rows($buscar_contribuidor); //PEGAR NUMERO DE LINHAS DO BANCO DE DADOS SOBRE A PESQUISA

                        while($dados_contribuidor = mysqli_fetch_array($buscar_contribuidor)){
                    ?>

                    <tr>
                        <td><?php echo $dados_contribuidor['nome']?></td>
                        <td><?php echo $dados_contribuidor['apelido']?></td>
                        
                        <!--PASSAR INFORMAÇÔES DO BANCO DE DADOS USANDO O JQUERY E TRANSFERIR PARA O MODAL(INFORMAÇÔES DO CONTRIBUIDOR)-->

                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#informacoes-contribuidor"

                            data-pegar_nome="<?php echo $dados_contribuidor['nome']?>"
                            data-pegar_telefone="<?php echo $dados_contribuidor['telefone']?>"
                            data-pegar_apelido="<?php echo $dados_contribuidor['apelido']?>"
                            data-pegar_email="<?php echo $dados_contribuidor['email']?>"
                            data-pegar_cidade="<?php echo $dados_contribuidor['cidade']?>"
                            data-pegar_bairro="<?php echo $dados_contribuidor['bairro']?>"
                            data-pegar_rua="<?php echo $dados_contribuidor['rua']?>"
                            data-pegar_numero="<?php echo $dados_contribuidor['numero']?>"
                        
                        ><i class="fas fa-info-circle fa-2x"></i></button></td> <!--PASSAR INFORMAÇÔES DO BANCO PELO BOTAO PARA O MODAL-->

                        <!--PASSAR INFORMAÇÔES DO BANCO DE DADOS USANDO O JQUERY E TRANSFERIR PARA O MODAL (CONTRIBUIÇÂO)-->

                        <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#contribuir"
                        
                            data-pegar_id="<?php echo $dados_contribuidor['id']?>"
                            data-pegar_nome="<?php echo $dados_contribuidor['nome']?>"
                            data-pegar_apelido="<?php echo $dados_contribuidor['apelido']?>"
                        
                        ><i class="fas fa-hand-holding-usd fa-2x"></i></button></td> <!--PASSAR INFORMAÇÔES DO BANCO PELO BOTAO PARA O MODAL-->

                        <!--PASSAR INFORMAÇÔES DO BANCO DE DADOS USANDO O JQUERY E TRANSFERIR PARA O MODAL(EDITAR INFORMAÇÔES DO CONTRIBUIDOR)-->

                        <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar-contribuidor" 
                        
                            data-pegar_id="<?php echo $dados_contribuidor['id']?>"
                            data-pegar_nome="<?php echo $dados_contribuidor['nome']?>"
                            data-pegar_telefone="<?php echo $dados_contribuidor['telefone']?>"
                            data-pegar_apelido="<?php echo $dados_contribuidor['apelido']?>"
                            data-pegar_email="<?php echo $dados_contribuidor['email']?>"
                            data-pegar_cidade="<?php echo $dados_contribuidor['cidade']?>"
                            data-pegar_bairro="<?php echo $dados_contribuidor['bairro']?>"
                            data-pegar_rua="<?php echo $dados_contribuidor['rua']?>"
                            data-pegar_numero="<?php echo $dados_contribuidor['numero']?>"

                        ><i class="fas fa-user-edit fa-2x"></i></button></td> <!--PASSAR INFORMAÇÔES DO BANCO PELO BOTAO PARA O MODAL-->

                        <!--EXCLUIR INFORMAÇÔES DO BANCO DE DADOS USANDO O JQUERY(EXCLUIR CONTRIBUIDOR)-->

                        <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluir-contribuidor"
                        
                            data-pegar_id="<?php echo $dados_contribuidor['id']?>"

                        ><i class="fas fa-user-times fa-2x"></i></button></td>

                    </tr>

                    <?php
                        }
                        mysqli_close($conexao);
                    ?>
                        
                </tbody>

            </table>

            <?php
            //VERIFICAR SE A PESQUISA NO BANCO DE DADOS FOI UM SUCESSO
            if($valor_da_pesquisa == 0){
            ?>
                <div id = "erro_busca" class = 'col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2 offset-xl-5'>
                    <h5>Sem resultado!</h5>
                </div>
            <?php
                }
            ?>
            
        </div>

        <!-- INICIO MODAL PARA EDITAR CONTRIBUIDOR -->

        <div class="modal fade" id="editar-contribuidor">

            <div class="modal-dialog modal-dialog-centered">
            
                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Contribuidor</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- FORMULARIO PARA ATUALIZAR CONTRIBUIDOR -->

                    <form action = "atualizar_contribuidor_bd.php" method = "POST">
                    
                        <!-- CORPO DO MODAL -->
                        <div class="modal-body">

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">*Nome</span>
                                </div>
                                <!-- ID ESCONDIDO PARA PASSAR PELO METODO POST O ID -->
                                <input type="hidden" id = "id-editar" name = "id" readonly> 
                                <input type="text" class="form-control" autocomplete = "off" id = "nome-editar" name = "nome" required>

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">*Telefone</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "telefone-editar" name = "telefone" required>

                            </div>

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Apelido</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "apelido-editar" name = "apelido">

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Email</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "email-editar" name = "email">

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Cidade</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "cidade-editar" name = "cidade">

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bairro</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "bairro-editar" name = "bairro">

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rua</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "rua-editar" name = "rua">

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nº</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "numero-editar" name = "numero">

                            </div>

                        </div>
                        
                        <!-- RODAPÉ DO MODAL -->
                        <div class="modal-footer">

                            <button type="button" class="btn btn-success" data-dismiss="modal" id = "btn-atualizar-contribuidor">Atualizar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>

                        </div>

                    </form>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA EDITAR CONTRIBUIDOR -->


        
        <!-- INICIO MODAL PARA EXCLUIR CONTRIBUIDOR -->

        <div class="modal fade" id="excluir-contribuidor">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Contribuidor</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- FORMULARIO PARA ATUALIZAR CONTRIBUIDOR -->

                    <form action = "deletar_contribuidor_bd.php" method = "POST">

                        <!-- CORPO DO MODAL -->
                        <div class="modal-body">
                            
                            <input type="hidden" id = "id-excluir" name = "id">
                            <h5>Deseja Realmente Excluir Este Contribuidor ?<h5>

                        </div>
                        
                        <!-- RODAPÉ DO MODAL -->
                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal" id = "btn-excluir-contribuidor">Excluir</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal">Voltar</button>

                        </div>

                    </form>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA EXCLUIR CONTRIBUIDOR -->

        <!-- INICIO MODAL PARA MOSTRAR INFORMAÇÔES DO CONTRIBUIDOR -->

        <div class="modal fade" id="informacoes-contribuidor">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Informações do Contribuidor</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- FORMULARIO PARA ATUALIZAR CONTRIBUIDOR -->

                    <form action = "" method = "POST">
                    
                        <!-- CORPO DO MODAL -->
                        <div class="modal-body">

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nome</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "nome" name = "nome" readonly>

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Telefone</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "telefone" name = "telefone" readonly>

                            </div>

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Apelido</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "apelido-editar" name = "apelido" readonly>

                            </div>

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Email</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "email" name = "email" readonly>

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Cidade</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "cidade" name = "cidade" readonly>

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bairro</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "bairro" name = "bairro" readonly>

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rua</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "rua" name = "rua" readonly>

                            </div>

                            
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nº</span>
                                </div>
                                <input type="text" class="form-control" value = "" id = "numero" name = "numero" readonly>

                            </div>

                        </div>
                        
                        <!-- RODAPÉ DO MODAL -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>
                        </div>

                    </form>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA MOSTRAR INFORMAÇÔES DO CONTRIBUIDOR -->
        
        <!-- INICIO MODAL PARA MOSTRAR PAINEL DE CONTRIBUIÇÂO -->

        <div class="modal fade" id="contribuir">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Digite um Valor Para Contribuir</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- FORMULARIO PARA ATUALIZAR CONTRIBUIDOR -->

                    <form action = "" method = "POST">
                    
                        <!-- CORPO DO MODAL -->
                        <div class="modal-body">

                            <input type="hidden" id = "data_contribuicao" value = "<?php echo date("Y-m-d")?>" name = "contribuicao">
                            <input type="hidden" id = "apelido_contribuidor" name = "contribuicao">
                            <input type="hidden" id = "nome_contribuidor" name = "contribuicao">
                            <input type="hidden" id = "id_contribuidor" name = "contribuicao">

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contribuidor</span>
                                </div>
                                <input type="text" class="form-control" id = "nome_contribuidor_readonly" name = "nome_contribuidor" readonly>

                            </div>

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Valor R$</span>
                                </div>
                                <input type="text" class="form-control" autocomplete = "off" id = "valor_contribuicao" name = "valor_contribuicao">

                            </div>

                        </div>
                        
                        <!-- RODAPÉ DO MODAL -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal" id = "btn-contribuir">Contribuir</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>
                        </div>

                    </form>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA MOSTRAR PAINEL DE CONTRIBUIÇÂO -->

        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script> 
        <script src="node_modules/jquery/mask.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script>

            //MASCARA DE CAMPO
            $('#input-contribuir').mask('#.##0,00', {reverse: true});
            $('#valor_contribuicao').mask('#.##0,00', {reverse: true});
            $('#telefone-editar').mask('(00) 00000-0000');
            $('#numero-editar').mask('000'); 

            //ATUALIZAR INFORMAÇÔES DA DIV
            function atualizar_informacoes(){
                setTimeout(function(){ $('#visualizar').load('telas_usuario/contribuidores.php'); }, 500);
            }

            //MOSTRA AS INFORMAÇÔES DO CONTRIBUIDOR PARA O INPUT (INFORMAÇÔES)
            $('#informacoes-contribuidor').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var nome = button.data('pegar_nome');
                var telefone = button.data('pegar_telefone');
                var apelido = button.data('pegar_apelido');
                var email = button.data('pegar_email');
                var cidade = button.data('pegar_cidade');
                var bairro = button.data('pegar_bairro');
                var rua = button.data('pegar_rua');
                var numero = button.data('pegar_numero');

                modal.find('#nome').val(nome);
                modal.find('#telefone').val(telefone);
                modal.find('#apelido-editar').val(apelido);
                modal.find('#email').val(email);
                modal.find('#cidade').val(cidade);
                modal.find('#bairro').val(bairro);
                modal.find('#rua').val(rua);
                modal.find('#numero').val(numero);
            });

            //PASSA AS INFORMAÇÔES DO CONTRIBUIDOR PARA O INPUT (ATUALIZAR)
            $('#editar-contribuidor').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var id = button.data('pegar_id');
                var nome = button.data('pegar_nome');
                var telefone = button.data('pegar_telefone');
                var apelido = button.data('pegar_apelido');
                var email = button.data('pegar_email');
                var cidade = button.data('pegar_cidade');
                var bairro = button.data('pegar_bairro');
                var rua = button.data('pegar_rua');
                var numero = button.data('pegar_numero');

                modal.find('#id-editar').val(id);
                modal.find('#nome-editar').val(nome);
                modal.find('#telefone-editar').val(telefone);
                modal.find('#apelido-editar').val(apelido);
                modal.find('#email-editar').val(email);
                modal.find('#cidade-editar').val(cidade);
                modal.find('#bairro-editar').val(bairro);
                modal.find('#rua-editar').val(rua);
                modal.find('#numero-editar').val(numero);
            });

            //ATUALIZA CONTRIBUIDOR PELO METODO POST USANDO AJAX
            $('#btn-atualizar-contribuidor').click(function(){
                atualizar_informacoes();
                var v_id = $("#id-editar").val();
                var v_nome = $("#nome-editar").val();
                var v_telefone = $("#telefone-editar").val();
                var v_apelido = $("#apelido-editar").val();
                var v_email = $("#email-editar").val();
                var v_cidade = $("#cidade-editar").val();
                var v_bairro = $("#bairro-editar").val();
                var v_rua = $("#rua-editar").val();
                var v_numero = $("#numero-editar").val();

                $.ajax({
                    url: "comandos_bd/atualizar_contribuidor_bd.php",
                    type: "POST",
                    data: { id:v_id,
                            nome:v_nome,
                            telefone:v_telefone,
                            apelido:v_apelido,
                            email:v_email,
                            cidade:v_cidade,
                            bairro:v_bairro,
                            rua:v_rua,
                            numero:v_numero
                            },
                    success: function(){
                    }
                });
            });

            //PASSA AS INFORMAÇÔES DO CONTRIBUIDOR PARA O INPUT (EXCLUIR)

            $('#excluir-contribuidor').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var id = button.data('pegar_id');

                modal.find('#id-excluir').val(id);
            });

            //DELETA CONTRIBUIDOR PELO METODO POST USANDO AJAX
            $('#btn-excluir-contribuidor').click(function(){
                atualizar_informacoes();
                var v_id = $("#id-excluir").val();

                $.ajax({

                    url: "comandos_bd/deletar_contribuidor_bd.php",
                    type: "POST",
                    data: { id:v_id},

                    success: function(){
                    }
                });
            });

            //PASSA AS INFORMAÇÔES DO CONTRIBUIDOR PARA CONTRIBUIR (CONTRIBUIR)
            $('#contribuir').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var v_id = button.data('pegar_id');
                var v_nome = button.data('pegar_nome');
                var v_apelido = button.data('pegar_apelido');

                modal.find('#id_contribuidor').val(v_id);
                modal.find('#nome_contribuidor').val(v_nome);
                modal.find('#apelido_contribuidor').val(v_apelido);
                modal.find('#nome_contribuidor_readonly').val(v_nome);

            });
            
            //FAZ A CONTRIBUIÇÂO PELO METODO POST USANDO AJAX
            $('#btn-contribuir').click(function(){
                atualizar_informacoes();
                var data_contribuicao = $('#data_contribuicao').val();
                var id_contribuidor = $('#id_contribuidor').val();
                var valor_contribuicao = $('#valor_contribuicao').val();
                var nome_contribuidor = $('#nome_contribuidor').val();
                var apelido_contribuidor = $('#apelido_contribuidor').val();

                $.ajax({

                    url:'comandos_bd/cadastrar_contribuicoes.php',
                    type:'POST',
                    data:{  data_contribuicao:data_contribuicao,
                            id_contribuidor:id_contribuidor,
                            valor_contribuicao:valor_contribuicao,
                            nome_contribuidor:nome_contribuidor,
                            apelido_contribuidor:apelido_contribuidor
                         },
                    success:function(){
                    }
                });

            });

            //FAZ A PESQUISA PELO METODO POST USANDO AJAX
            $('#btn-buscar-contribuidor').click(function(){
                
                var v_busca = $('#campo_busca').val();

                $.ajax({

                    url:'telas_usuario/contribuidores.php',
                    type:'POST',
                    data:{ campo_busca:v_busca},
                    success:function(pagina_retorno){
                        $('#visualizar').html(pagina_retorno);
                    }
                });

            });

        </script>

    </body>
</html>