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
    <title>Clientes - Sistema</title>
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
            <h1 class="tituloPagina">CLIENTES</h1>
        </div>
        <section class="panelProv">
            <div class="formProv">
                <form class="form" action="clientes.php" id="formulario" method="post">
                    <div class="tituloForm"><h2>Crear Cliente</h2></div>
                    <hr>
                    <div class="divForm">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" placeholder="Ingresar nombre" id="nombreCli">
                    </div>
                    <div class="divForm">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" placeholder="Ingresar apellido" id="apellidoCli">
                    </div>
                    <div class="divForm">
                        <label for="dni">DNI:</label>
                        <input type="number" onkeydown="return event.keyCode !== 69" name="dni" placeholder="Ingresar dni" id="dniCli">
                    </div>
                    <div class="divForm">
                        <label for="ciudad">Ciudad:</label>
                        <select name="localidad" id="localidad">
                        <?php
                            $arrayConsulta = $db->query("SELECT (loc.Loc_id) as 'id_loc', (loc.Loc_nombre) as 'NombreLoc' FROM loc ORDER BY Loc_nombre");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                echo "<option value=".$consulta['id_loc'].">".$consulta['NombreLoc']."</option>";
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

                    if(!isset($_POST['name']) || !isset($_POST['apellido']) || !isset($_POST['dni']) || !isset($_POST['localidad']) || !isset($_POST['estado']) ){
                    
                    }else{
                        $nom = $_POST['name'];
                        $apellido = $_POST['apellido'];
                        $dni = $_POST['dni'];
                        $loc = $_POST['localidad'];
                        $estado = $_POST['estado'];

                        $queryDNI = $db->query("SELECT Cli_DNI FROM cliente WHERE Cli_DNI = '$dni'");
                        $arrayQuery = $queryDNI->fetch_array();

                        if($arrayQuery != null){
                            echo "<p align=center>EL DNI SE ENCUENTRA REPETIDO</p>";
                        }else{
                            $insertarDatos = $db->query("INSERT INTO cliente(Cli_nombre, Cli_apellido, Cli_DNI, Cli_id_loc, estadoReal) VALUES ('$nom','$apellido','$dni','$loc', '$estado')");
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
                        <th scope="col">Apellido</th>
                        <th scope="col">Ciudad</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $arrayConsulta = $db->query("SELECT (cliente.Cli_id) as 'id' ,(cliente.Cli_nombre) as 'Nombre', (cliente.Cli_apellido) as 'Apellido', (loc.Loc_nombre) as 'Ciudad', estadoReal FROM cliente,loc WHERE loc.Loc_id = cliente.Cli_id_loc AND estadoReal = 1");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                echo "<tr> <td> <b>".$consulta["id"]."</b></td>";
                                echo "<td> ".$consulta["Nombre"]."</td>";
                                echo "<td> ".$consulta["Apellido"]."</td>";
                                echo "<td> ".$consulta["Ciudad"]."</td>";
                                echo "<td>
                                <a href='./datosClientes/editar2.php?id=".$consulta['id']."'><button type='submit' class='btn btn-secondary' name='editarReg'>Editar</button></a> 
                                <a href='./datosClientes/eliminar2.php?id=".$consulta['id']."'><button type='button' class='btn btn-secondary' name='eliminarReg' id='btnEliminarReg' onclick='return borrarReg()'>Eliminar</button></a>
                                </td></tr>";
                                /* ? -> para indicar parametros luego de la URL */
                                $consulta = $arrayConsulta->fetch_array();
                            }
                        ?>
                    </tbody>
                </table>
                <a href="./datosClientes/verTodos2.php"><button class='btn btn-secondary'>Ver Todos</button></a>
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
            const valorDNI = document.getElementById('dniCli').value
            const btnAgregar = document.getElementById('btnAgregar')
            if(valorDNI.length >6 && valorDNI.length < 9){
                form.submit()
                form.reset()
            }else{
                alert('DNI incorrecto')
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