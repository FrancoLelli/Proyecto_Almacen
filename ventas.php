<?php
    session_start();

    $db = new mysqli('localhost', 'root', '', 'sistema_prog');
    if($db->connect_errno != null){
        echo 'el error es: '.$db->connect_errno.'<br> Corresponde a: '.$db->connect_error.'<br>';
    }else{
        /* echo 'se conecto con exito <br>'; */
    };

    if(!isset($_SESSION['email'])){
        header("Location: ./login.php");
    }else{
        $email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Sistema</title>
    <link rel="icon" type="image/x-icon" href="./img/market.png">
    <!-- Link al CSS -->
    <link rel="stylesheet" href="./css/styles.css">
    <!-- Link BootsTrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!--Link IcoFont-->
    <script src="https://kit.fontawesome.com/576ee62c68.js" crossorigin="anonymous"></script>
    <!-- Link a Script -->
    <script defer src="./js/scriptSistema.js"></script>
    <!-- Link JQuery  -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="divGeneral logo-nav-container">
            <a href="./index.php" class="logo">MARKET</a>
            <span class="barra"><i class="fas fa-bars"></i></span>
            
            <nav class="navegation">
                <ul class="listaNav">
                    <li><a href="./proveedores.php">Proveedores</a></li>
                    <li><a href="./clientes.php">Clientes</a></li>
                    <li><a href="./productos.php">Productos</a></li>
                    <li><a href="./ventas.php">Ventas</a></li>
                    <li><a href="./estadisticas.php">Estadisticas</a></li>
                    <li><a href="./contacto.php">Contacto</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-tie logo2"></i>
                        <?php 
                            $consultaNom = $db->query("SELECT Usu_nombre FROM usuario WHERE Usu_email = '$email'");
                            $arrayNom = $consultaNom->fetch_array();
                            echo $arrayNom[0];
                        ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a style="color: black;" href="./cerrarSesion/cerrarSesion.php">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div>
            <h1 class="tituloPagina">VENTAS</h1>
        </div>
            <?php

                $queryNumeroVenta = $db->query("SELECT (Vent_id+1) FROM venta1 ORDER BY Vent_id DESC LIMIT 1");
                $arrayNumeroVenta = $queryNumeroVenta->fetch_array();
                echo "<h2 class='confirmarVenta'>Venta numero: ".$arrayNumeroVenta[0]."</h2>";
            ?>
            <section class="panelProv">
                <div class="formProv">
                    <form class="form" action="ventas.php" id="formulario" method="post">
                        <div class="tituloForm"><h2>Cargar Venta</h2></div>
                        <hr>
                        <div class="divForm">
                            <label for="name">Producto:</label>
                            <select name="producto" id="producto" onchange="enviarNombre()">
                            <?php
                                $arrayConsulta = $db->query("SELECT (prod.Prod_id) as 'id_prod', (prod.Prod_nombre) as 'NombreProd' FROM prod ORDER BY Prod_nombre");
                                $consulta = $arrayConsulta->fetch_array();
                                while($consulta != null){
                                    echo "<option value=".$consulta['id_prod'].">".$consulta['NombreProd']."</option>";
                                    $consulta = $arrayConsulta->fetch_array();
                                };
                            ?>
                            </select>
                        </div>
                        <div class="divForm">
                            <label for="">Stock Max:</label>
                            <label for="" id="stockmax"></label>
                        </div>
                        <div class="divForm">
                            <label for="apellido">Cantidad:</label>
                            <input type="number" onkeydown="return event.keyCode !== 69" name="cantidadProducto" placeholder="Ingresar cantidad" id="cantidadVent">
                        </div>
                        <div class="divForm">
                            <label for="desc">Descuento:</label>
                            <input type="number" onkeydown="return event.keyCode !== 69" name="desc" placeholder="Ingresar descuento" id="descVenta" value=0>
                        </div>
                        <div class="divForm">
                            <button type="button" class="btn btn-secondary" id="btnAgregar" onclick="validar()">Ingresar Producto</button>
                            <button type="reset" class="btn btn-secondary">Resetear</button>
                        </div>
                    </form>
                    <?php

                        if(!isset($_POST['producto']) || !isset($_POST['cantidadProducto']) || !isset($_POST['desc'])){
                            
                        }else{
                            $id_Vent = $arrayNumeroVenta[0];
                            $idProd = $_POST['producto'];
                            $cantidadProd = $_POST['cantidadProducto'];
                            $desc = $_POST['desc'];
                            $queryPrecio = $db->query("SELECT precio from prod WHERE prod.Prod_id = '$idProd'");
                            $arrayPrecio = $queryPrecio->fetch_array();
                            $descuento = $arrayPrecio[0]  * ($desc / 100);
                            $precio = ($arrayPrecio[0] * $cantidadProd) - $descuento;
                            
                            /*Query Stock */
                            $queryStock = $db->query("SELECT Prod_stock FROM prod WHERE Prod_id = '$idProd'");
                            $varStock = $queryStock->fetch_array();
                            if($varStock[0] >= $cantidadProd){
                                $db->query("UPDATE prod SET Prod_stock = (Prod_stock - '$cantidadProd') WHERE Prod_id = '$idProd'");
                                $db->query("INSERT INTO prod_venta1(ProdVent_venta, ProdVent_prod, ProdVent_cantidad, precioVenta) VALUES ('$id_Vent' ,'$idProd','$cantidadProd','$precio')"); 
                            }else{
                                echo "<p align=center>SIN STOCK. INGRESAR UN VALOR MENOR</p>";
                            } 
                        }   
                    ?>
                </div>
                <div class="tablaProv">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $arrayConsulta = $db->query("SELECT (prod_venta1.ProdVent_prod) as 'Id_Vent_Prod' ,(prod.CodigoProd) as 'id' ,(prod.Prod_nombre) as 'Nombre', SUM((prod_venta1.ProdVent_cantidad)) as 'Cantidad', SUM((prod_venta1.precioVenta)) as 'Precio' FROM prod_venta1, prod WHERE prod.Prod_id = prod_venta1.ProdVent_prod AND prod_venta1.ProdVent_venta = '$arrayNumeroVenta[0]' GROUP BY prod.Prod_id;");
                                $consulta = $arrayConsulta->fetch_array();
                                while($consulta != null){
                                    echo "<tr> <td> <b>".$consulta["id"]."</b></td>";
                                    echo "<td> ".$consulta["Nombre"]."</td>";
                                    echo "<td> ".$consulta["Cantidad"]."</td>";
                                    echo "<td> ".$consulta["Precio"]."</td>";
                                    echo "<td>
                                    <a href='./datosVenta/eliminarprodVenta.php?id=".$consulta['Id_Vent_Prod']."&cantidad=".$consulta['Cantidad']."'><button type='button' class='btn btn-secondary' name='eliminarReg' id='btnEliminarReg'>Eliminar</button></a>
                                    </td></tr>";
                                    /* ? -> para indicar parametros luego de la URL */
                                    $consulta = $arrayConsulta->fetch_array();
                                }
                                
                            ?>
                        </tbody>
                    </table>
                    <?php
                        $queryTot = $db->query("SELECT SUM(precioVenta) as 'Total' FROM prod_venta1 WHERE prod_venta1.ProdVent_venta = '$arrayNumeroVenta[0]'");
                        $arrayQuery = $queryTot->fetch_array();
                        echo "<p class='confirmarVenta'>Total: ".$arrayQuery[0]."</p>";
                    ?>
                </div>
                
            </section>
        <form action="./datosVenta/confirmarVenta.php" method="POST" id="form2">
            <div class="confirmarVenta">
                <label for="cliente">Cliente:</label>
                <?php
                    $queryTot = $db->query("SELECT SUM(precioVenta) as 'Total' FROM prod_venta1 WHERE prod_venta1.ProdVent_venta = '$arrayNumeroVenta[0]'");
                    $arrayQuery = $queryTot->fetch_array();
                    echo "<input type='hidden' name='total' value='$arrayQuery[0]'></input>";
                ?>
                <select name="cliente" id="cliente">
                <?php
                    /* Query Clientes */
                    $arrayConsulta = $db->query("SELECT (cliente.Cli_id) as 'id_cli', (cliente.Cli_nombre) as 'NombreCli' FROM cliente ORDER BY cliente.Cli_nombre");
                    $consulta = $arrayConsulta->fetch_array();
                    while($consulta != null){
                        echo "<option value=".$consulta['id_cli'].">".$consulta['NombreCli']."</option>";
                        $consulta = $arrayConsulta->fetch_array();
                    };
                ?>
                </select>
            </div>
            <div class="confirmarVenta">
                <button type='submit' class='btn btn-secondary'>Finalizar Venta</button>
            </div>
        </form>
        <div class="confirmarVenta">
        <a href="./datosVenta/verTodasVentas.php"><button class='btn btn-secondary'>Ver Todas</button></a>
        </div>
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
    <script>
        /* Validacion de DNI */
        function validar(){
            const form = document.getElementById('formulario')
            const valorCantidad = document.getElementById('cantidadVent').value
            const valorDesc = document.getElementById('descVenta').value
            const btnAgregar = document.getElementById('btnAgregar')
            if(valorCantidad > 0 && valorDesc >= 0){
                form.submit()
                form.reset()
            }else{
                alert('Cantidad o descuento incorrecto')
                alert('En caso que no tenga descuento, por favor ingresar 0')
                return
                
            }
        }
        
        /* Pregunta para eliminar */
        function finalizarVenta(){
            const form2 = document.getElementById('form2')
            respuestaUsuario = confirm('¿Estas seguro que quieres finalizar la venta?')
            return respuestaUsuario
        }

        function enviarNombre(){
            valor = document.getElementById("producto").value
            valorTot = "val="+valor
            $.ajax({
                    type: 'post',
                    url: 'datosVenta/stockMax.php',
                    data: valorTot,
                    success: function(respuesta){
                        $('#stockmax').html(respuesta)
                    }
                }
            );
            return false
        }
    </script>
</body>
</html>
<?php
}
?>