<?php
    //CADASTRAR CONTRIBUIDOR//
    require '../conexao/conexao_bd.php';

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];

    $comando = "INSERT INTO contribuidores (nome, telefone, apelido, email, cidade, bairro, rua, numero) 
                VALUES ('$nome', '$telefone', '$apelido', '$email', '$cidade', '$bairro', '$rua', '$numero')";

    $inquerir = mysqli_query($conexao, $comando);

    mysqli_close($conexao);
?>