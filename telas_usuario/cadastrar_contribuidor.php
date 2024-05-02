<!DOCTYPE html>

<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cadastrar Contribuidor</title>
        
        <link rel="stylesheet" type = "text/css" href="css/index.css">
    </head>

    <body>

        <?php
            require '../conexao/conexao_bd.php';
        ?>

        <!--INPUTS PARA CADASTRAR NOVOS CONTRIBUIDORES-->

        <div id = "cadastrar-contribuidor" class = "col-sm-12 col-md-12 col-lg-12 col-xl-8 offset-xl-2">

            <form action="" method = "POST">

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "obrig-nome">Nome</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "nome" name = "nome">

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text"  id = "obrig-telefone">Telefone</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "telefone" name = "telefone">

                    </div>

                        <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "obrig-apelido">Apelido</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "apelido" name = "apelido">

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "nao-obrig">Email</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "email" name = "email">

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "nao-obrig">Cidade</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "cidade" name = "cidade">

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "nao-obrig">Bairro</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "bairro" name = "bairro">

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "nao-obrig">Rua</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "rua" name = "rua">

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id = "nao-obrig">Nº</span>
                        </div>
                        <input type="text" class="form-control" autocomplete = "off" id = "numero" name = "numero">

                    </div>
                    
                    <div class="alert alert-warning" id = "aviso-positivo">
                        <strong>Atenção!</strong> Os campos em verde são obrigatórios.
                    </div>

                    <div class="alert alert-danger" id = "aviso-negativo">
                        <strong>Atenção!</strong> Preencha todos os campos em verde para efetuar o cadastro.
                    </div>

                    <button type="button" class="btn btn-primary" id = "btn-cadastrar-contribuidor">Cadastrar</button>

                </div>

            </form>

        </div>

        <?php
            mysqli_close($conexao);
        ?>

        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script> 
        <script src="node_modules/jquery/mask.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script>

            $('#telefone').mask('(00) 00000-0000');
            $('#numero').mask('000');
            $('#aviso-positivo').show();
            $('#aviso-negativo').hide();

            //PASSAR INFOMRMAÇÔES DO AJAX PARA O PHP E CADASTRAR CONTRIBUIDOR
            $('#btn-cadastrar-contribuidor').click(function(){

                var v_nome = $("#nome").val();
                var v_telefone = $("#telefone").val();
                var v_apelido = $("#apelido").val();
                var v_email = $("#email").val();
                var v_cidade = $("#cidade").val();
                var v_bairro = $("#bairro").val();
                var v_rua = $("#rua").val();
                var v_numero = $("#numero").val();
                

                if(v_nome != "" && v_telefone != "" && v_apelido != ""){

                    $.ajax({
                        url:'comandos_bd/cadastrar_contribuidor_bd.php',
                        type:'POST',
                        data: { nome:v_nome,
                                telefone:v_telefone,
                                apelido:v_apelido,
                                email:v_email,
                                cidade:v_cidade,
                                bairro:v_bairro,
                                rua:v_rua,
                                numero:v_numero
                                },
                        success: function(){
                            location.reload('painel_usuario.php');
                        }
                    }); //FECHAR AJAX CADASTRAR

                }else{
                    $('#aviso-positivo').hide();
                    $('#aviso-negativo').show();
                }

            }); //FECHAR BOTAO CADASTRAR

        </script>

    </body>
</html>