<?php

    $db = new mysqli('localhost', 'root', '', 'sistema_prog');

    if($db->connect_errno != null){
        echo 'el error es: '.$db->connect_errno.'<br> Corresponde a: '.$db->connect_error.'<br>';
    }else{
        /* echo 'se conecto con exito <br>'; */
    };

    $total = $_POST['total'];
    $id_cliente = $_POST['cliente']; 
    $cargarReg = $db->query("INSERT INTO venta1(Vent_id_cliente, Vent_precio_tot) VALUES ('$id_cliente', '$total');");
    $crearVenta = $db->query("SET @variable= (SELECT (Vent_id+1) FROM venta1 ORDER BY Vent_id DESC LIMIT 1); INSERT INTO venta1(Vent_id) VALUES (Vent_id = @variable )");
    header('Location: ../ventas.php');  

?>