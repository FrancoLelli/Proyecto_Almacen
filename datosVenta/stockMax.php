<?php

    $db = new mysqli('localhost', 'root', '', 'sistema_prog');

    if($db->connect_errno != null){
        echo 'el error es: '.$db->connect_errno.'<br> Corresponde a: '.$db->connect_error.'<br>';
    }else{
        /* echo 'se conecto con exito <br>'; */
    };
    
    $valor = $_POST['val'];
    
    $query = $db->query("SELECT Prod_stock FROM `prod` WHERE Prod_id = '$valor'");

    $arrayQuery = $query->fetch_array();

    echo $arrayQuery[0];

?>


