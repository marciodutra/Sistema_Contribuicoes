<?php
    //SALVAR SORTEIO
    require '../conexao/conexao_bd.php';

    $id_contribuidor = $_POST['id_contribuidor'];
    $data_atual = date("Y-m-d");

    //PEGAR NOME E APELIDO DO CONTRIBUIDOR PARA SALVAR NO REGISTRO
    $comando_buscar_contribuidor = "SELECT nome, apelido FROM contribuidores WHERE id = '$id_contribuidor'";

    $buscar_contribuidor = mysqli_query($conexao, $comando_buscar_contribuidor);

    $contribuidor = mysqli_fetch_row($buscar_contribuidor);

    $comando_inserir = "INSERT INTO sorteios(data_sorteio, id_contribuidor, nome_contribuidor, apelido_contribuidor)
                        VALUES('$data_atual','$id_contribuidor', '$contribuidor[0]', '$contribuidor[1]')";

    $inquerir = mysqli_query($conexao, $comando_inserir);

    mysqli_close($conexao);

?>