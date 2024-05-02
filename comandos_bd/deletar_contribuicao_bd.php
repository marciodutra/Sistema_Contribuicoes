<?php
    require '../conexao/conexao_bd.php';

    $id = $_POST['id'];

    $comando_deletar = "DELETE FROM contribuicoes WHERE '$id' = id_contribuicao";

    $inquerir = mysqli_query($conexao, $comando_deletar);

    mysqli_close($conexao);

?>