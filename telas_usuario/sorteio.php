<!DOCTYPE html>

<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Imprimir Relatório</title>

        <link rel="stylesheet" type = "text/css" href="../css/sorteio.css">
        <link rel="stylesheet" href="../node_modules/bootstrap/bootstrap.min.css">
        <script src="../js/icons.js" crossorigin="anonymous"></script>
        
    </head>

    <body>

        <header>

            <div id="data_relatorio" class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

                <?php
                    require '../conexao/conexao_bd.php';
                    
                    //DATAS DO PERIODO A SER EXIBIDOS NA TELA
                    $data_inicio = $_POST['data_inicio'];
                    $data_fim = $_POST['data_fim'];

                    if(date("d/m/Y",strtotime($_POST['data_inicio'])) != "31/12/1969"){
                ?>
                
                <!--MOSTRAR INICIO E FIM DO PERIODO QUE ESTA SENDO IMPRESSO NA TELA-->
                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text">Sorteio referente ao dia:</span>
                    </div>

                    <input type="text" class="form-control" id = "data_inicio_relatorio" value = "<?php echo date("d/m/Y",strtotime($_POST['data_inicio']))?>" readonly>

                    <div class="input-group-prepend">
                        <span class="input-group-text">até dia:</span>
                    </div>

                    <input type="text" class="form-control" id = "data_fim_relatorio" value = "<?php echo date("d/m/Y",strtotime($_POST['data_fim']))?>" readonly>

                </div>

                <?php
                    }else{
                ?>

                <!--MOSTRAR TODO PERIODO SE NAO PASSAR OS VALORES DE DATAS-->
                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text">Relatorio referente ao dia:</span>
                    </div>

                    <input type="text" class="form-control" id = "data_inicio_relatorio"  value = "TODO PERÍODO" readonly>

                    <div class="input-group-prepend">
                        <span class="input-group-text">até dia:</span>
                    </div>

                    <input type="text" class="form-control" id = "data_fim_relatorio" value = "TODO PERÍODO" readonly>

                </div>

                <?php
                    }
                ?>

            </div>
            
        </header>

        <!--RELATORIO DAS CONTRIBUIÇÔES PELO PERIODO-->
        <div id="relatorio" class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

            <table class="table table-secondary">

            <thead>

                <tr>
                    <th>Número da Sorte</th>
                    <th>Data da Contribuição</th>
                    <th>Nome Contribuidor</th>
                    <th>Apelido Contribuidor</th>

                </tr>

                </thead>

                <?php

                    require '../conexao/conexao_bd.php';

                    if($data_inicio && $data_fim){
                        //BUSCA NO BANCO DE DADOS DE ACORDO COM AS DATAS PASSADAS PELO POST
                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes WHERE data_contribuicao 
                                                        BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data_contribuicao DESC";
    
                    }else{
                        //SE NAO HOUVER DATA DISPONIVEL MOSTRA TODOS OS CONTRIBUIDORES PARA SORTEIO
                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes ORDER BY id_contribuicao DESC";

                    }

                    $inquerir_contribuicao = mysqli_query($conexao, $comando_buscar_contribuidor);

                    while($dados_contribuicao = mysqli_fetch_array($inquerir_contribuicao)){

                        $ids_contribuidores[] = $dados_contribuicao['id_contribuidor'];
                ?>

                <tbody>

                    <tr>
                        <td><?php echo $dados_contribuicao['id_contribuidor']?></td>
                        <td><?php echo date("d/m/Y",strtotime($dados_contribuicao['data_contribuicao']))?></td>
                        <td><?php echo $dados_contribuicao['nome_contribuidor']?></td>
                        <td><?php echo $dados_contribuicao['apelido_contribuidor']?></td>
                    </tr>

                </tbody>

                <?php
                    }
                ?>

            </table>

        </div>

        <?php

            if(isset($ids_contribuidores)){
                //NUMERO DE IDS DA TABELA ENTRE AS DATAS ESPECIFICAS
                $numeros_de_contribuidores = count($ids_contribuidores);
                //CONVERTER UM ARRAY PHP PARA PASSAR PARA O JAVASCRIPT EM JSON
                $ids_contribuidores_array = json_encode($ids_contribuidores);

                echo("<script>

                        var ids_contribuidores_array = '$ids_contribuidores_array';
                        var numeros_de_contribuidores = '$numeros_de_contribuidores';

                    </script>");
            }else{

                $numeros_de_contribuidores = 0;
                $ids_contribuidores_array = 0;
        ?>
        <!--MOSTRAR UM ERRO NA TELA POR QUE AS DATAS PESQUISADAS NAO EXISTEM NO BANCO DE DADOS-->
        <div id = "erro_datas" class = 'col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3'>
            <h5>Não existe contribuições neste período, por favor volte e digite um período válido!</h5>
        </div>

        <?php
            }
        ?>

        <!--INICIO PAINEL PARA SORTEAR CONTRIBUIDOR-->
        <div class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">
            
            <div class="input-group mb-3">

                <div class="input-group-prepend">
                    <span class="input-group-text">Número do Ganhador</span>
                </div>
                <input type="text" class="text-center form-control" id = "numero_sorteio" value = "0" readonly>
                <div class="input-group-prepend" id = "sortear">
                    <button type="button" class="btn btn-success" id = "btn-sortear">Realizar Sorteio</button>
                </div>

                <div class="input-group-prepend" id = "nao-sortear">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#gerar-mais-sorteio" id = "btn-sortear">Realizar +1 Sorteio</button>
                </div>

            </div>

        </div>
        <!--FIM PAINEL PARA SORTEAR CONTRIBUIDOR-->

        <div class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3" id = "voltar">
            <a href="../index.php" class="btn btn-danger"><i class="fas fa-home fa-1x"></i> Voltar Para o Menu</a>
        </div>

        <!-- INICIO MODAL PARA GERAR MAIS UM SORTEIO -->

        <div class="modal fade" id="gerar-mais-sorteio">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                
                    <!-- CABEÇALHO DO MODAL -->
                    <div class="modal-header">
                        <h4 class="modal-title">Sorteio</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- CORPO DO MODAL -->
                    <div class="modal-body">

                        <h5>Você já realizou um sorteio, deseja liberar mais um sorteio?<h5>

                    </div>
                    
                    <!-- RODAPÉ DO MODAL -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-success" id = "btn-gerar-mais-sorteio">Liberar Sorteio</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>

                    </div>
                    
                </div>

            </div>

        </div>

        <!-- FIM MODAL PARA GERAR MAIS UM SORTEIO -->

        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="../node_modules/jquery/mask.js"></script> 
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script>

            $('#busca_data_fim').mask('00/00/0000');

            $('#nao-sortear').hide();

            $('#btn-sortear').click(function(){
                //CONVERTE O OBJETO JSON STRING PARA UM ARRAY JS
                var contribuidores = JSON.parse(ids_contribuidores_array);
                //SORTEIO DO NUMERO DE CONTRIBUIDORES
                var numero_sorteio = Math.floor(Math.random() * numeros_de_contribuidores);
                //GANHADOR DO SORTEIO
                var sorteado = contribuidores[numero_sorteio];

                $('#numero_sorteio').val(sorteado);

                $('#nao-sortear').show();
                $('#sortear').hide();

                //SALVAR REGISTRO DE SORTEIO
                $.ajax({
                    url:'../comandos_bd/cadastrar_sorteio_bd.php',
                    type:'POST',
                    data:{id_contribuidor:sorteado},
                    success:function(){
                    }
                });

            });

            //LIBERAR MAIS UM SORTEIO
            $('#btn-gerar-mais-sorteio').click(function(){
                $('#sortear').show();
                $('#nao-sortear').hide();
                $('#gerar-mais-sorteio').modal('hide');
            });
        </script>

        <?php
            mysqli_close($conexao);
        ?>

    </body>
</html>