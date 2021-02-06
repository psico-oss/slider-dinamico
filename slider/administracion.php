<!DOCTYPE html>
<html>
<head>
	<title>Administración</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
<div class="contenedor">
<div class="centrado">

<?php /*lo que hago arriba es simplemente darle un poco de estilos a la bd y lo que hago abajo es la conexion para que se conecte a la bd*/
require_once("conexion.php");
include("redimensionarImg.php");
 ?>
<form action="#" method="post" enctype="multipart/form-data">
	<h1>Ingrese sus Imagenes:</h1>
	<input type="file" name="imagen">
	<p>Agregar imagen al slider?</p>
	<select name="slider">		
	<option value="1">Si</option>
	<option value="2">No</option>
	</select>
	<input type="submit" name="insertar" value="insertar">
</form>
<?php /*lo que hago arriba es un formulario para que el usuario le aparezca que archivo subir a la bd y si quiere poner esa img en el slider*/
if(isset($_POST['insertar'])){
	$slider=$_POST['slider'];
	
	if(is_uploaded_file($_FILES['imagen']['tmp_name']))
	{
		$archivo=$_FILES['imagen']['name'];
		$archivo=time()."-".$archivo;
		move_uploaded_file($_FILES['imagen']['tmp_name'],$archivo);
		$nbr_img = redimensionarImg($archivo,3440,1440);
		unlink($archivo);
		
	}/*lo que hago aca es si el usuario poner el boton insertar se guarda ese contenido,en las variables que le di y la imagen la guardo en una carpeta con el tamaño que le di en redimensionar img*/
$sql="INSERT INTO imagenes(imagen,slider) VALUE ('$nbr_img','$slider')";
$insertar=mysqli_query($conexion,$sql)? print("Registro agregado"): print("Error al agregar registro");
/*lo que hago aca es decirle al usuario si se puedo agregar correctamente el registro y guardando los datos en la bd*/
}
?>
<?php
if (isset($_GET['id_editar'])) {
  	$id=$_GET['id_editar'];
  	$sql="SELECT * FROM imagenes WHERE id_img='$id'";
	$ejecutar=mysqli_query($conexion, $sql);
	$registro=mysqli_fetch_assoc($ejecutar);
	echo '
	<h2>Actualizar Imagenes</h2>
	<form action="#" method="post" enctype="multipart/form-data">
	<input type="hidden" name="foto_previa" value="'.$registro['imagen'].'">
	<input type="file" name="foto">
	<select name="slider" >
	<option value="1" selected>Si</option>
	
	<option value="2">No</option>

	</select>
	
	<input type="submit" name="actualizar" value="actualizar">
	</form>
	';  
  }  
  if (isset($_POST['actualizar'])) {
  	$actualizar_slider=$_POST['slider'];
  	$foto_previa=$_POST['foto_previa'];


	if(is_uploaded_file($_FILES['foto']['tmp_name']))
{  
	$archivo = $_FILES['foto']['name'];
	move_uploaded_file($_FILES['foto']['tmp_name'], $archivo);	
	
	$nbr_img = redimensionarImg($archivo,3440,1440);
	
	unlink($archivo);

	$img_borrar="imagenes/".$foto_previa;

	unlink("$img_borrar");


}else{
	$nbr_img=$foto_previa;
}
  	$sql="UPDATE imagenes SET imagen='$nbr_img', slider='$actualizar_slider' WHERE id_img='$id'";
  	$ejecutar_update=mysqli_query($conexion, $sql) ? print ("ok") : print ("error");
  }
/*lo que hago aca arriba es preguntar si el usuario puso el boton actualizar si lo puso actualizo los datos que guardo en esa posicion*/
 ?>
 <?php 
if (isset($_GET['id_borrar'])) {
	echo '<h2>Borrar Imagenes</h2>';
	$id_borrar=$_GET['id_borrar'];
	$sql="SELECT imagen FROM imagenes WHERE id_img='$id_borrar'";
	$consulta=mysqli_query($conexion, $sql);
	$registro=mysqli_fetch_assoc($consulta);

	$img_borrar="imagenes/".$registro['imagen'];
	chmod($img_borrar, 0777);
	unlink("$img_borrar");
	$sql="DELETE FROM imagenes WHERE id_img='$id_borrar'";
	$borrar=mysqli_query($conexion, $sql)? print("Registro eliminado") : print ("Error al borrar");
}
/*aca hago lo mismo que arriba solo que en borrar cuando el usuario selecione borrar se tinee que borrar o mostrar un error*/ ?>

<?php 
$sql="SELECT * FROM imagenes";
$consulta=mysqli_query($conexion, $sql);

?>
 <h2>Mostrar registros</h2>
 <table border="1">
 	<tr>
 		<th>ID</th>
 		<th>IMAGENES</th>
 		<th>SLIDER</th>
 		<th>ACTUALIZAR</th>
 		<th>BORRAR</th>
 	</tr>

 <?php /*lo que hago arriba es generar la tabla y lo de abajo es generar dinamicamente los datos que estan guardados en la bd en la tabla*/
if (mysqli_num_rows($consulta)>0) {
	while ($registro=mysqli_fetch_assoc($consulta)) {
		echo '<tr>
		    <td>'.$registro['id_img'].'</td>
		    <td>'.$registro['imagen'].'</td>
			<td>'.$registro['slider'].'</td>
			<td><a href="administracion.php?id_editar='.$registro['id_img'].'">editar</a></td>
			<td><a href="administracion.php?id_borrar='.$registro['id_img'].'">borrar</a></td>

		</tr>	';
	}
	echo '</table>';
}else {
echo "tabla vacia";
}
/*mysqli sirve para ver si las tablas tiene columnas, mysqli_fetch_assoc sirve para convertir una variable en un vector asociativo */


mysqli_close($conexion);
 ?>
 </div>
</div>
</body>
</html>