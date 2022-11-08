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
    <title>Proveedores - Sistema</title>
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
            <h1 class="tituloPagina">PROVEEDORES</h1>
        </div>
        <section class="panelProv">
            <div class="formProv">
                <form class="form" action="proveedores.php" id="formulario" method="post">
                    <div class="tituloForm"><h2>Crear Proovedor</h2></div>
                    <hr>
                    <div class="divForm">
                        <label for="name">Razon Social:</label>
                        <input type="text" name="name" placeholder="Ingresar Razon Social" id="nombreProv">
                    </div>
                    <div class="divForm">
                        <label for="apellido">Nom. Fantasía:</label>
                        <input type="text" name="apellido" placeholder="Ingresar Nombre Fantasía" id="apellidoProv">
                    </div>
                    <div class="divForm">
                        <label for="dni">CUIT:</label>
                        <input type="number" onkeydown="return event.keyCode !== 69" name="dni" placeholder="Ingresar CUIT" id="dniProv">
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
                        $cuit = $_POST['dni'];
                        $loc = $_POST['localidad'];
                        $estado = $_POST['estado'];

                        $queryCUIT = $db->query("SELECT Prov_DNI FROM proveedor1 WHERE Prov_DNI = '$cuit'");
                        $arrayQuery = $queryCUIT->fetch_array(); 

                        if($nom === "" || $apellido === ""){
                            echo "<p align='center'>INCORRECTO, INGRESAR DATOS EN TODOS LOS CAMPOS</p>";
                        }else{
                            if($arrayQuery != null){
                                echo "<p align=center>EL CUIT SE ENCUENTRA REPETIDO O ES INCORRECTO</p>";
                            }else{
                                $insertarDatos = $db->query("INSERT INTO proveedor1(Prov_nombre, Prov_apellido, Prov_DNI, Prov_id_loc, estadoReal) VALUES ('$nom','$apellido','$cuit','$loc', '$estado')");
                            }
                        }
                        
   
                    }   
                ?>
            </div>
            <div class="tablaProv">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Razon S.</th>
                        <th scope="col">Nombre Fant.</th>
                        <th scope="col">Ciudad</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $arrayConsulta = $db->query("SELECT (proveedor1.Prod_id) as 'id' ,(proveedor1.Prov_nombre) as 'Nombre', (proveedor1.Prov_apellido) as 'Apellido', (loc.Loc_nombre) as 'Ciudad', estadoReal FROM proveedor1,loc WHERE loc.Loc_id = proveedor1.Prov_id_loc AND estadoReal = 1");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                echo "<tr> <td> <b>".$consulta["id"]."</b></td>";
                                echo "<td> ".$consulta["Nombre"]."</td>";
                                echo "<td> ".$consulta["Apellido"]."</td>";
                                echo "<td> ".$consulta["Ciudad"]."</td>";
                                echo "<td>
                                <a href='./datosProveedores/editar1.php?id=".$consulta['id']."'><button type='submit' class='btn btn-secondary' name='editarReg'>Editar</button></a> 
                                <a href='./datosProveedores/eliminar1.php?id=".$consulta['id']."'><button type='button' class='btn btn-secondary' name='eliminarReg' id='btnEliminarReg' onclick='return borrarReg()'>Eliminar</button></a>
                                </td></tr>";
                                /* ? -> para indicar parametros luego de la URL */
                                $consulta = $arrayConsulta->fetch_array();
                            }
                        ?>
                    </tbody>
                </table>
                <a href="./datosProveedores/verTodos.php"><button class='btn btn-secondary'>Ver Todos</button></a>
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
        /* Validacion de CUIT */
        function validar(){
            const form = document.getElementById('formulario')
            const valorCUIT = document.getElementById('dniProv').value
            contadorError = 0
            coeficientes = [5,4,3,2,7,6,5,4,3,2]
            sumaDigitos = 0
            
            if(isNaN(valorCUIT)){
                alert('CUIT incorrecto')
                return
            }
            
            if(valorCUIT.length != 11){
                alert('CUIT incorrecto')
                return
            }

            prefijo = valorCUIT.slice(0,2)
            prefijosValidos = [20,23,24,25,26,27,30]
            prefijosValidos.forEach(prefijo => {
                if(prefijo !== prefijo){
                    contadorError ++
                }
            });

            if(contadorError != 0){
                alert('CUIT incorrecto')
                return
            }

            for (let i = 0; i < 10; i++) {
                sumaDigitos = sumaDigitos + (valorCUIT[i] * coeficientes[i])
            }

            resto = sumaDigitos % 11

            if((11-resto) != valorCUIT[10]){
                alert('CUIT incorrecto')
                return
            }else{
                form.submit()
                form.reset()  
            }
        }

        /* Pregunta para eliminar */
        function borrarReg(){
            respuestaUsuario = confirm('¿Estas seguro que quieres eliminar el registro?')
            return respuestaUsuario
        }
    </script>
</body>
</html>
<?php
}
?>