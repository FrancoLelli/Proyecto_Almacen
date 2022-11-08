<?php

    session_start();

    $db = new mysqli('localhost', 'root', '', 'sistema_prog');
    if($db->connect_errno != null){
        echo 'el error es: '.$db->connect_errno.'<br> Corresponde a: '.$db->connect_error.'<br>';
    }else{
        /* echo 'se conecto con exito <br>'; */
    };

    if(!isset($_SESSION['email'])){
        header("Location: ../login.php");
    }else{
        $email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Sistema</title>
    <link rel="icon" type="image/x-icon" href="../img/market.png">
    <!-- Link al CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Link BootsTrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!--Link IcoFont-->
    <script src="https://kit.fontawesome.com/576ee62c68.js" crossorigin="anonymous"></script>
    <!-- Link a Script -->
    <script defer src="./js/scriptSistema.js"></script>
</head>
<body>
    <header class="header">
        <div class="divGeneral logo-nav-container">
            <a href="" class="logo">MARKET</a>
        </div>
    </header>
    <main>
        <div>
            <h1 class="tituloPagina">REGISTROS VENTAS</h1>
        </div>
        <section class="panelProv">
            </div>
            <div class="tablaProv">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Total</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $arrayConsulta = $db->query("SELECT (venta1.Vent_id) as 'Id Venta', (cliente.Cli_nombre) as 'Cliente', (cliente.Cli_apellido) as 'Apellido', (venta1.Vent_precio_tot) as 'Total' FROM venta1, cliente WHERE venta1.Vent_id_cliente = cliente.Cli_id;");
                        $consulta = $arrayConsulta->fetch_array();
                        while($consulta != null){
                            echo "<tr> <td> <b>".$consulta["Id Venta"]."</b></td>";
                            echo "<td> ".$consulta["Cliente"]."</td>";
                            echo "<td> ".$consulta["Apellido"]."</td>";
                            echo "<td> $".$consulta["Total"]."</td>";
                            echo "<td>
                            <a href='./verDetallesVenta.php?id=".$consulta['Id Venta']."'><button type='submit' class='btn btn-secondary' name='editarReg'>Ver Detalles</button></a> 
                            </td></tr>";
                            /* ? -> para indicar parametros luego de la URL */
                            $consulta = $arrayConsulta->fetch_array();
                        }
                    ?>
                </tbody>
            </table>
            <a href="../ventas.php"><button class='btn btn-secondary'>Volver</button></a>

        </section>
    </main>
    <footer class="footer">
        <div class="">
            <p>
                Diseñado por @francolelli
            </p>
        </div>
    </footer>
    <!-- Link Script BootsTrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
?>