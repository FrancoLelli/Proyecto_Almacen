<?php
    session_start();
    
    $db = new mysqli('localhost', 'root', '', 'sistema_prog');
    if($db->connect_errno != null){
        echo 'el error es: '.$db->connect_errno.'<br> Corresponde a: '.$db->connect_error.'<br>';
    }else{
        /* echo 'se conecto con exito <br>'; */
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion - Sistema</title>
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
    <main class="login">
        <div class="container w-50 primary-bg mt-5 rounded">
            <div>
                <div>
                    <h2 class="fw-bold text-center pt-5 mb-5">Crear Usuario</h2>
                    <form method="POST">
                        <div class="mb-4">
                            <label for="name" class="form-label w-100">Nombre</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label w-100">Correo Electronico:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label w-100">Contraseña:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-outline-dark btn-lg" value="Ingresar"><b>Crear Cuenta</b></button>
                        </div>
                    </form>
                    <?php
                    if(!isset($_POST['name']) ||!isset($_POST['email']) || !isset($_POST['password'])){

                    }else{
                        $nombre = $_POST['name'];
                        $email = $_POST['email'];
                        $contrasenia = $_POST['password'];
                        $Arrayconsulta = $db->query("SELECT * FROM usuario WHERE Usu_email ='$email'");
                        $consulta = $Arrayconsulta->fetch_array();
                        if($consulta != null){
                            echo "<p align=center>LOS DATOS YA SE ENCUENTRAN REGISTRADOS</p>"; 
                        }else{
                            $crearUsu = $db->query("INSERT INTO usuario(Usu_nombre, Usu_email, Usu_contra) VALUES ('$nombre','$email','$contrasenia') ");
                            $_SESSION['email'] = $_POST['email'];
                            header('Location: ./index.php');
                        }
                    };

                        
                        
                       
                    ?>
                </div>
                <div class="crearCuenta mt-2">
                    <p>Ya tienes una cuenta creada? <a href="./login.php"><b>Iniciar Sesion</b> </a></p>
                </div>
            </div>
        </div>
    </main>
    <!-- Link Script BootsTrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>