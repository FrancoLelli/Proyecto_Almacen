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
        $borrarReg = $db->query("UPDATE proveedor1 SET estadoReal = 0 WHERE proveedor1.Prod_id = $id");
        header('Location: ../proveedores.php');  
    }

?>