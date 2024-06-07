<?php
if (isset($title)) {
    $admin_username = "admin"; // Nombre de usuario con privilegios de administrador
    $logged_in_user = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null; // Obtener el nombre de usuario actual desde la sesión
?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">POLISTOCK - INVENTARIO</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php if (isset($active_productos)){echo $active_productos;}?>"><a href="stock.php"><i class='glyphicon glyphicon-barcode'></i> Inventario</a></li>
		<li class="<?php if (isset($active_categoria)){echo $active_categoria;}?>"><a href="categorias.php"><i class='glyphicon glyphicon-tags'></i> Categorías</a></li>
		<?php if ($logged_in_user === $admin_username) : ?>
		<li class="<?php if (isset($active_usuarios)){echo $active_usuarios;}?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-user'></i> Usuarios</a></li>
		<?php endif; ?>
    <li><a href="historial.php"><i class='glyphicon glyphicon-time'></i> Historial</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php
}
?>