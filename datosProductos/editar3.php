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
                    $queryDatos = $db->query("SELECT (prod.Prod_id) as 'id' ,(prod.Prod_nombre) as 'Nombre', (prod.precio) as 'Precio',(prod.Prod_stock) as 'Stock', (proveedor1.Prov_nombre) as 'Proveedor', (prod.estadoReal) as 'Estado', (proveedor1.Prod_id) as 'ProvId',CodigoProd FROM prod, proveedor1 WHERE proveedor1.Prod_id = prod.Prod_id_prov AND prod.Prod_id = '$id'");
                    $arrayUsuario = $queryDatos->fetch_array();
                ?>
                <form class="form" id="formulario" method="POST">
                    <div class="tituloForm"><h2>Editar Producto con ID: <?php echo $_GET['id'] ?></h2></div>
                    <hr>
                    <div class="divForm">
                        <label for="apellido">Codigo:</label>
                        <input type="text" name="code" placeholder="Ingresar codigo" id="codProd" value="<?php echo $arrayUsuario['CodigoProd'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" placeholder="Ingresar nombre" id="nombreProd" value="<?php echo $arrayUsuario['Nombre'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="name">Precio:</label>
                        <input type="number" name="precio" placeholder="Ingresar precio" id="precioProd" value="<?php echo $arrayUsuario['Precio'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="dni">Stock:</label>
                        <input type="number" name="stock" placeholder="Ingresar stock" id="stockProd" value="<?php echo $arrayUsuario['Stock'] ;?>">
                    </div>
                    <div class="divForm">
                        <label for="ciudad">Proveedor:</label>
                        <select name="proveedor" id="proveedor">
                        <?php
                            $arrayConsulta = $db->query("SELECT (proveedor1.Prod_id) as 'id_prov', (proveedor1.Prov_apellido) as 'NombreProv' FROM proveedor1 ORDER BY Prov_apellido");
                            $consulta = $arrayConsulta->fetch_array();
                            while($consulta != null){
                                if($consulta['id_prov'] == $arrayUsuario['ProvId']){
                                    echo "<option value=".$arrayUsuario['ProvId']." selected>".$consulta['NombreProv']."</option>";
                                }else{
                                    echo "<option value=".$consulta['id_prov'].">".$consulta['NombreProv']."</option>";
                                }
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
                                if($consulta['valorEstado'] == $arrayUsuario['Estado']){
                                    echo "<option value=".$arrayUsuario['Estado']." selected>".$consulta['nombre']."</option>";
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
                        <button type="reset" class="btn btn-secondary"><a style="text-decoration:none; color:white"class="enlacesBtn" href="../productos.php">Volver</a></button>
                    </div>
                </form>
                <?php 
                    if(!isset($_POST['actualizar'])){

                    }else{
                        $code = $_POST['code'];
                        $nom = $_POST['name'];
                        $precio = $_POST['precio'];
                        $stock = $_POST['stock'];
                        $prov = $_POST['proveedor'];
                        $estado = $_POST['estado'];

                        $actualizarDatos = $db->query("UPDATE prod SET Prod_nombre = '$nom', precio = '$precio', Prod_stock = '$stock', CodigoProd = '$code', Prod_id_prov = '$prov', estadoReal = '$estado' WHERE Prod_id = '$id'");
                        echo "<script>location.href='../productos.php'</script>";

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