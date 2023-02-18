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



    <title>Data Life - Log in</title>
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="../Recursos/logo2.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            Data Life
        </div>
        <div class="p-3 mt-3">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="userName" id="userName" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="pwd" placeholder="Password">
            </div>
            <button onclick="valida()" class="btn mt-3 btn-primary">Login</button>
        </div>
        <div>
            <select onchange="cambio()" name="Ips" id="Ips" class="drop">
            <option value="nada" class="dropdown-item">Select Server</option>
                <option value="defecto" class="dropdown-item">Server (Localhost)</option>
                <option value="Ip1" class="dropdown-item">172.0.0.2</option>
            </select>

        </div>
    </div>
</body>

</html>



<script>
    function valida() {
        var user = document.getElementById("userName").value;
        var password = document.getElementById("pwd").value;
        var host = document.getElementById("Ips").value;

        //sesion(host);
        if (user === null || user === "" || user != "admin") {
            alert("Usuario Incorrecto");
        } else if (password === null || password === "" || password != "root") {
            alert("Constraseña Incorrecta");
        } else if (host === "nada") {
            alert("Seleccione un Servidor");
        }else
            return window.location = "SGA.php";
    }

    function cambio() {

        var host = document.getElementById("Ips").value;

        $.ajax({
            url:'Session.php',
            type:'POST',
            data:{
                hos:host 
            }
        }).done(function(resp){
                if(resp==5){
                    alert("Error");
                }else{
                    var data = JSON.parse(resp);
                    
                }

        });
        

    }

    //function sesion(host){

        
            /*$dochtml = new DOMDocument();
            $dochtml->loadHTML('Login.php');
            */
           // session_start();
            //unset($_SESSION["host"]);
           // $aux = $dochtml->getElementById('Ips');
           // $_SESSION["host"] = host;//$aux->nodeValue;
        
        

   //}


</script>

<?php
$dochtml = new DOMDocument();

// load content from a HTML page (or file)
$dochtml->loadHTMLFile('Login.php');

$elm = $dochtml->getElementById('Ips');

// get the tag name, and content
$tag = $elm->tagName;
$cnt = $elm->textContent;


//session_start();
//$_SESSION["host"] = "defecto";
//echo $_SESSION["host"];
//echo $cnt;  

?>