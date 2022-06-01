<?php

$dsn = "MS Access Database";
$conexion = odbc_connect($dsn, '', '');
if ($conexion) {
    $query = "INSERT INTO test (dato) VALUES ('" . utf8_decode('acáéíóú') . "')";
    echo "Query: " . $query;
    $result = odbc_exec($conexion, $query);
    echo $result;
}
odbc_close($conexion);
