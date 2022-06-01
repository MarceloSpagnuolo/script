<?php

include "./bases.php";

/* Datos de conexión de localhosta
habrá que verificar con el cliente
los datos de conexión de su base de
datos */
$hostname = "127.0.0.1:3306";
$username = "root";
$password = "";
$mysql_dbname = "farmanuario";

/* conexión a mysql */
$conn_mysql = mysqli_connect($hostname, $username, $password, $mysql_dbname);
if (!$conn_mysql) {
    die("Connection failed: " . mysqli_connect_error());
}

/* Datos de conexion de mi pc, esto habrá que
verificar con el controlador odbc del cliente *
/
/* conexion a access a través de obdc */
$dsn = "MS Access Database";
$conn_access = odbc_connect($dsn, '', '');

if (!$conn_access) {
    die("Error: No se pudo completar la conexion.\n");
} else {
    echo "Conexión a [" . $dsn . "]: Establecida.\n";

    // TABLA t_arbol

    // traemos todo la tabla t_arbol de mysql
    $query = "SELECT * FROM t_arbol";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {

        // si la tabla mysql t_arbol trae resultado, vaciamos la tabla access t_arbol
        $query = "DELETE * FROM t_arbol";
        $result_access = odbc_exec($conn_access, $query);
        if ($result_access) {
            $index = 0;
            while ($row = mysqli_fetch_array($result_mysql)) {
                //convertimos todos a utf8
                foreach ($row as &$value) {
                    $value = utf8_decode($value);
                    $value = str_replace("'", '"', $value);
                };
                unset($value);
                $queryODBC = "INSERT INTO  t_arbol (" . $t_arbol . ") VALUES ("
                    . (empty($row["ID_PADRE"]) ? 0 : $row["ID_PADRE"]) . ","
                    . (empty($row["ID_HIJO"]) ? 0 : $row["ID_HIJO"]) . ",'"
                    . $row["NOMBRE_RAMA"] . "',"
                    . (empty($row["ORDEN_RAMA"]) ? 0 : $row["ORDEN_RAMA"]) . ","
                    . (empty($row["NIVEL_RAMA"]) ? 0 : $row["NIVEL_RAMA"]) . ",'"
                    . $row["FARMACO"] . "',"
                    . (empty($row["LINK_RAMA"]) ? 0 : $row["LINK_RAMA"]) . ",'"
                    . $row["TIPO_LINK"] . "','"
                    . $row["NOTA_RAMA"] . "','"
                    . $row["ORDEN_LISTADO"] . "','"
                    . $row["DESCRIPCION_FARMACO"] . "','"
                    . $row["USOS_FARMACO"] . "','"
                    . $row["CONTRAINDICACIONES_FARMACO"] . "','"
                    . $row["PRECAUCIONES_FARMACO"] . "','"
                    . $row["REACCIONES_ADVERSAS_FARMACO"] . "','"
                    . $row["INTERACCIONES_FARMACO"] . "','"
                    . $row["DOSIS_FARMACO"] . "','"
                    . $row["DEFINICION_FARMACO"] . "',"
                    . (empty($row["Id_Raiz"]) ? 0 : $row["Id_Raiz"]) . ",'"
                    . $row["MONODROGA"] . "','"
                    . $row["PRINCIPIO_ACTIVO"] . "','"
                    . $row["ACCION_TERAPEUTICA"] . "','"
                    . $row["EMBARAZO_FARMACO"] . "','"
                    . $row["LACTANCIA_FARMACO"] . "','"
                    . $row["CATEGORIA_FARMACO"] . "','"
                    . $row["COD_ATC"] . "','"
                    . $row["FECHA_LANZAMIENTO"] . "','"
                    . $row["COD_FTM"] . "')";
                $index++;
                $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
                if (!$result_access) {
                    exit("Error en INSERT t_arbol en Access");
                }
            }
        }
        echo "Tabla t_arbol: " . $index . " archivos importados.\n";
    } else {
        echo ("La consulta a la tabla t_arbol no arrojó resultado");
    };

    // TABLA t_ciudad

    // traemos solo Paraguay de la tabla t_ciudad
    $query = "SELECT * FROM t_ciudad WHERE ID_PAIS=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_ciudad de access si mysql t_ciudad trae data
        $query_access = "DELETE * FROM t_ciudad";
        $result_access = odbc_exec($conn_access, $query_access);
        if ($result_access) {
            $index = 1;
            while ($row = mysqli_fetch_array($result_mysql)) {
                //convertimos todos a utf8
                foreach ($row as &$value) {
                    $value = utf8_decode($value);
                };
                unset($value);
                $queryODBC = "INSERT INTO t_ciudad (" . $t_ciudad . ") VALUES (" . $row["ID_PAIS"] . "," . $row["ID_REGION"] . "," . $row["ID_CIUDAD"] . ",'" . $row["NOMBRE_CIUDAD"] . "')";
                $index++;
                $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
                if (!$result_access) {
                    exit("Error en INSERT t_ciudad en Access");
                }
            }
        }
        echo "Tabla t_ciudad: " . $index . " archivos importados.\n";
    } else {
        echo ("La consulta a la tabla t_ciudad no arrojó resultado");
    }

    // TABLA t_empresa

    // traemos solo Paraguay de la tabla t_empresa
    $query = "SELECT * FROM t_empresa WHERE ID_Pais=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_empresa de access si mysql t_empres trae data
        $query_access = "DELETE * FROM t_empresa";
        $result_access = odbc_exec($conn_access, $query_access);
        if ($result_access) {
            $index = 0;
            while ($row = mysqli_fetch_array($result_mysql)) {
                //convertimos todos a utf8
                foreach ($row as &$value) {
                    $value = utf8_decode($value);
                };
                unset($value);
                $queryODBC = "INSERT INTO t_empresa (" . $t_empresa . ") VALUES (" . $row["ID_EMPRESA"] . "," . $row["ID_Pais"] . "," . $row["ID_Region"] . "," . $row["ID_Ciudad"] . ",'" . $row["RAZONSOCIAL_EMPRESA"] . "','" . $row["RUC_EMPRESA"] . "','" . $row["DIRECCION_EMPRESA"] . "','" . $row["TELEFONO1_EMPRESA"] . "','" . $row["TELEFONO2_EMPRESA"] . "','" . $row["FAX1_EMPRESA"] . "','" . $row["COMENTARIO_EMPRESA"] . "','" . $row["CORREOELECTRONICO_EMPRESA"] . "','" . $row["FECHAULTIMAREUNION_EMPRESA"] . "','" . $row["REFERIDOPOR_EMPRES"] . "','" . $row["CODIGOPOSTAL_EMPRE"] . "','" . $row["NOTAS_EMPRESA"] . "','" . $row["WEB_EMPRESA1"] . "')";
                $index++;
                $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
                if (!$result_access) {
                    exit("Error en Insert t_empresa en Access");
                }
            }
        }
        echo "Tabla t_empresa: " . $index . " archivos importados.\n";
    } else {
        echo ("La consulta a la tabla t_empresa no arrojó resultado");
    }

    //TABLA t_farmaco_producto

    //traemos todos de la tabla mysql t_farmaco_producto
    $query = "SELECT * FROM t_farmaco_producto INNER JOIN t_producto USING (ID_PRODUCTO) INNER JOIN t_linea USING (ID_LINEA) WHERE ID_PAIS=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_farmaco_producto de access si mysql t_farmaco_producto trae data
        $query_access = "DELETE * FROM t_farmaco_producto";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
            };
            unset($value);
            $queryODBC = "INSERT INTO t_farmaco_producto (" . $t_farmaco_producto . ") VALUES (" . $row["ID_HIJO"] . "," . $row["ID_PRODUCTO"] . "," . $row["ID_VIACON"] . ")";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert t_farmaco_producto en Access");
            }
        }
        echo "Tabla t_farmaco: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta ala tabla t_farmaco_producto no arrojó resultado");
    }

    // TABLA t_laboratorio

    //traemos todos de la tabla mysql t_laboratorio
    $query = "SELECT * FROM t_laboratorio";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_laboratorio de access si mysql t_laboratorio trae data
        $query_access = "DELETE * FROM t_laboratorio";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
            };
            unset($value);
            $queryODBC = "INSERT INTO t_laboratorio (" . $t_laboratorio . ") VALUES (" . $row["ID_LABORATORIO"] . "," . $row["ID_EMPRESA"] . ",'" . $row["NOMBRE_LABORATORIO"] . "')";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert t_laboratorios en Access");
            }
        }
        echo "Tabla t_laboratorio: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta a la tabla t_laboratorio no arrojó resultado");
    }

    // TABLA t_linea

    //traemos todos de la tabla mysql t_laboratorio pertenecientes a Paraguay
    $query = "SELECT * FROM t_linea WHERE ID_PAIS=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_linea de access si mysql t_linea trae data
        $query_access = "DELETE * FROM t_linea";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
            };
            unset($value);
            $queryODBC = "INSERT INTO t_linea (" . $t_linea . ") VALUES (" . $row["ID_LINEA"] . "," . $row["ID_LABORATORIO"] . "," . $row["ID_TIPO_LINEA"] . "," . $row["ID_PAIS"] . "," . $row["ID_REGION"] . "," . $row["ID_CIUDAD"] . ",'" . $row["NOMBRE_COMERCIAL_LINEA"] . "')";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert t_linea en Access");
            }
        }
        echo "Tabla t_linea: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta a la tabla t_linea no arrojó resultado");
    }

    // TABLA t_posologia

    //traemos todos de la tabla mysql t_posologia pertenecientes a Paraguay
    $query = "SELECT * FROM t_posologia WHERE ID_PAIS=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_posologia de access si mysql t_posologia trae data
        $query_access = "DELETE * FROM t_posologia";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
            };
            unset($value);
            $queryODBC = "INSERT INTO t_posologia (" . $t_posologia . ") VALUES (" . $row["ID"] . "," . $row["ID_HIJO"] . "," . $row["ID_PAIS"] . ",'" . $row["POSOLOGIA"] . "','" . $row["ORIGINAL"] . "','" . htmlspecialchars($row["FORMATO_POSOLOGIA"]) . "')";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert t_posologia en Access");
            }
        }
        echo "Tabla t_posologia: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta a la tabla t_posologia no arrojó resultado");
    }

    // TABLA t_producto

    //traemos todos de la tabla mysql t_producto de Paraguay
    $query = "SELECT * FROM t_producto INNER JOIN t_linea USING (ID_LINEA) WHERE ID_PAIS=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_pproducto de access si mysql t_producto trae data
        $query_access = "DELETE * FROM t_producto";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
                $value = str_replace("'", '"', $value);
            };
            unset($value);
            $queryODBC = "INSERT INTO t_producto (" . $t_producto . ") VALUES ("
                . $row["ID_PRODUCTO"] . ","
                . $row["ID_LINEA"] . ",'"
                . $row["NOMBRE_PRODUCTO"] . "','"
                . $row["COMPOSICION_PRODUCTO"] . "','"
                . $row["FECHA_PRECIO_PRODUCTO"] . "',"
                . (empty($row["PRECIO_PRODUCTO"]) ? 0 : $row["PRECIO_PRODUCTO"])  . ",'"
                . $row["PRESENTACION_PRODUCTO"] . "',"
                . (empty($row["ACTUALIZABLE_PRODUCTO"]) ? 0 : $row["ACTUALIZABLE_PRODUCTO"]) . ",'"
                . $row["Activo_Producto"] . "','"
                . $row["Fecha_Ingreso"] . "','"
                . $row["PSICOFARMACO"] . "',"
                . (empty($row["NUMERO_PAGINA"]) ? 0 : $row["NUMERO_PAGINA"]) . ","
                . (empty($row["PRECIODGRO_PRODUCTO"]) ? 0 : $row["PRECIODROG_PRODUCTO"]) . ",'"
                . $row["IMPUESTO"] . "','"
                . $row["CB"] . "','"
                . $row["CAMPO_M"] . "','"
                . $row["TIPORECETA_PRODUCTO"] . "',"
                . (empty($row["ID_PRESENTACION_CONCENTRACION"]) ? 0 : $row["ID_PRESENTACION_CONCENTRACION"]) . ","
                . (empty($row["ID_PRESENTACION_PRESENTACION"]) ? 0 : $row["ID_PRESENTACION_PRESENTACION"]) . ","
                . (empty($row["ID_PRESENTACION_UNIDAD"]) ? 0 : $row["ID_PRESENTACION_UNIDAD"]) . ",'"
                . $row["Cod_Barras"] . "','"
                . $row["Extra1"] . "','"
                . $row["Extra2"] . "','"
                . $row["Extra3"] . "','"
                . $row["Farmadescuento"] . "','"
                . $row["PRESENTACION_AGRUPADA"] . "','"
                . $row["FECHA_ALTA"] . "',"
                . (empty($row["PRECIO_VENTA_PUBLICO"]) ? 0 : $row["PRECIO_VENTA_PUBLICO"]) . ",'"
                . $row["AMPP_ID_DNMA"] . "','"
                . $row["AMPP_ID_SNOMED"] . "','"
                . $row["AMPP_ID_INTERNO"] . "','"
                . $row["AMP_ID_DNMA"] . "','"
                . $row["AMP_ID_SNOMED"] . "','"
                . $row["AMP_ID_INTERNO"] . "',"
                . (empty($row["DNMA_ID"]) ? 0 : $row["DNMA_ID"]) . ","
                . (empty($row["SNOMED_ID"]) ? 0 : $row["SNOMED_ID"]) . ")";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert t_producto en Access");
            }
        }
        echo "Tabla t_producto: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta a la tabla t_producto no arrojó resultado");
    }

    // TABLA t_region

    //traemos todos de la tabla mysql t_region de Paraguay
    $query = "SELECT * FROM t_region WHERE ID_PAIS=4";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos t_region de access si mysql t_region trae data
        $query_access = "DELETE * FROM t_region";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
            };
            unset($value);
            $queryODBC = "INSERT INTO t_region (" . $t_region . ") VALUES ("
                . (empty($row["ID_PAIS"]) ? 0 : $row["ID_PAIS"]) . ","
                . (empty($row["ID_REGION"]) ? 0 : $row["ID_REGION"]) . ",'"
                . $row["NOMBRE_REGION"] . "')";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert t_region en Access");
            }
        }
        echo "Tabla t_region: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta a la tabla t_region no arrojó resultado");
    }

    // TABLA via_concentracion

    //traemos todos de la tabla mysql t_via_concentracion de Paraguay
    $query = "SELECT * FROM via_concentracion";
    $result_mysql = mysqli_query($conn_mysql, $query);
    if ($result_mysql) {
        //vaciamos via_concentracion de access si mysql via_concentracion trae data
        $query_access = "DELETE * FROM via_concentracion";
        $result_access = odbc_exec($conn_access, $query_access);
        $index = 0;
        while ($row = mysqli_fetch_array(($result_mysql))) {
            //convertimos todos a utf8
            foreach ($row as &$value) {
                $value = utf8_decode($value);
            };
            unset($value);
            $queryODBC = "INSERT INTO via_concentracion (" . $via_concentracion . ") VALUES ("
                . (empty($row["ID_VIACON"]) ? 0 : $row["ID_VIACON"]) . ",'"
                . $row["descripcion_viacon"] . "')";
            $index++;
            $result_access = odbc_exec($conn_access, $queryODBC) or die(odbc_errormsg());
            if (!$result_access) {
                exit("Error en Insert via_concentracion en Access");
            }
        }
        echo "Tabla via_concentracion: " . $index . " archivos importados.\n";
    } else {
        echo ("la consulta a la tabla via_concentracion no arrojó resultado");
    }

    closeConecctions($conn_mysql, $conn_access);
};

function closeConecctions($conn_mysql, $conn_access)
{
    mysqli_close(($conn_mysql));
    odbc_close(($conn_access));
}
