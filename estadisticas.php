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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas - Sistema</title>
    <link rel="icon" type="image/x-icon" href="./img/market.png">
    <!-- Link al CSS -->
    <link rel="stylesheet" href="./css/styles.css">
    <!-- Link BootsTrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!--Link IcoFont-->
    <script src="https://kit.fontawesome.com/576ee62c68.js" crossorigin="anonymous"></script>
    <!-- Link a Script -->
    <script defer src="./js/scriptSistema.js"></script>
    <!-- Link Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="mainGrafico">
            <div class="container-fluid">
                <section class="estadisticas">
                    <div>
                        <h1 class="tituloPagina">ESTADISTICAS</h1>
                    </div>
                </section>
                <section class="graficos">
                    <div class="mainGraficoPadre">
                        <canvas id="myChart1"></canvas>
                    </div>
                    <div class="mainGraficoPadre">
                        <canvas id="myChart2"></canvas>
                    </div>
                    <div class="mainGraficoPadre">
                        <canvas id="myChart3"></canvas>
                    </div>
                    <div class="mainGraficoPadre">
                        <canvas id="myChart4"></canvas>
                    </div>
                </section>
            </div>
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
</body>
<script>
    /* Grafico 1 */

    const grafico1 = document.getElementById('myChart1').getContext('2d');
    const myChart = new Chart(grafico1, {
    type: 'bar',
    data: {
        labels: [

            <?php

                    $query = $db->query("SELECT (cliente.Cli_nombre) as 'Nombre', SUM(Vent_precio_tot) as 'Total Comprado' FROM `venta1`, cliente WHERE cliente.Cli_id = venta1.Vent_id_cliente GROUP BY cliente.Cli_id;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Nombre']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>

        ],
        datasets: [{
            label: 'Empleados',
            data: [

                <?php

                    $query = $db->query("SELECT (cliente.Cli_nombre) as 'Nombre', SUM(Vent_precio_tot) as 'Total Comprado' FROM `venta1`, cliente WHERE cliente.Cli_id = venta1.Vent_id_cliente GROUP BY cliente.Cli_id;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Total Comprado']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>


            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
       plugins: {
            title: {
                display: true,
                text: 'Total de $ comprado por Empleados'
            }
        }
    }
});

var chart2 = document.getElementById('myChart2').getContext('2d');
    var chart2 = new Chart(chart2, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: [
            <?php

                    $query = $db->query("SELECT (prod.Prod_nombre) as 'Nombre Producto', SUM(ProdVent_cantidad) 'Cantidad', SUM(precioVenta) as 'Dinero Recaudado' FROM `prod_venta1`, prod WHERE prod.Prod_id = prod_venta1.ProdVent_prod GROUP BY prod_venta1.ProdVent_prod;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Nombre Producto']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>
        ],
        datasets: [{
            label: 'Venta Por Forma de Pago',
            backgroundColor:['#f68d2b',
                             '#1E90FF',
                             '#8A2BE2',
                             '#FF0000'],
            borderColor: 'black',
            data: [
                <?php

                    $query = $db->query("SELECT (prod.Prod_nombre) as 'Nombre Producto', SUM(ProdVent_cantidad) 'Cantidad', SUM(precioVenta) as 'Dinero Recaudado' FROM `prod_venta1`, prod WHERE prod.Prod_id = prod_venta1.ProdVent_prod GROUP BY prod_venta1.ProdVent_prod;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Cantidad']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>
            ]
        }]
    },

    // Configuration options go here
    options: {
       maintainAspectRatio: false,
       plugins: {
            title: {
                display: true,
                text: 'Productos mas Vendidos'
            }
        }
    }
});

var chart3 = document.getElementById('myChart3').getContext('2d');
    var chart3 = new Chart(chart3, {
    // The type of chart we want to create
    type: 'pie',

    // The data for our dataset
    data: {
        labels: [
            <?php

                    $query = $db->query("SELECT (prod.Prod_nombre) as 'Nombre Producto', SUM(ProdVent_cantidad) 'Cantidad', SUM(precioVenta) as 'Dinero Recaudado' FROM `prod_venta1`, prod WHERE prod.Prod_id = prod_venta1.ProdVent_prod GROUP BY prod_venta1.ProdVent_prod;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Nombre Producto']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>
        ],
        datasets: [{
            label: 'Venta Por Forma de Pago',
            backgroundColor:['#f68d2b',
                             '#1E90FF',
                             '#8A2BE2',
                             '#FF0000'],
            borderColor: 'black',
            data: [
                <?php

                    $query = $db->query("SELECT (prod.Prod_nombre) as 'Nombre Producto', SUM(ProdVent_cantidad) 'Cantidad', SUM(precioVenta) as 'Dinero Recaudado' FROM `prod_venta1`, prod WHERE prod.Prod_id = prod_venta1.ProdVent_prod GROUP BY prod_venta1.ProdVent_prod;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Dinero Recaudado']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>
            ]
        }]
    },

    // Configuration options go here
    options: {
       maintainAspectRatio: false,
       plugins: {
            title: {
                display: true,
                text: 'Total de $ por Producto'
            }
        }
    }
});

var chart4 = document.getElementById('myChart4').getContext('2d');
    var chart4 = new Chart(chart4, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: [
            <?php

                    $query = $db->query("SELECT (cliente.Cli_nombre) as 'Nombre', COUNT(Vent_id_cliente) as 'cantidad' FROM venta1, cliente WHERE cliente.Cli_id = venta1.Vent_id_cliente GROUP BY cliente.Cli_nombre;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['Nombre']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>
        ],
        datasets: [{
            label: 'Clientes',
            backgroundColor:['#f68d2b',
                             '#1E90FF',
                             '#8A2BE2',
                             '#FF0000'],
            borderColor: 'black',
            data: [
                <?php

                    $query = $db->query("SELECT (cliente.Cli_nombre) as 'Nombre', COUNT(Vent_id_cliente) as 'cantidad' FROM venta1, cliente WHERE cliente.Cli_id = venta1.Vent_id_cliente GROUP BY cliente.Cli_nombre;");

                    $arrayQuery = $query->fetch_array();

                    while($arrayQuery != null)
                    {
                ?>
                    '<?php echo $arrayQuery['cantidad']  ?>',
                <?php
                    $arrayQuery = $query->fetch_array();
                    }

                ?>
            ]
        }]
    },

    // Configuration options go here
    options: {
       plugins: {
            title: {
                display: true,
                text: 'Cantidad de compras por Cliente'
            }
        }
    }
});
</script>
</html>
<?php
}
?>