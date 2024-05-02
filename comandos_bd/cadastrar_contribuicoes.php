<?php
    //CADASTRAR CONTRIBUICAO//
    require '../conexao/conexao_bd.php';

    $data_contribuicao = $_POST['data_contribuicao'];
    $id_contribuidor = $_POST['id_contribuidor'];
    $valor_contribuicao = $_POST['valor_contribuicao'];
    $nome_contribuidor = $_POST['nome_contribuidor'];
    $apelido_contribuidor = $_POST['apelido_contribuidor'];

    // NO LUGAR DA VIRGULA POE O PONTO E LOGO DEPOIS ELE RECEBE A VARIAVEL COM O VALOR QUE REMOVE OS PONTOS DO MILHAR
    $valor = str_replace(',', '.', str_replace('.', '', $valor_contribuicao));

    //SALVA OS DADOS NO BANCO DE DADOS ALTERAVEL (DO MES ATUAL)

    $comando = "INSERT INTO contribuicoes (data_contribuicao, id_contribuidor, nome_contribuidor, apelido_contribuidor, valor_contribuicao) 
                VALUES ('$data_contribuicao', '$id_contribuidor', '$nome_contribuidor', '$apelido_contribuidor', '$valor')";

    $inquerir = mysqli_query($conexao, $comando);

    mysqli_close($conexao);
?>