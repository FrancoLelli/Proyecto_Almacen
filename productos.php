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
    <title>Productos - Sistema</title>
    <link rel="icon" type="image/x-icon" href="./img/market.png">
    <!-- Link al CSS -->
    <link rel="stylesheet" href="./css/styles.css">
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
            <h1 class="tituloPagina">PRODUCTOS</h1>
        </div>
        <section class="panelProv">
            <div class="formProv">
                <form class="form" action="productos.php" id="formulario" method="post">
                    <div class="tituloForm"><h2>Cargar Producto</h2></div>
                    <hr>
                    <div class="divForm">
                        <label for="dni">Codigo:</label>
                        <input type="text" name="code" placeholder="Ingresar codigo" id="codProd">
                    </div>
                    <div class="divForm">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" placeholder="Ingresar nombre" id="nombreProd">
                    </div>
                    <div class="divForm">
                        <label for="name">Precio:</label>
                        <input type="number" onkeydown="return event.keyCode !== 69" name="precio" placeholder="Ingresar precio" id="precioProd">
                    </div>
                    <div class="divForm">
                        <label for="stock">Stock:</label>
                        <input type="number" onkeydown="return event.keyCode !== 69" name="stock" placeholder="Ingresar stock" id="stockProd">
                    </div>
                    <div class="divForm">
                        <label for="ciudad">Proveedor:</label>
                        <select name="proveedor" id="proveedor">
                        <?php
                            $arrayConsulta = $db->query("SELECT (proveedor1.Prod_id) as 'id_prov', (proveedor1.Prov_apellido) as 'NombreProv' FROM proveedor1 ORDER BY Prov_apellido");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                echo "<option value=".$consulta['id_prov'].">".$consulta['NombreProv']."</option>";
                                $consulta = $arrayConsulta->fetch_array();
                            };
                        ?>
                        </select>
                            
                    </div>
                    <div class="divForm">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado">
                        <?php
                            $arrayConsulta = $db->query("SELECT estado.Nombre as 'nombre', estado.estadoValor as  'valorEstado' FROM estado");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                $value = $consulta['valorEstado'];
                                echo "<option value='$value'>".$consulta['nombre']."</option>";
                                $consulta = $arrayConsulta->fetch_array();
                            };
                        ?>
                        </select>
                            
                    </div>
                    <div class="divForm">
                        <button type="button" class="btn btn-secondary" id="btnAgregar" onclick="validar()">Ingresar</button>
                        <button type="reset" class="btn btn-secondary">Resetear</button>
                    </div>
                </form>
                <?php

                    if(!isset($_POST['name']) || !isset($_POST['code']) || !isset($_POST['proveedor']) || !isset($_POST['precio']) || !isset($_POST['estado']) || !isset($_POST['stock']) ){
                    
                    }else{

                        $code = $_POST['code'];
                        $nom = $_POST['name'];
                        $precio = $_POST['precio'];
                        $stock = $_POST['stock'];
                        $prov = $_POST['proveedor'];
                        $estado = $_POST['estado'];

                        $queryDNI = $db->query("SELECT CodigoProd FROM prod WHERE CodigoProd = '$code'");
                        $arrayQuery = $queryDNI->fetch_array();

                        if($arrayQuery != null){
                            echo "<p align=center>EL CODIGO SE ENCUENTRA REPETIDO</p>";
                        }else{
                            $insertarDatos = $db->query("INSERT INTO prod(Prod_nombre, precio ,Prod_stock, Prod_id_prov, estadoReal, CodigoProd) VALUES ('$nom', '$precio' , '$stock', '$prov', '$estado','$code')");
                        }
   
                    }   
                ?>
            </div>
            <div class="tablaProv">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $arrayConsulta = $db->query("SELECT (prod.Prod_id) as 'id' ,(prod.Prod_nombre) as 'Nombre', (prod.Prod_stock) as 'Stock', (proveedor1.Prov_apellido) as 'Proveedor', (prod.precio) as 'Precio', (prod.estadoReal) as 'Estado', CodigoProd FROM prod, proveedor1 WHERE proveedor1.Prod_id = prod.Prod_id_prov AND prod.estadoReal = 1 AND prod.Prod_stock > 0");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                echo "<tr> <td> <b>".$consulta["CodigoProd"]."</b></td>";
                                echo "<td> ".$consulta["Nombre"]."</td>";
                                echo "<td> $".$consulta["Precio"]."</td>";
                                echo "<td> ".$consulta["Stock"]."</td>";
                                echo "<td> ".$consulta["Proveedor"]."</td>";
                                echo "<td>
                                <a href='./datosProductos/editar3.php?id=".$consulta['id']."'><button type='submit' class='btn btn-secondary' name='editarReg'>Editar</button></a> 
                                <a href='./datosProductos/eliminar3.php?id=".$consulta['id']."'><button type='button' class='btn btn-secondary' name='eliminarReg' id='btnEliminarReg' onclick='return borrarReg()'>Eliminar</button></a>
                                </td></tr>";
                                /* ? -> para indicar parametros luego de la URL */
                                $consulta = $arrayConsulta->fetch_array();
                            }
                        ?>
                    </tbody>
                </table>
                <a href="./datosProductos/verTodos3.php"><button class='btn btn-secondary'>Ver Todos</button></a>
            </div>
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
    <script>
        /* Validacion de DNI */
        function validar(){
            const form = document.getElementById('formulario')
            const valorPrecio = document.getElementById('precioProd').value
            const valorStock = document.getElementById('stockProd').value
            const btnAgregar = document.getElementById('btnAgregar')
            if(valorStock >= 1 && valorPrecio >= 1){
                form.submit()
                form.reset()
            }else{
                alert('Stock o precio incorrecto')
                return
                
            }
        }

        /* Pregunta para eliminar */
        function borrarReg(){
            const btnEliminarReg = document.getElementById("btnEliminarReg")
            respuestaUsuario = confirm('¿Estas seguro que quieres eliminar el registro?')
            return respuestaUsuario
        }
    </script>
</body>
</html>
<?php
}
?>