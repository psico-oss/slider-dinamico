<?php
$server="localhost";
$user="root";
$pass="";
$conexion=mysqli_connect($server, $user, $pass) or DIE ("ERROR".mysqli_connect_errno($conexion));
$conexion->set_charset('utf8');
$db=mysqli_select_db($conexion, "slider") or DIE ("ERROR EN db: "). mysqli_error($conexion);
/*aca pido el usuario y la contraseña para conectarme a las base de datos y al final le digo a cual bd me quiero conectar que en este caso seria "slider"*/?>