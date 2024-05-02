<?php
    require '../conexao/conexao_bd.php';

    $id = $_POST['id'];

    $comando_deletar_contribuidor = "DELETE FROM contribuidores WHERE '$id' = id";

    $inquerir_contribuidor = mysqli_query($conexao, $comando_deletar_contribuidor);

    mysqli_close($conexao);

?>