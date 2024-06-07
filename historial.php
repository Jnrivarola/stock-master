<?php
session_start();



if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}


$title = "Historial | Simple Stock";


require_once "config/db.php"; 
require_once "config/conexion.php"; 


$fecha = "";
$nota = "";
$referencia = "";
$numero_serie = "";
$nombre_producto = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST["fecha"];
    $nota = $_POST["nota"];
    $referencia = $_POST["referencia"];
    $numero_serie = $_POST["numero_serie"];
    $nombre_producto = $_POST["nombre_producto"];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" href="img/logo-icon.png" sizes="32x32" type="image/png">
</head>
<body>

<?php 

include("navbar.php"); 
?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h4><i class='glyphicon glyphicon-search'></i> Historial de Movimientos</h4>
        </div>
        <div class="panel-body">
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-inline">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="text" class="form-control" name="fecha" value="<?php echo $fecha; ?>">
                </div>
                <div class="form-group">
                    <label for="nota">Nota:</label>
                    <input type="text" class="form-control" name="nota" value="<?php echo $nota; ?>">
                </div>
                <div class="form-group">
                    <label for="referencia">Referencia:</label>
                    <input type="text" class="form-control" name="referencia" value="<?php echo $referencia; ?>">
                </div>
                <div class="form-group">
                    <label for="numero_serie">Número de Serie:</label>
                    <input type="text" class="form-control" name="numero_serie" value="<?php echo $numero_serie; ?>">
                </div>
                <div class="form-group">
                    <label for="nombre_producto">Nombre Producto:</label>
                    <input type="text" class="form-control" name="nombre_producto" value="<?php echo $nombre_producto; ?>">
                </div>
                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
            </form>

            <?php
            
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

      
            $sql = "SELECT h.fecha, h.nota, h.referencia, h.cantidad, p.codigo_producto AS numero_serie, p.nombre_producto 
                    FROM historial h
                    INNER JOIN products p ON h.id_producto = p.id_producto
                    WHERE 1";

                    

            if (!empty($fecha)) {
                $sql .= " AND h.fecha LIKE '%$fecha%'";
            }
            if (!empty($nota)) {
                $sql .= " AND h.nota LIKE '%$nota%'";
            }
            if (!empty($referencia)) {
                $sql .= " AND h.referencia LIKE '%$referencia%'";
            }
            if (!empty($numero_serie)) {
                $sql .= " AND p.codigo_producto LIKE '%$numero_serie%'";
            }
            if (!empty($nombre_producto)) {
                $sql .= " AND p.nombre_producto LIKE '%$nombre_producto%'";
            }

            $sql .= " ORDER BY h.fecha DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<tr><th>Fecha</th><th>Nota</th><th>Referencia</th><th>Cantidad</th><th>Número de Serie</th><th>Nombre Producto</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>" . $row["nota"] . "</td>";
                    echo "<td>" . $row["referencia"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>" . $row["numero_serie"] . "</td>"; 
                    echo "<td>" . $row["nombre_producto"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron registros de historial.";
            }

            $conn->close();
            ?>

        </div>
    </div>
</div>

<?php include("footer.php"); ?>


</body>
</html>