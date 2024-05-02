<?php
    //ATUALIZAR VALOR DA CONTRIBUIÇÂO NO BANCO DE DADOS
    require '../conexao/conexao_bd.php';

    $id = $_POST['id'];
    $valor = $_POST['valor'];

    // NO LUGAR DA VIRGULA POE O PONTO E LOGO DEPOIS ELE RECEBE A VARIAVEL COM O VALOR QUE REMOVE OS PONTOS DO MILHAR
    $valor_tratado = str_replace("," , "." , str_replace("." , "" , $valor));

    //ATUALIZADA NA TABELA DO MES
    $comando_update = "UPDATE contribuicoes SET valor_contribuicao = '$valor_tratado' WHERE '$id' = id_contribuicao";

    $comando_update = mysqli_query($conexao, $comando_update);

    mysqli_close($conexao);

?>