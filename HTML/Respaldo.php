<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../Recursos/logo2.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="Estilos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming@2.0.0"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



    <title>Data Life - Backup</title>
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
                    <a class="nav-link" href="SGA.php">SGA</a>
                    <a class="nav-link active" aria-current="page" href="Space.php">Space</a>
                    <a class="nav-link" href="Transactions.php">Log</a>
                    <a class="nav-link" href="Login.php">Quit</a>
                    <!--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
                </div>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        <div class="logo">
            <img src="../Recursos/backup.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            Data Life <br>
            Backup
        </div>
        <div class="p-3 mt-3">
            <div>
                <select onchange="cambio1()" name="elementos" id="elementos" class="drop">
                    <option value="nada" class="dropdown-item">Backup Type</option>
                    <option value="full" class="dropdown-item">Full</option>
                    <option value="logs" class="dropdown-item">Partial (Logs)</option>
                    <option value="control" class="dropdown-item">Partial (Control)</option>
                </select>
            </div>

        </div>
        <div>
            <select onchange="cambio3()" name="bd" id="bd" class="drop">
                <option value="nada" class="dropdown-item">Select DB</option>
                <option value="defecto" class="dropdown-item">Localhost</option>
                <option value="db1" class="dropdown-item">Data base 1</option>
            </select>
            <button onclick="respaldo()" class="btn mt-3 btn-dark">Save</button>
        </div>
    </div>
</body>

</html>

<script>
    function cambio1() {

        var element = document.getElementById("elementos").value;

        $.ajax({
            url: 'Backup.php',
            type: 'POST',
            data: {
                elem: element
            }
        }).done(function(resp) {
            if (resp == 5) {
                alert("Error");
            } else {
                var data = JSON.parse(resp);

            }

        });


    }

    /*
        function cambio2() {

            var tipo = document.getElementById("tipo").value;

            $.ajax({
                url: 'Backup.php',
                type: 'POST',
                data: {
                    tip: tipo
                }
            }).done(function(resp) {
                if (resp == 5) {
                    alert("Error");
                } else {
                    var data = JSON.parse(resp);

                }

            });


        }

    */
    function cambio3() {

        var bd = document.getElementById("bd").value;

        $.ajax({
            url: 'Backup.php',
            type: 'POST',
            data: {
                base: bd
            }
        }).done(function(resp) {
            if (resp == 5) {
                alert("Error");
            } else {
                var data = JSON.parse(resp);

            }

        });


    }

    function respaldo() {

        var elem = document.getElementById("elementos").value;
        //var tip = document.getElementById("tipo").value;
        var base = document.getElementById("bd").value;

        /*
        if(elem === "full"){alert(elem);
        }else if(elem === "logs"){alert(elem);
        }else if(elem === "control"){alert(elem);}    
        */

        if (elem === "nada") {
            alert("Select a type");
            return;
        } else if (base === "nada") {
            alert("Select a Data base to backup");
            return;
        } else {

            $.ajax({
                url: 'Script.php',
                type: 'POST',
                data: {
                    element: elem
                }
            }).done(function(resp) {
                if (resp === 5) {
                    alert("Error");
                } else {
                    var data = JSON.parse(resp);
                    if (elem === "full") {
                        alert("Full Backup Completed");
                    } else if (elem === "logs") {
                        alert("Logs Backup Completed");
                    } else if (elem === "control") {
                        alert("Control Backup Completed");
                    }

                }

            });



        }
    }
</script>