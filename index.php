<!DOCTYPE html>

<html lang="pt-BR">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Sistema de Doações</title>

        <link rel="stylesheet" type = "text/css" href="css/index.css">
        <link rel="stylesheet" href="node_modules/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/bootstrap-sidebar.css">

        <script src="js/icons.js" crossorigin="anonymous"></script>

    </head>

    <body>

        <!--TABELA PARA NAVEGAR ENTRE OS INDICES-->

        <div class="wrapper">

            <nav id="sidebar">

                <div class="sidebar-header">
                    <h1>Menu</h1>
                </div>

                <ul class="list-unstyled components">

                    <li>
                        <a href="#" onclick="contribuidores()">Contribuidores</a>
                    </li>

                    <li>
                        <a href="#" onclick="cadastrar_contribuidor()">Cadastrar Contribuidor</a>
                    </li>

                    <li>
                        <a href="#"  onclick="contribuicoes()">Contribuições</a>
                    </li>

                    <li>
                        <a href="#" onclick="registro_sorteios()">Registro de Sorteios</a>
                    </li>

                </ul>

            </nav>

            <!-- CONTEUDO DA PAGINA  -->
            <div id="content">

                <nav class="navbar">

                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-info">

                            <i class="fas fa-align-left"></i>

                            <span>Barra de Navegação</span>

                        </button>

                        <h2>Sistema de Contribuições</h2>

                    </div>

                </nav>

                <div id = "visualizar" class = "col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <!--AJAX IRA CARREGAR AS PAGINAS AQUI DENTRO-->
                </div>

            </div>
        </div>

        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script> 

        <script>
            
            contribuidores();

            function contribuidores(){
                $.ajax({
                    url: 'telas_usuario/contribuidores.php',
                    success: function(mostrar){
                        $('#visualizar').html(mostrar);
                    }
                });
           }

            function cadastrar_contribuidor(){
                $.ajax({
                    url: 'telas_usuario/cadastrar_contribuidor.php',
                    success: function(mostrar){
                        $('#visualizar').html(mostrar);
                    }
                });
            }

            function contribuicoes(){
                $.ajax({
                    url: 'telas_usuario/contribuicoes.php',
                    success: function(mostrar){
                        $('#visualizar').html(mostrar);
                    }
                });
            }

            function registro_sorteios(){
                $.ajax({
                    url: 'telas_usuario/registro_sorteios.php',
                    success: function(mostrar){
                        $('#visualizar').html(mostrar);
                    }
                });
            }

            //ESCONDER E MOSTRAR SIDEBAR
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

        </script>

    </body>

</html>