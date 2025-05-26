<?php

    if(!empty($_GET['id']))
    {
        include_once('db.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT *  FROM ordemdeservico WHERE id=$id";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM ordemdeservico WHERE id=$id";
            $resultDelete = $conexao->query($sqlDelete);
        }
    }
    header('Location: ordemdeservico.php');
   
?>