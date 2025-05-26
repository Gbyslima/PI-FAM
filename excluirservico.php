<?php

    if(!empty($_GET['id']))
    {
        include_once('db.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT *  FROM servico WHERE id=$id";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM servico WHERE id=$id";
            $resultDelete = $conexao->query($sqlDelete);
        }
    }
    header('Location: servicos.php');
   
?>