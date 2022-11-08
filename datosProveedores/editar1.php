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
            <h1 class="tituloPagina">EDITAR DATOS</h1>
        </div>
        <section class="panelProv">
            <div class="formProv">
                <?php
                    $id= $_GET['id'];
                    $queryDatos = $db->query("SELECT (proveedor1.Prov_nombre) as 'Nombre', (proveedor1.Prov_apellido) as 'Apellido', (loc.Loc_nombre) as 'Ciudad',  (loc.loc_id) as 'id_loc', Prov_DNI as 'DNI', estadoReal FROM proveedor1,loc WHERE loc.Loc_id = proveedor1.Prov_id_loc AND Prod_id = '$id'");
                    $arrayUsuario = $queryDatos->fetch_array();
                ?>
                <form class="form" id="formulario" method="POST">
                    <div class="tituloForm"><h2>Editar Proovedor con ID: <?php echo $_GET['id'] ?></h2></div>
                    <hr>
                    <div class="divForm">
                        <label for="name">Razon Social:</label>
                        <input type="text" name="name" placeholder="Ingresar razon social" id="nombreProv" value="<?php echo $arrayUsuario['Nombre'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="apellido">Nom Fantasía:</label>
                        <input type="text" name="apellido" placeholder="Ingresar nom fantasía" id="apellidoProv" value="<?php echo $arrayUsuario['Apellido'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="dni">CUIT:</label>
                        <input type="number" name="dni" placeholder="Ingresar dni" id="dniProv" value="<?php echo $arrayUsuario['DNI'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="ciudad">Ciudad:</label>
                        <select name="localidad" id="localidad">
                        <?php
                            $arrayConsulta = $db->query("SELECT (loc.Loc_id) as 'id_loc', (loc.Loc_nombre) as 'NombreLoc' FROM loc ORDER BY Loc_nombre");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                if($consulta['id_loc'] == $arrayUsuario['id_loc']){
                                    echo "<option value=".$arrayUsuario['id_loc']." selected>".$arrayUsuario['Ciudad']."</option>";
                                }else{
                                    echo "<option value=".$consulta['id_loc'].">".$consulta['NombreLoc']."</option>";
                                }                                
                                $consulta = $arrayConsulta->fetch_array();
                            };
                        ?>
                        </select>
                            
                    </div>
                    <div class="divForm">
                        <label for="estado">Estado:</label>
                        <select name="estadoValor" id="estado">
                        <?php
                            $arrayConsulta = $db->query("SELECT estado.Nombre as 'nombre', estado.estadoValor as  'valorEstado' FROM estado");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                if($consulta['valorEstado'] == $arrayUsuario['estadoReal']){
                                    echo "<option value=".$arrayUsuario['estadoReal']." selected>".$consulta['nombre']."</option>";
                                }else{
                                    echo "<option value=".$consulta['valorEstado'].">".$consulta['nombre']."</option>";
                                }                                
                                $consulta = $arrayConsulta->fetch_array();
                            };
                        ?>
                        </select>
                            
                    </div>
                    <div class="divForm">
                        <button class="btn btn-secondary" id="btnAgregar" name="actualizar">Modificar</button>
                        <button type="reset" class="btn btn-secondary"><a style="text-decoration:none; color:white"class="enlacesBtn" href="../proveedores.php">Volver</a></button>
                    </div>
                </form>
                <?php 
                    if(!isset($_POST['actualizar'])){

                    }else{
                        $id = $_GET['id'];
                        $nom = $_POST['name'];
                        $apellido = $_POST['apellido'];
                        $dni = $_POST['dni'];
                        $loc = $_POST['localidad'];
                        $estado = $_POST['estadoValor'];

                        $actualizarDatos = $db->query("UPDATE proveedor1 SET Prov_nombre = '$nom', Prov_apellido = '$apellido', Prov_DNI = '$dni', Prov_id_loc = '$loc', estadoReal = '$estado' WHERE Prod_id = '$id'");
                        echo "<script>location.href='../proveedores.php'</script>";

                    } 
                ?>
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
</body>
</html>
<?php
}
?>