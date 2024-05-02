<!DOCTYPE html>

<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Imprimir Relatório</title>

        <link rel="stylesheet" type = "text/css" href="../css/relatorio.css">
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
                    $buscar_contribuidor = $_POST['buscar_contribuidor'];
                    
                    if(date("d/m/Y",strtotime($_POST['data_inicio'])) != "31/12/1969"){
                ?>
                
                <!--MOSTRAR INICIO E FIM DO PERIODO QUE ESTA SENDO IMPRESSO NA TELA-->
                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text">Relatorio referente ao dia:</span>
                    </div>

                    <input type="text" class="form-control" id = "data_inicio_relatorio"  value = "<?php echo date("d/m/Y",strtotime($_POST['data_inicio']))?>" readonly>

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

                    <th>Data da Contribuição</th>
                    <th>Nome Contribuidor</th>
                    <th>Apelido Contribuidor</th>
                    <th>Valor da Contribuição</th>

                </tr>

                </thead>

                <?php

                    //VERIFICA AS CONTRIBUIÇÔES ENTRE AS DATAS PELO NOME E APELIDO
                    if($buscar_contribuidor && $data_inicio && $data_fim){

                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes WHERE nome_contribuidor LIKE '%$buscar_contribuidor%' OR apelido_contribuidor LIKE '%$buscar_contribuidor%' 
                        
                        AND data_contribuicao BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data_contribuicao DESC";
                    
                    //VERIFICA SE EXISTE ALGUM PERIODO A SER MOSTRADO
                    }else if($data_inicio && $data_fim){

                        //BUSCA NO BANCO DE DADOS DE ACORDO COM AS DATAS PASSADAS PELO POST
                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes WHERE data_contribuicao BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data_contribuicao DESC";

                    }else if($buscar_contribuidor){

                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes WHERE nome_contribuidor 

                        LIKE '%$buscar_contribuidor%' OR apelido_contribuidor LIKE '%$buscar_contribuidor%' ORDER BY STR_TO_DATE(data_contribuicao, '%d/%m/%Y') DESC";

                    }else{

                        $comando_buscar_contribuidor = "SELECT * FROM contribuicoes ORDER BY id_contribuicao DESC";
                    }

                    $inquerir_contribuicao = mysqli_query($conexao, $comando_buscar_contribuidor);

                    while($dados_contribuicao = mysqli_fetch_array($inquerir_contribuicao)){

                        //FORMATAR VALOR PARA MOSTRAR COM PONTO E VIGULA
                        $valor_formatado = number_format($dados_contribuicao['valor_contribuicao'], 2, ',', '.');

                        //SALVAR TODA COLUNA DA TABELA DENTRO DE UM ARRAY
                        $valores_contribuicoes[] = $dados_contribuicao['valor_contribuicao'];
                ?>

                <tbody>

                    <tr>
                        <td><?php echo date("d/m/Y",strtotime($dados_contribuicao['data_contribuicao']))?></td>
                        <td><?php echo $dados_contribuicao['nome_contribuidor']?></td>
                        <td><?php echo $dados_contribuicao['apelido_contribuidor']?></td>
                        <td><input type="text" class="form-control" value = "<?php echo $valor_formatado?>" id="valor_contribuicao" readonly></td>
                    </tr>

                </tbody>

                <?php
                    }
                ?>

            </table>

        </div>

        <?php //MOSTRA OS VALORES SOMADOS DAS CONTRIBUIÇÔES FORMATADO E MOSTRA NUMERO DE CONTRIBUIÇÔES DO MÊS

            if(isset($valores_contribuicoes)){//VERIFICAR SE TEM UM ARRAY DISPONIVEL PARA FAZER A SOMA

                $soma_valores = array_sum($valores_contribuicoes);

                $soma_formatada = number_format($soma_valores, 2, ',', '.');
                
                $numero_contribuicoes = mysqli_num_rows($inquerir_contribuicao);
            }else{

                $numero_contribuicoes = 0;
                $soma_formatada = 0;  
        ?>
        <!--MOSTRAR UM ERRO NA TELA POR QUE AS DATAS PESQUISADAS NAO EXISTEM NO BANCO DE DADOS-->
        <div id = "erro_datas" class = 'col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3'>
            <h5>Não existe contribuições neste período, por favor volte e digite um período válido!</h5>
        </div>

        <?php
            }
        ?>

        <!--MOSTRAR NUMERO DE CONTRIBUIÇÔES E VALOR TOTAL DAS CONTRIBUIÇÔES DE ACORDO COM O PERIODO-->
        <div class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

            <div class="input-group mb-3">

                <div class="input-group-prepend">
                    <span class="input-group-text">Número de Contribuições Totais</span>
                </div>

                <input type="text" id = "numero_contribuicoes" class="form-control" value = "<?php echo $numero_contribuicoes?>" readonly>

                <div class="input-group-prepend">
                    <span class="input-group-text">Valor total das Contribuições</span>
                </div>

                <input type="text" id = "soma_contribuicoes" class="form-control" value = "<?php echo $soma_formatada?>" readonly>

            </div>

        </div>

        <div class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3" id = "voltar">
            <a href="../index.php" class="btn btn-danger"><i class="fas fa-home fa-1x"></i> Voltar Para o Menu</a>
        </div>

        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="../node_modules/jquery/mask.js"></script> 
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script>
        
            $('#busca_data_fim').mask('00/00/0000');
        
        </script>

        <?php
            mysqli_close($conexao);
        ?>

    </body>
</html>