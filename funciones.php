<?php 
function get_row($table,$row, $id, $equal){
	global $con;
	$query=mysqli_query($con,"select $row from $table where $id='$equal'");
	$rw=mysqli_fetch_array($query);
	$value=$rw[$row];
	return $value;
}

function guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity){
    global $con;
    
    
    $sql_nombre_producto = "SELECT nombre_producto FROM products WHERE id_producto = '$id_producto'";
    $query_nombre_producto = mysqli_query($con, $sql_nombre_producto);
    
    if ($row = mysqli_fetch_assoc($query_nombre_producto)) {
        $nombre_producto = $row['nombre_producto'];
        
        
        $sql_insert_historial = "INSERT INTO historial (id_historial, id_producto, nombre_producto, user_id, fecha, nota, referencia, cantidad)
                                VALUES (NULL, '$id_producto', '$nombre_producto', '$user_id', '$fecha', '$nota', '$reference', '$quantity')";
        
        $query_insert_historial = mysqli_query($con, $sql_insert_historial);
        
        if ($query_insert_historial) {
            return true; 
        } else {
            return false; 
        }
    } else {
        return false;
    }
}

function agregar_stock($id_producto,$quantity){
	global $con;
	$update=mysqli_query($con,"update products set stock=stock+'$quantity' where id_producto='$id_producto'");
	if ($update){
			return 1;
	} else {
		return 0;
	}	
		
}
function eliminar_stock($id_producto,$quantity){
	global $con;
	$update=mysqli_query($con,"update products set stock=stock-'$quantity' where id_producto='$id_producto'");
	if ($update){
			return 1;
	} else {
		return 0;
	}	
		
}
?>