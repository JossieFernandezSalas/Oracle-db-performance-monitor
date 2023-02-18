<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="../Recursos/logo2.png" />
  <link rel="stylesheet" href="<?php //echo constant('URL'); 
                                ?>public/css/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

  <title>Data Life - TRANSACTIONS</title>
</head>

<body>
  <?php include "ConexionBD.php";
  ?>
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
          <a class="nav-link" href="Space.php">Space</a>
          <a class="nav-link" href="Respaldo.php">Backup</a>
          <a class="nav-link" href="Login.php">Quit</a>
          <!--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
        </div>
      </div>
    </div>
  </nav>
  <main class="container" id="TRANSACTIONS">

    <h5 id="archivo" style="padding: 2px"></h5>
    <h1 align="center" style="padding:20px" style="margin:5px">Log Files</h1>
    <div style="width:50vw; height: 10vw; margin-left: 180px">
      <canvas id="logChart"></canvas>
    </div>

    <div align="center" style="padding: 10px; margin-top: 250px">
      <h4>General Information</h4>
      <table class="table table-striped" id="tabla" style=" width: 50px">
        <thead class="table-dark">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Status</th>
            <th scope="col">Type</th>
            <th scope="col">Location</th>
          </tr>
        </thead>
        <tbody>
          <?php infoLogs(); ?>
        </tbody>
      </table>
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

  function cargaGrafico() {
    $.ajax({
      url: 'ControlLogStatus.php',
      type: 'POST'
    }).done(function(resp) {
      var cantidadBytes = [];
      var status = [];
      var backColors = ['rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 0.2)']
      var borderColors = ['rgba(54, 162, 235, 1)', 'rgba(54, 162, 235, 1)']
      var numero = 0;
      var conversion = 0;
      var currentBackColor = 'rgba(255, 99, 132, 0.2)';
      var currentBorderColor = 'rgba(255, 99, 132, 1)';

      var data = JSON.parse(resp)
      for (var i = 0; i < data.length; i++) {
        numero = parseInt(data[i].BYTES);
        conversion = ((numero / 1024) / 1024);
        cantidadBytes.push(conversion);
        if (data[i].STATUS === "CURRENT") {
          backColors.splice(i, 0, currentBackColor);
          borderColors.splice(i, 0, currentBorderColor);
        }
        status.push(data[i].STATUS);
      }
      const ctx = document.getElementById('logChart');
      const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: status,
          datasets: [{
            label: 'Size',
            data: cantidadBytes,
            backgroundColor: backColors,
            borderColor: borderColors,
            borderWidth: 3
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
  }

  cargaGrafico();
</script>
<br>
<div align="center" style="margin-right: 0px; margin-top: 50px">
  <h4>Switch Information</h4>
  <?php

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

    $stid = oci_parse($conn, 'select TRUNC (first_time) "Fecha", TO_CHAR (first_time, \'Dy\') "Dia", COUNT (1) "Total", ROUND (COUNT (1) / 24, 3)*10 "Promedio" FROM gv$log_history WHERE thread# = inst_id AND first_time > sysdate -7 GROUP BY TRUNC (first_time), inst_id, TO_CHAR (first_time, \'Dy\') ORDER BY 1,2');
    oci_execute($stid);

    print "<table id=\"tablaTransactions\" style=\"width: 800px\"  class=\"table table-striped\"  align=\"center\">";
    print "<tr>
<th class=\"table-dark\">Fecha</th>
<th class=\"table-dark\">Dia</th>
<th class=\"table-dark\">Total cambios</th>
<th  class=\"table-dark\">Promedio cambios</th>
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

</html>