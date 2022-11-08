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
        $canti = $_GET['cantidad'];
        $db->query("UPDATE prod SET Prod_stock = (Prod_stock + '$canti') WHERE Prod_id = '$id'");
        $db->query("DELETE FROM prod_venta1 WHERE prod_venta1.ProdVent_prod = '$id'");
        header('Location: ../ventas.php');  
    }

?>