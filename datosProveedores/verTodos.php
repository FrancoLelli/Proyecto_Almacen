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
    <title>Proveedor - Sistema</title>
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
            <h1 class="tituloPagina">REGISTROS PROVEEDORES</h1>
        </div>
        <section class="panelProv">
            </div>
            <div class="tablaProv">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $arrayConsulta = $db->query("SELECT (proveedor1.Prod_id) as 'id' ,(proveedor1.Prov_nombre) as 'Nombre', (proveedor1.Prov_apellido) as 'Apellido', (loc.Loc_nombre) as 'Ciudad', estadoReal FROM proveedor1,loc WHERE loc.Loc_id = proveedor1.Prov_id_loc");
                        $consulta = $arrayConsulta->fetch_array();
                        while($consulta != null){
                            echo "<tr> <td> <b>".$consulta["id"]."</b></td>";
                            echo "<td> ".$consulta["Nombre"]."</td>";
                            echo "<td> ".$consulta["Apellido"]."</td>";
                            echo "<td> ".$consulta["Ciudad"]."</td>";
                            echo "<td>
                            <a href='./editar1.php?id=".$consulta['id']."'><button type='submit' class='btn btn-secondary' name='editarReg'>Editar</button></a> 
                            </td></tr>";
                            /* ? -> para indicar parametros luego de la URL */
                            $consulta = $arrayConsulta->fetch_array();
                        }
                    ?>
                </tbody>
            </table>
            <a href="../proveedores.php"><button class='btn btn-secondary'>Volver</button></a>

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