<!DOCTYPE html>

<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Contribuições</title>

        <link rel="stylesheet" type = "text/css" href="css/index.css">

    </head>

    <body>
        <?php
            require '../conexao/conexao_bd.php';
        ?>

        <!--INPUT PARA PESQUISAR NO BANCO DE DADOS-->

        <div id="buscar" class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

            <div class="input-group mb-3">

                <input type="text" class="form-control" id = "busca_contribuidor" autocomplete = "off" placeholder = "Buscar contribuição por nome ou apelido">

                <div class="input-group-append">
                    <button class="btn btn-success" type="button" id = "btn-buscar-contribuidor"><i class="fas fa-search fa-1x"></i></button>
                </div>

            </div>

        </div>

        <!--TABELA COM LISTA DE TODOS AS CONTRIBUICOES DO PERIODO DESDE O ULTIMO ENVIO DE RELATORIO DO SISTEMA-->

        <div id="visualizar_contribuicoes">

            <table class="table table-hover table-secondary">

                <thead>

                    <tr>
                        <th>Data da Contribuição</th>
                        <th>Nome Contribuidor</th>
                        <th>Apelido Contribuidor</th>
                        <th>Valor da Contribuição</th>
                        <th>Editar</th>
                        <th>Excluir</th>

                    </tr>

                </thead>

                <?php

                    //INICIO DA BUSCA NO BANCO DE DADOS

                    $campo_busca_contribuidor = @$_POST['busca_contribuidor'];

                    $campo_busca_data_inicio = @$_POST['data_inicio'];
                    $campo_busca_data_fim = @$_POST['data_fim'];

                    //BUSCAR POR NOME E APELIDO
                    if($campo_busca_contribuidor){

                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes WHERE nome_contribuidor LIKE '%$campo_busca_contribuidor%' OR apelido_contribuidor 
                                                        LIKE '%$campo_busca_contribuidor%' ORDER BY id_contribuicao DESC";

                    }else{

                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes ORDER BY id_contribuicao DESC";

                    }

                    $inquerir_contribuicao = mysqli_query($conexao, $comando_buscar_contribuidor);
                    $valor_da_pesquisa = mysqli_num_rows($inquerir_contribuicao); //PEGAR NUMERO DE LINHAS DO BANCO DE DADOS SOBRE A PESQUISA

                    while($dados_contribuicao = mysqli_fetch_array($inquerir_contribuicao)){

                        //FORMATAR VALOR PARA MOSTRAR COM PONTO E VIGULA
                        $valor_formatado = number_format($dados_contribuicao['valor_contribuicao'], 2, ',', '.');
                ?>

                <tbody>

                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($dados_contribuicao['data_contribuicao']))?></td>
                        <td><?php echo $dados_contribuicao['nome_contribuidor']?></td>
                        <td><?php echo $dados_contribuicao['apelido_contribuidor']?></td>

                        <td><input type="text" class="form-control" value = "<?php echo $valor_formatado?>" id="valor" readonly></td>
                        
                        <!--PASSAR INFORMAÇÔES DO BANCO PELO BOTAO PARA O MODAL (EDITAR CONTRIBUIÇÃO)-->

                        <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar-contribuicao"
                        
                            data-pegar_id="<?php echo $dados_contribuicao['id_contribuicao']?>"
                            data-pegar_valor="<?php echo $valor_formatado?>"
                        
                        ><i class="fas fa-edit fa-2x"></i></button></td>

                        <!--PASSAR INFORMAÇÔES DO BANCO PELO BOTAO PARA O MODAL (EXCLUIR CONTRIBUIÇÃO)-->
                        
                        <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluir-contribuicao"
                        
                            data-pegar_id="<?php echo $dados_contribuicao['id_contribuicao']?>"

                        ><i class="fas fa-trash-alt fa-2x"></i></button></td>
                        
                    </tr>

                </tbody>

                <?php
                    }
                ?>

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
        
        <!--BARRA PARA BUSCAR RELATÓRIO DE CONTRIBUIÇÕES NO SISTEMA-->
        <div id ="footer_contribuicoes_mes">
            
            <div class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

                <form action="telas_usuario/relatorio.php" method = "POST">

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text">Nome/Apelido : </span>
                        </div>

                        <input type="text" class="form-control" id = "busca_contribuidor" autocomplete = "off" placeholder = "Digite nome ou apelido" name = "buscar_contribuidor">

                    </div>
                    
                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text">Relatorio do dia</span>
                        </div>

                        <input type="date" class="form-control" placeholder="Digite uma data" autocomplete = "off" id = "busca_data_inicio" name = "data_inicio">

                        <div class="input-group-prepend">
                            <span class="input-group-text">Até</span>
                        </div>

                        <input type="date" class="form-control" placeholder="Digite uma data" autocomplete = "off" id = "busca_data_fim" name = "data_fim">
                        
                    </div>
                    
                    <div class="justify-content-center input-group mb-3">

                        <div class="input-group-prepend" id="btn-imprimir-relatorio">
                                <button class="btn btn-info" type="submit">Mostrar Relatório</button>
                        </div>

                        <div class="input-group-prepend">
                                <button class="btn btn-success" type="submit" formaction = "telas_usuario/sorteio.php">Sorteio</button>
                        </div>

                    </div>

                </form>
                
            </div>

        </div>

        <!-- INICIO MODAL PARA EDITAR CONTRIBUIDOR -->

        <div class="modal fade" id="editar-contribuicao">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Contribuição</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- FORMULARIO PARA ATUALIZAR CONTRIBUIDOR -->

                    <form action = "" method = "POST">
                    
                        <!-- CORPO DO MODAL -->
                        <div class="modal-body">

                            <input type="hidden" id = "id-editar" name = "id"> 

                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text">Novo Valor R$</span>
                                </div>
                                <!-- ID ESCONDIDO PARA PASSAR PELO METODO POST O ID -->
                                <input type="text" class="form-control" autocomplete = "off" id = "novo-valor" name = "nome" required>

                            </div>

                        </div>
                        
                        <!-- RODAPÉ DO MODAL -->
                        <div class="modal-footer">

                            <button type="button" class="btn btn-success" data-dismiss="modal" id = "btn-atualizar-contribuicao">Atualizar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>

                        </div>

                    </form>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA EDITAR CONTRIBUIDOR -->

        <!-- INICIO MODAL PARA EXCLUIR CONTRIBUIÇÂO -->

        <div class="modal fade" id="excluir-contribuicao">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Contribuição</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- FORMULARIO PARA ATUALIZAR CONTRIBUIDOR -->

                    <form action = "deletar_contribuicao_bd.php" method = "POST">

                        <!-- CORPO DO MODAL -->
                        <div class="modal-body">
                            
                            <input type="hidden" id = "id_excluir" name = "id">

                            <h5>Deseja Realmente Excluir Esta Contribuição ?<h5>

                        </div>
                        
                        <!-- RODAPÉ DO MODAL -->
                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal" id = "btn-excluir-contribuicao">Excluir</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal">Voltar</button>

                        </div>

                    </form>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA EXCLUIR CONTRIBUIÇÂO -->

        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/jquery/mask.js"></script> 
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script>
            //ATUALIZAR INFORMAÇÔES DA DIV
            function atualizar_informacoes(){
                setTimeout(function(){ $('#visualizar').load('telas_usuario/contribuicoes.php'); }, 500);
            }
            //MASCARA DE CAMPO
            $('#novo-valor').mask('#.##0,00', {reverse: true});
            $('#data_relatorio').mask('00/00/0000');

            
            //EDITAR VALOR DA CONTRIBUIÇÃO DO SISTEMA
            $('#editar-contribuicao').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var id = button.data('pegar_id');
                var valor = button.data('pegar_valor');

                modal.find('#id-editar').val(id);
                modal.find('#novo-valor').val(valor);
                
            });

            //ATUALIZA CONTRIBUIÇÃO PELO METODO POST USANDO AJAX
            $('#btn-atualizar-contribuicao').click(function(e){
                atualizar_informacoes();
                var v_id = $("#id-editar").val();
                var v_valor = $("#novo-valor").val();

                $.ajax({
                    url: "comandos_bd/atualizar_contribuicao_bd.php",
                    type: "POST",
                    data: { id:v_id, valor:v_valor},
                    success: function(){
                    }
                });
            });

            //EXCLUIR CONTRIBUIÇÃO DO SISTEMA
            $('#excluir-contribuicao').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var id = button.data('pegar_id');

                modal.find('#id_excluir').val(id);
            });
            
            //DELETA A CONTRIBUIÇÃO PELO METODO POST USANDO AJAX
            $('#btn-excluir-contribuicao').click(function(){
                atualizar_informacoes();
                var v_id = $("#id_excluir").val();

                $.ajax({

                    url: "comandos_bd/deletar_contribuicao_bd.php",
                    type: "POST",
                    data: { id:v_id},
                    success: function(){
                    }
                });
            });

            //FAZ A PESQUISA PELO METODO POST USANDO AJAX
            $('#btn-buscar-contribuidor').click(function(){
                
                var v_busca = $('#busca_contribuidor').val();

                $.ajax({

                    url:'telas_usuario/contribuicoes.php',
                    type:'POST',
                    data:{ busca_contribuidor:v_busca},
                    success:function(pagina_retorno){
                        $('#visualizar').html(pagina_retorno);
                    }
                });

            });

        </script> 
        <?php
             mysqli_close($conexao);
        ?>
    </body>
</html>