<?php
include('is_logged.php');

if (empty($_POST['codigo'])) {
    $errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
    $errors[] = "Nombre del producto vacío";
} else if (empty($_POST['stock'])) {
    $errors[] = "Stock del producto vacío";
} else {
    require_once("../config/db.php");
    require_once("../config/conexion.php");
    include("../funciones.php");

    $codigo = mysqli_real_escape_string($con, $_POST["codigo"]);
    $nombre = mysqli_real_escape_string($con, $_POST["nombre"]);
    $stock = intval($_POST['stock']);
    $id_categoria = intval($_POST['categoria']);
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $date_added = date("Y-m-d H:i:s");

    $sql = "INSERT INTO products (codigo_producto, nombre_producto, date_added, stock, id_categoria) VALUES ('$codigo','$nombre','$date_added', '$stock','$id_categoria')";
    $query_new_insert = mysqli_query($con, $sql);
    
    if ($query_new_insert) {
        $id_producto = get_row('products', 'id_producto', 'codigo_producto', $codigo);
        $user_id = $_SESSION['user_id'];
        $firstname = $_SESSION['firstname'];
        $nota = "$firstname agregó $stock producto(s) al inventario";
        
       
        guardar_historial($id_producto, $user_id, $date_added, $nota, $codigo, $stock);

        
        $messages[] = "Producto ha sido ingresado satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
    }
}


if (isset($errors)) {
    foreach ($errors as $error) {
        echo '<div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> ' . $error . '
            </div>';
    }
}
if (isset($messages)) {
    foreach ($messages as $message) {
        echo '<div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Bien hecho!</strong> ' . $message . '
            </div>';
    }
}
?>