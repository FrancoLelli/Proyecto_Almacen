<?php

    $db = new mysqli('localhost', 'root', '', 'sistema_prog');

    if($db->connect_errno != null){
        echo 'el error es: '.$db->connect_errno.'<br> Corresponde a: '.$db->connect_error.'<br>';
    }else{
        /* echo 'se conecto con exito <br>'; */
    };

    if(!isset($_GET['id'])){
                            
    }else{
        $id = $_GET['id'];
        $borrarReg = $db->query("UPDATE prod SET estadoReal = 0, prod.Prod_stock = 0 WHERE prod.Prod_id = $id");
        header('Location: ../productos.php');  
    }

?>