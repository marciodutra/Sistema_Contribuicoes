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
        <!--INPUT PARA PESQUISAR NO BANCO DE DADOS-->

        <div id="buscar" class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 offset-xl-3">

            <div class="input-group mb-3">

                <input type="text" class="form-control" id = "busca_sorteio" autocomplete = "off" placeholder = "Buscar registro de sorteio por nome ou apelido">

                <div class="input-group-append">
                    <button class="btn btn-success" type="button" id = "btn-buscar-sorteio"><i class="fas fa-search fa-1x"></i></button>
                </div>

            </div>

        </div>

        <div id="registro_sorteios">

            <table class="table table-hover table-secondary">

                <thead>

                <tr>
                    <th>Data do Sorteio</th>
                    <th>Número da Sorte</th>
                    <th>Nome Contribuidor</th>
                    <th>Apelido Contribuidor</th>
                </tr>

                </thead>

                <?php
                    require '../conexao/conexao_bd.php';

                    $campo_busca_sorteio = @$_POST['busca_sorteios'];

                    $campo_busca_data_inicio = @$_POST['data_inicio'];
                    $campo_busca_data_fim = @$_POST['data_fim'];

                    //BUSCAR POR NOME E APELIDO
                    if($campo_busca_sorteio){

                        $comando_buscar_sorteio = "SELECT * FROM sorteios WHERE nome_contribuidor LIKE '%$campo_busca_sorteio%' OR apelido_contribuidor 
                                                        LIKE '%$campo_busca_sorteio%' ORDER BY data_sorteio DESC";

                    }else{

                        $comando_buscar_sorteio = "SELECT * FROM sorteios ORDER BY data_sorteio DESC";

                    }

                    $inquerir_sorteio = mysqli_query($conexao, $comando_buscar_sorteio);
                    $valor_da_pesquisa = mysqli_num_rows($inquerir_sorteio); //PEGAR NUMERO DE LINHAS DO BANCO DE DADOS SOBRE A PESQUISA

                    while($dados_contribuicao = mysqli_fetch_array($inquerir_sorteio)){

                ?>

                <tbody>

                    <tr>
                            <td><?php echo date("d/m/Y",strtotime($dados_contribuicao['data_sorteio']))?></td>
                            <td><?php echo $dados_contribuicao['id_contribuidor']?></td>
                            <td><?php echo $dados_contribuicao['nome_contribuidor']?></td>
                            <td><?php echo $dados_contribuicao['apelido_contribuidor']?></td>
                        
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

        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/jquery/mask.js"></script> 
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script>
        
            //FAZ A PESQUISA PELO METODO POST USANDO AJAX
            $('#btn-buscar-sorteio').click(function(){
                
                var v_busca = $('#busca_sorteio').val();

                $.ajax({

                    url:'telas_usuario/registro_sorteios.php',
                    type:'POST',
                    data:{ busca_sorteios:v_busca},
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