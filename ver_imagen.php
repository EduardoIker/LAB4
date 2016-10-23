<?php
        #Conexión con la BD.
	$link = mysqli_connect("mysql.hostinger.es", "u923585965_root", "Informatica", "u923585965_quiz");
	if(!$link){
		echo "Fallo al conectar a MySQL:" . $link->connect_error;
		mysqli_close($link);
	}
	
        #Con el valor del correo electrónico que se pasa a este programa como parámetro en la URL, realizamos otra consulta en la BD para obtener los valores de los atributos
        # 'foto' y 'tipo_foto'.
	$lafoto = mysqli_query($link, "select FOTO, TIPO_FOTO from usuario where CORREO='$_GET[var1]'" );

        #El resultado es una única tupla con los valores de los atributos 'foto' y 'tipo_foto' (podrán ser nulos)
	$row = mysqli_fetch_array( $lafoto );

        #Guardamos los valores en unas variables 
	$cvar1=$row['FOTO'];
	$cvar2=$row['TIPO_FOTO'];

        #Se indica el tipo de contenido a mostrar
	header("Content-type: ".$cvar2."");
     
        #Se muestra la foto
	echo ($cvar1);
?>
		