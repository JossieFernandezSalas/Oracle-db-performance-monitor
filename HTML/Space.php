<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../Recursos/logo2.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <title>Data Life - Space</title>
</head>

<body>
    <?php include "ConexionBD.php"; ?>

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
                    <a class="nav-link active" aria-current="page" href="SGA.php">SGA</a>
                    <a class="nav-link" href="Transactions.php">Log</a>
                    <a class="nav-link" href="Respaldo.php">Backup</a>
                    <a class="nav-link" href="Login.php">Quit</a>
                    <!--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
                </div>
            </div>
        </div>
    </nav>
    <main class="container" id="SPACE">

        </div>
        <h5 id="archivo" style="padding: 2px"></h5>
        <h1 align="center" style="padding:20px">Table Space</h1>
        <div>

            <h2 align="center" style="padding:20px">UNDOTBS1</h2>
            <div class="progress">

                <div id="myBar0" class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="1600">Used space</div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="1600">HWM</div>
                <!-- <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Free Space</div> -->
            </div>

            <h3 align="center" style="padding:20px">USERS</h3>
            <div class="progress">

                <div id="myBar1" class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="1600">Used space</div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="1600">HWM</div>
                <!-- <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Free Space</div> -->
            </div>

            <h4 align="center" style="padding:20px">SYSAUX</h4>
            <div class="progress">

                <div id="myBar2" class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="1600">Used space</div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="1600">HWM</div>
                <!-- <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Free Space</div> -->
            </div>

            <h5 align="center" style="padding:20px">SYSTEM</h5>
            <div class="progress">

                <div id="myBar3" class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="1600">Used space</div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="1600">HWM</div>
                <!-- <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Free Space</div> -->
            </div>

        </div>
        <div align="center" style="margin-right: 100px; margin-top: 100px">
            <h4>Consumo de Tablespaces</h4>
            <?php
            //session_start();
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

                $stid = oci_parse($conn, 'select tsname, round(tablespace_size*t2.block_size/1024/1024,3) "Tamaño Actual MB", round(tablespace_usedsize*t2.block_size/1024/1024,3) "Espacio Usado MB", round((tablespace_size-tablespace_usedsize)*t2.block_size/1024/1024,3) "Espacio Libre MB", round(val2*t2.block_size/1024/1024,3) "Consumo. Diario MB", round(val3*t2.block_size/1024/1024,3) "Consumo. Semanal MB", round(val4*t2.block_size/1024/1024,3) "Consumo. Mensual MB", round((tablespace_usedsize/tablespace_size)*100, 3) "% Usado", round((val2/tablespace_size)*100, 3) "% Consumo. Diario", round((val3/tablespace_size)*100, 3) "% Consumo. Semanal", round((val4/tablespace_size)*100, 2) "% Consumo. Mensual" from (select distinct tsname, rtime, tablespace_size, tablespace_usedsize, tablespace_usedsize-first_value(tablespace_usedsize) over (partition by tablespace_id order by rtime rows 1 preceding) val1, tablespace_usedsize-first_value(tablespace_usedsize) over (partition by tablespace_id order by rtime rows 2 preceding) val2, tablespace_usedsize-first_value(tablespace_usedsize) over (partition by tablespace_id order by rtime rows 168 preceding) val3, tablespace_usedsize-first_value(tablespace_usedsize) over (partition by tablespace_id order by rtime rows 720 preceding) val4 from (select t1.tablespace_size, t1.snap_id, t1.rtime,t1.tablespace_id, t1.tablespace_usedsize-nvl(t3.space,0) tablespace_usedsize from dba_hist_tbspc_space_usage t1, dba_hist_tablespace_stat t2, (select ts_name,sum(space) space from recyclebin group by ts_name) t3 where t1.tablespace_id = t2.ts# and  t1.snap_id = t2.snap_id and  t2.tsname = t3.ts_name (+)) t1, dba_hist_tablespace_stat t2 where t1.tablespace_id = t2.ts# and t1.snap_id = t2.snap_id) t1, dba_tablespaces t2 where t1.tsname = t2.tablespace_name and rtime = (select max(rtime) from dba_hist_tbspc_space_usage)order by "Consumo. Diario MB" desc,"Consumo. Semanal MB" desc,"Consumo. Mensual MB" desc');
                oci_execute($stid);

                print "<table id=\"tablaTransactions\" style=\"width: 800px\"  class=\"table table-striped\"  align=\"center\">";
                print "<tr>
<th class=\"table-dark\">Tabla</th>
<th class=\"table-dark\">Tamaño Actual</th>
<th class=\"table-dark\">Espacio Usado</th>
<th  class=\"table-dark\">Espacio Libre</th>
<th class=\"table-dark\">Consumo Diaria</th>
<th class=\"table-dark\">Consumo Semanal</th>
<th class=\"table-dark\">Consumo Mensual</th>
<th class=\"table-dark\">% Usado</th>
<th class=\"table-dark\">% Consumo Diaria</th>
<th class=\"table-dark\">% Consumo Semanal</th>
<th class=\"table-dark\">% Consumo Mensual</th>
</tr>";


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
            //}
            ?>

        </div>

    </main>
</body>
<script>
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

    function redir() {

        const redir = document.getElementById('Ips').value;

        window.location = redir + ".php"

    }

    move();

    function move() {

        $.ajax({
            url: 'ControlGraficosSpace.php',
            type: 'POST'
        }).done(
            function(resp) {
                var cantidad = [];


                var data = JSON.parse(resp)
                for (var i = 0; i < data.length; i++) {
                    cantidad.push(parseInt(data[i], 10));
                    console.log(cantidad);
                }


                for (var j = 0; j < cantidad.length; j++) {
                    var elem = document.getElementById("myBar" + j);
                    var width = 100 - cantidad[j];
                    console.log(cantidad[j]);
                    console.log(elem);
                    //var id = setInterval(frame, 10);
                    // console.log(id);
                    // function frame() {
                    if (width >= 1600) {
                        clearInterval(id);
                        i = 0;
                    } else {
                        //width++;
                        elem.style.width = width + "%";
                        //elem.innerHTML = width + "%";
                    }
                }

                //}
            });
    }
</script>

</html>