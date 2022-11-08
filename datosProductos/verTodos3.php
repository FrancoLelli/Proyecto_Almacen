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
    <title>Productos - Sistema</title>
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
            <h1 class="tituloPagina">REGISTROS PRODUCTOS</h1>
        </div>
        <section class="panelProv">
            <div class="tablaProv">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $arrayConsulta = $db->query("SELECT (prod.Prod_id) as 'id' ,(prod.Prod_nombre) as 'Nombre', (prod.Prod_stock) as 'Stock', (proveedor1.Prov_nombre) as 'Proveedor', (prod.estadoReal) as 'Estado', CodigoProd FROM prod, proveedor1 WHERE proveedor1.Prod_id = prod.Prod_id_prov");
                        $consulta = $arrayConsulta->fetch_array();
                        while($consulta != null){
                            echo "<tr> <td> <b>".$consulta["CodigoProd"]."</b></td>";
                            echo "<td> ".$consulta["Nombre"]."</td>";
                            echo "<td> ".$consulta["Stock"]."</td>";
                            echo "<td> ".$consulta["Proveedor"]."</td>";
                            echo "<td>
                            <a href='./editar3.php?id=".$consulta['id']."'><button type='submit' class='btn btn-secondary' name='editarReg'>Editar</button></a> 
                            </td></tr>";
                            /* ? -> para indicar parametros luego de la URL */
                            $consulta = $arrayConsulta->fetch_array();
                        }
                    ?>
                </tbody>
            </table>
            <a href="../productos.php"><button class='btn btn-secondary'>Volver</button></a>
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