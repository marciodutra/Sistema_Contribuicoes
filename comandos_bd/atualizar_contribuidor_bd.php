<?php
    require '../conexao/conexao_bd.php';

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];

    //ATUALIZAR NO BANCO DE DADOS DOS CONTRIBUIDORES

    $comando_update = "UPDATE contribuidores SET nome = '$nome', telefone = '$telefone', apelido = '$apelido', email = '$email', cidade = '$cidade', bairro = '$bairro',
                                             rua = '$rua', numero = '$numero' WHERE '$id' = id";

    $inquerir_update = mysqli_query($conexao, $comando_update);

    //ATUALIZAR NO BANCO DE DADOS DAS CONTRIBUICOES

    $comando_update2 = "UPDATE contribuicoes SET nome_contribuidor = '$nome', apelido_contribuidor = '$apelido' WHERE '$id' = id_contribuidor";

    $inquerir_update2 = mysqli_query($conexao, $comando_update2);

    //ATUALIZAR NO BANCO DE DADOS DOS SORTEIOS

    $comando_update3 = "UPDATE sorteios SET nome_contribuidor = '$nome', apelido_contribuidor = '$apelido' WHERE '$id' = id_contribuidor";

    $inquerir_update3 = mysqli_query($conexao, $comando_update3);

    mysqli_close($conexao);

?>