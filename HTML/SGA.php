<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../Recursos/logo2.png" />
    <link rel="stylesheet" href="<?php //echo constant('URL'); 
                                    ?>public/css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <title>Data Life - SGA</title>
</head>

<body>
    <?php include "ConexionBD.php";
    $infosga = memoriaSGAUnica();
    $memoriaTotal = memoriaSGATotal();
    function leer_hwm()
    {
        // Abriendo el archivo
        $archivo = fopen("hwmp.txt", "r", true);

        // Recorremos todas las lineas del archivo
        while (!feof($archivo)) {
            // Leyendo una linea
            $traer = fgets($archivo);
        }
        fclose($archivo);
        return (float)$traer;
    } ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,.5);">
        <div class="container-fluid">
            <a class="navbar-brand" href="SGA.php">
                <img src="../Recursos/logo2.png" alt="" width="80" height="74" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="Space.php">Space</a>
                    <a class="nav-link" href="Transactions.php">Log</a>
                    <a class="nav-link" href="Respaldo.php">Backup</a>
                    <a class="nav-link" href="Login.php">Quit</a>
                    <!--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
                </div>
            </div>
        </div>
    </nav>

    <main class="container" id="SGA">

        <h5 id="archivo" style="padding: 2px"></h5>
        <h1 align="center" style="padding:20px">SGA Monitor</h1>
        <!--<canvas id="graficoSGA" width="400" height="100" width="50"></canvas>-->
        <div style="width:50vw; height: 10vw">
            <canvas id="miChart"></canvas>
        </div>
        <div style="margin-left: 780px; margin-top: -50px">
            <table id="tablaSGA" style="width: 200px" class="table table-striped">
                <thead style="width: 200px" class="table-dark">
                    <th scope="col" colspan="2">SIZES OF SGA</th>
                </thead>
                <tbody style="width: 100px">
                    <?php $tam = " MB" ?>
                    <tr>
                        <th width="80">Used
                        <td><?php echo (MemoriaSGACompleto()[0] . $tam); ?> </td>
                        </th>
                    </tr>
                    <tr>
                        <th width="80">Free
                        <td><?php echo (MemoriaSGACompleto()[1] . $tam); ?> </td>
                        </th>
                    </tr>
                    <tr>
                        <th width="80">Total
                        <td><?php echo (MemoriaSGACompleto()[2] . $tam); ?> </td>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-left: 1000px;  margin-top: -180px">
            <table id="tablaSGA" style="width: 200px" class="table table-striped">
                <thead style="width: 200px">
                    <th scope="col" colspan="2" class="table-dark">HWM</th>
                </thead>
                <tbody style="width: 100px">
                    <?php $tam = " MB";
                    $tam2 = " %" ?>
                    <tr>
                        <th width="80">Max
                        <td><?php
                            $max = (int)MemoriaSGACompleto()[0];
                            $max2 = $max * leer_hwm();
                            echo ($max2 . $tam); ?> </td>
                        </th>
                    </tr>
                    <tr>
                        <th width="80">Current
                        <td><?php
                            $current = (int)MemoriaSGACompleto()[1];
                            $used = (int)MemoriaSGACompleto()[0];
                            $final = $used - $current;
                            echo ($final . $tam); ?> </td>
                        </th>
                    </tr>
                    <tr>
                        <th width="80">SpillOver
                        <td><?php
                            $SpilOver =MemoriaSGACompleto()[2] - $final;
                            //$SpilOver = 0;
                            echo ($SpilOver . $tam); ?> </td>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>



        <div style="margin-right: 500px; margin-top: 200px; overflow:scroll; height:200px !important; width: 100%;">

            <?php

            // session_start();
            $host = $_SESSION["host"];


            if ($host == "defecto") {
                $conn = oci_connect('system', 'root', 'localhost');
            }
            if ($host == "Ip1") {
                $conn = oci_connect('JD', 'JD', '172.0.0.2');
            }


            if (!$conn) {

                $e = oci_error();

                print htmlentities($e['message']);
                echo "Conexión no exitosa";
                exit;
            } else {

                $stid = oci_parse($conn, 'select 
       sess.sid, sess.username, ss.sql_text,  sess.LOGON_TIME, ss.FIRST_LOAD_TIME
   from
       v$session sess,
       v$sql     ss
   where
       sess.sql_id   = ss.sql_id
       order by ss.FIRST_LOAD_TIME desc
       ');

                oci_execute($stid);

                print "<h4 align=\"center\">Critical Querys</h4> <table id=\"tablaTransactions\" style=\"width: 100%;\"  class=\"table table-striped\"  align=\"center\">";
                print "<tr><th class=\"table-dark\">SID</th><th class=\"table-dark\">Username</th><th class=\"table-dark\">SQL Text</th><th  class=\"table-dark\">Logon Time</th><th class=\"table-dark\">First Load Time</th></tr>";

                while ($fila = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    print "<tr>\n";
                    foreach ($fila as $elemento) {
                        print "    <td>" . ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "") . "</td>\n";
                    }
                    print "</tr>\n";
                }
                print "</table>\n";

                oci_free_statement($stid);
                oci_close($conn);
            }

            ?>

        </div>
    </main>
</body>
<script>
    function redir() {

        const redir = document.getElementById('Ips').value;

        window.location = redir + ".php"

    }

    imprimeArchive();

    function imprimeArchive() {
        var data = <?php archiveLog(); ?>;
        console.log(data[0].LOG_MODE);
        if (data[0].LOG_MODE === "NOARCHIVELOG") {
            document.getElementById("archivo").style.color = "red";
            document.getElementById("archivo").innerHTML = "Database is not in ARCHIVE mode";
        } else {
            document.getElementById("archivo").style.color = "green";
            document.getElementById("archivo").innerHTML = "Database is in ARCHIVE mode";
        }
    }

    /*cargaGrafico();

    function cargaGrafico() {
        $.ajax({
            url: 'ControlGraficoSGA.php',
            type: 'POST'
        }).done(function(resp) {
            var cantidad = [];

            var data = JSON.parse(resp)
            for (var i = 0; i < data.length; i++) {
                cantidad.push(data[i]);
                console.log(cantidad);
            }
            var result = cantidad.map(function(x) {
                return parseInt(x, 10);
            });
            console.log(result)
            const ctx = document.getElementById('graficoSGA');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Memory'],
                    datasets: [{
                        label: 'SGA Current Memory',
                        data: result,
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
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    }*/

    const config = {
        type: 'line',
        data: {
            datasets: [{
                    label: 'SGA Memory',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    //fill: true,
                    data: []
                },
                {
                    label: 'HWM',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgb(255, 99, 132)',
                    //cubicInterpolationMode: 'monotone',
                    //fill: true,
                    data: []
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'realtime',
                    realtime: {
                        delay: 1000,
                        refresh: 1000,
                        frameRate: 20,
                        onRefresh: chart => {
                            var dato = Math.floor(<?php echo $infosga; ?>);
                            var memoriaTotal = Math.floor(<?php echo $memoriaTotal; ?>);
                            var hwm = (memoriaTotal * 95) / 100;
                            chart.data.datasets[0].data.push({
                                x: Date.now(),
                                y: dato
                            });
                            chart.data.datasets[1].data.push({
                                x: Date.now(),
                                y: hwm
                            });
                            /*chart.data.datasets.forEach(dataset => {
                                var dato = Math.floor(<?php echo $infosga; ?>);
                                console.log(dato);
                              dataset.data.push({
                                x: Date.now(),
                                y: dato
                              });
                            });*/
                        }
                    }
                }
            },
            interaction: {
                intersect: false
            }
        }
    };


    // init block
    const myChart = new Chart(document.getElementById('miChart'), config);

    function addData() {
        var dato = Math.floor(<?php echo memoriaSGAUnica(); ?>);
        myChart.data.datasets[0].data.push(dato);
        console.log(myChart.data.datasets[0].data.push(dato));
        myChart.update();
    }
</script>

</html>