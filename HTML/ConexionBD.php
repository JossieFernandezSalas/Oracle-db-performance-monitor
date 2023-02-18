<?php

session_start();
set_time_limit(500);
function memoriaSGA()
{

    //session_start();
    $host = $_SESSION["host"];


    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }

    $arreglo = array();
    if (!$conn) {

        $e = oci_error();

        print htmlentities($e['message']);

        exit;
    } else {

        $sql = "select round(used.bytes /1024/1024 ,2) used_mb, round(free.bytes /1024/1024 ,2) free_mb, round(tot.bytes /1024/1024 ,2) total_mb from (select sum(bytes) bytes from " . "v$" . "sgastat where name != 'free memory') used, (select sum(bytes) bytes from " . "v$" . "sgastat where name = 'free memory') free, (select sum(bytes) bytes from " . " v$" . "sgastat) tot ";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $arreglo[] = $row['USED_MB'];
        }
    }
    return $arreglo;
}

function memoriaSGAUnica()
{
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

        exit;
    } else {

        $sql = "select round(used.bytes /1024/1024 ,2) used_mb, round(free.bytes /1024/1024 ,2) free_mb, round(tot.bytes /1024/1024 ,2) total_mb from (select sum(bytes) bytes from " . "v$" . "sgastat where name != 'free memory') used, (select sum(bytes) bytes from " . "v$" . "sgastat where name = 'free memory') free, (select sum(bytes) bytes from " . " v$" . "sgastat) tot ";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $usado = $row['USED_MB'];
        }
    }
    return $usado;
}

function memoriaSGATotal()
{
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

        exit;
    } else {

        $sql = "select round(used.bytes /1024/1024 ,2) used_mb, round(free.bytes /1024/1024 ,2) free_mb, round(tot.bytes /1024/1024 ,2) total_mb from (select sum(bytes) bytes from " . "v$" . "sgastat where name != 'free memory') used, (select sum(bytes) bytes from " . "v$" . "sgastat where name = 'free memory') free, (select sum(bytes) bytes from " . " v$" . "sgastat) tot ";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $total = $row['TOTAL_MB'];
        }
    }
    return $total;
}

function logActivos()
{
    //session_start();
    $host = $_SESSION["host"];

    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }

    $arregloLog = array();
    if (!$conn) {

        $e = oci_error();

        print htmlentities($e['message']);

        exit;
    } else {

        $sqlLog = "select * from " . "v$" . "logfile";
        $stid = oci_parse($conn, $sqlLog);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $arregloLog[] = $row['TYPE'];
        }
    }
    return $arregloLog;
}

function logStatus()
{
    //session_start();
    $host = $_SESSION["host"];

    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }

    $arregoStatus = array();
    if (!$conn) {

        $e = oci_error();

        print htmlentities($e['message']);

        exit;
    } else {

        $sqlStatus = "select * from " . "v$" . "log";
        $stid = oci_parse($conn, $sqlStatus);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $arregoStatus[] = $row;
        }
    }
    return $arregoStatus;
}

function archiveLog()
{
    //session_start();
    $host = $_SESSION["host"];

    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }

    $arregoStatus = array();
    if (!$conn) {

        $e = oci_error();

        print htmlentities($e['message']);

        exit;
    } else {

        $sqlStatus = "select log_mode from " . "v$" . "database";
        $stid = oci_parse($conn, $sqlStatus);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $arregoStatus[] = $row;
        }
    }
    echo json_encode($arregoStatus);
}

function datosTS()
{
    //session_start();
    $host = $_SESSION["host"];

    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }

    $arreglo = array();
    if (!$conn) {

        $e = oci_error();

        print htmlentities($e['message']);

        exit;
    } else {

        $sql = "select a.tablespace_name, b.size_kb/1024 SIZE_MB, a.free_kb/1024 FREE_MB, Trunc((a.free_kb/b.size_kb) * 100) " . "FREE_porc" . " FROM (select tablespace_name, Trunc(Sum(bytes)/1024) free_kb FROM dba_free_space GROUP BY tablespace_name) a, (select tablespace_name, Trunc(Sum(bytes)/1024) size_kb FROM dba_data_files GROUP BY tablespace_name) b WHERE a.tablespace_name = b.tablespace_name ORDER BY 4 desc";

        $stid = oci_parse($conn, $sql);

        oci_execute($stid);

        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $arreglo[] = $row['FREE_PORC'];
            //echo $row['SIZE_MB'] . "<br>";
        }
    }
    return $arreglo;
}
function MemoriaSGACompleto()
{
    //session_start();
    $host = $_SESSION["host"];

    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }

    $arreglo = array();
    if (!$conn) {

        $e = oci_error();
        print htmlentities($e['message']);

        exit;
    } else {
        $sql = "select round(used.bytes /1024/1024 ,2) USED_MB,
         round(free.bytes /1024/1024 ,2) FREE_MB,
          round(tot.bytes /1024/1024 ,2) TOTAL_MB
           from 
           (select sum(bytes) bytes from " . "v$" . "sgastat where name != 'free memory') used,
            (select sum(bytes) bytes from " . "v$" . "sgastat where name = 'free memory') free,
             (select sum(bytes) bytes from " . "v$" . "sgastat) tot ";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $arreglo[] = $row['USED_MB'];
            $arreglo[] = $row['FREE_MB'];
            $arreglo[] = $row['TOTAL_MB'];
        }
        return $arreglo;
    }
}

function infoLogs()
{
    //session_start();
    $host = $_SESSION["host"];

    if ($host == "defecto") {
        $conn = oci_connect('system', 'root', 'localhost');
    }
    if ($host == "Ip1") {
        $conn = oci_connect('JD', 'JD', '172.0.0.2');
    }
    $arregoStatus = array();
    $sqlLog = array();
    $sqlLogQuery = "";
    $numero = 2;
    if (!$conn) {

        $e = oci_error();

        print htmlentities($e['message']);

        exit;
    } else {

        $sqlLogQuery = "select * from " . "v$" . "log";
        $stid = oci_parse($conn, $sqlLogQuery);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $sqlLog[] = $row['STATUS'];
        }

        $sqlStatus = "select * from " . "v$" . "logfile";
        $stid = oci_parse($conn, $sqlStatus);
        oci_execute($stid);
        while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $arregoStatus[] = $row;
            echo "<tr> <td> Log " . $row['GROUP#'] . " </td>";
            echo "<td> " . $sqlLog[$numero] . " </td>";
            echo "<td> " . $row['TYPE'] . " </td>";
            echo "<td> " . $row['MEMBER'] . " </td></tr>";
            $numero--;
        }
    }
    return $arregoStatus;
}

function backup($value)
{
    
   // $value = $_SESSION["elem"];
    if ($value === "full") {
        exec("RmanFull.bat", $output1, $return1);
        return $return1;
    } else if ($value === "logs") {
        exec("RmanLog.bat", $output2, $return2);
        return $return2;
    } else if ($value === "control") {
        exec("RmanControl.bat", $output3, $return3);
        return $return3;
    } else
        return 5;
/*
    if ($value === 1) {
        exec("RmanFull.bat", $output1, $return1);
        return $return1;
    } else if ($value === 2) {
        exec("RmanLog.bat", $output2, $return2);
        return $return2;
    } else if ($value === 3) {
        exec("RmanControl.bat", $output3, $return3);
        return $return3;
    } else
        return 5;*/
}
/*
function fullBackup()
{
    exec("RmanFull.bat", $output1, $return1);
    return $return1;
}

function logBackup()
{
    exec("RmanLog.bat", $output2, $return2);
    return $return2;
}

function controlBackup()
{
    exec("RmanControl.bat", $output3, $return3);
    return $return3;
}*/
//memoriaSGA();
//datosTS();
