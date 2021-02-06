<?php 
require_once("slider/conexion.php");
$sql="SELECT imagen FROM imagenes WHERE slider='1'";
$consulta=mysqli_query($conexion, $sql);
/*
En la parte de arriba lo que hago es establecer una conexion con la bd donde estan las imagenes
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Slider de imagenes Dinamico</title>
    <link rel="stylesheet" href="css/estilos.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>

<body>
    <div class="contenedor">
        <div class="contenedormini">
        <nav>
        <a href="index.php">Inicio</a>
        <a href="slider/administracion.php">Crear Slider</a>
        </nav>
        </div>
    <?php
    /*lo que hago arriba es un sencillo menu donde va a direccionar al inicio y a la bd para cargar las imagenes*/
    if (mysqli_num_rows($consulta)==3){/*aca pregunto si la bd tiene mas de 3 imagenes se ejecuta todo lo de abajo*/    ?>
    <div class="container-all">
    
        <input type="radio" id="1" name="image-slide" hidden/>
        <input type="radio" id="2" name="image-slide" hidden/>
        <input type="radio" id="3" name="image-slide" hidden/>
    <?php /*los input de arriba sirven para que cuando clickiemos una imagen vaya directo a esa imagen y le damos la etiqueta image-slide para que en vez de aparecer los circulos
    aparezca las imagenes en miniatura*/?>
        <div class="slide">
        
            <?php
            $cont=1;    
        if (mysqli_num_rows($consulta)>0) {
        while ($registro=mysqli_fetch_assoc($consulta)) {
        echo '<div class="item-slide"><img src="slider/imagenes/'.$registro['imagen'].'">
        </div>';
        }
        }
        else {
        echo "Slider vacio";
        }
        /*lo que hago arriba es preguntar si la bd tiene las imagenes, si la tiene se ejecutar el while y convierte la variable en un vector asociativo y ya dentro del echo pongo la imagenes para que se muestren en el slider*/
        ?>

        </div>

        <div class="pagination">
           
            <?php    
        if (mysqli_num_rows($consulta)>0) {
            $consulta1= mysqli_query($conexion, $sql);
        while ($registro=mysqli_fetch_assoc($consulta1)) {
            echo '<label class="pagination-item" for="'.$cont.'"><img src="slider/imagenes/'.$registro['imagen'].'">
            </label>';
            $cont++;
        }
        }
        /*aca pasa exactamente lo mismo de arriba con la unica diferencia de que lo que voy a mostrar aca son las mini imagenes en la parte de abajo del slider*/
        ?>
            
        </div>
    </div>
<?php }
else{
    echo '<p class="sliderno">Agregue 3 imagenes a la bd, solo 3.';
}
?> 
</div>
</body>

</html>
