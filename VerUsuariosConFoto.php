<?php
    #Conexión con la BD
    $link = mysqli_connect("mysql.hostinger.es", "u923585965_root", "Informatica", "u923585965_quiz");
    if(!$link){
	echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
        mysqli_close($link);
    }

    #Consulta de SQL: Obtener todos los usuarios de la BD.
    $usuarios = mysqli_query($link, "select NOMBRE_APELLIDOS, CORREO, PASSWORD, TELEFONO, ESPECIALIDAD, INTERESES, FOTO, TIPO_FOTO from usuario" );

    #Creamos la tabla <html> donde queremos que se visualicen los usuarios.
    echo '<table border=1> <tr> <th> NOMBRE </th> <th> CORREO </th>  <th> CONTRASENA </th>  <th> TELEFONO </th>  <th> ESPECIALIDAD </th>  <th> INTERESES </th>  <th> FOTO </th>
    </tr>';

    #Insertamos los datos de cada usuario (obtenidos tras la consulta) en la tabla creada anteriormente.
    while ($row = mysqli_fetch_array( $usuarios )) {
        if(is_null($row['TIPO_FOTO'])){  # Significa que el usuario al registrarse no ha subido ninguna foto. Por lo tanto no debe mostrarse ninguna.
            echo '<tr><td>' . $row['NOMBRE_APELLIDOS'] . '</td> <td>' . $row['CORREO'] . '</td> <td>' . $row['PASSWORD'] . '</td> <td>' . $row['TELEFONO'] . '</td> <td>' . $row['ESPECIALIDAD'] . '</td> <td>' . $row['INTERESES'] .'</td> <td> Sin foto </td></tr>';
       
        }else{  #En este caso hay foto. Para visualizarla, se llama a otro programa php --> ver_imagen.php. Se le pasa como parámetro (en la URL), el valor del correo un usuario (que es la clave primaria). 
            echo '<tr><td>' . $row['NOMBRE_APELLIDOS'] . '</td> <td>' . $row['CORREO'] . '</td> <td>' . $row['PASSWORD'] . '</td> <td>' . $row['TELEFONO'] . '</td> <td>' . $row['ESPECIALIDAD'] . '</td> <td>' . $row['INTERESES'] .'</td> <td> <div><img src="ver_imagen.php?var1='. $row['CORREO'] .'"  width="200px" height="200px"/></div></td></tr>';
        }
    }
    echo '</table>';
    $usuarios->close();
 
    #Cierre de la conexión con la BD.
    mysqli_close($link);

?>
										