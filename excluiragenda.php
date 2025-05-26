<?php

    if(!empty($_GET['id']))
    {
        include_once('db.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT *  FROM agendamentos2 WHERE id=$id";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM agendamentos2 WHERE id=$id";
            $resultDelete = $conexao->query($sqlDelete);
        }
    }
    header('Location: agenda.php');
   
?>