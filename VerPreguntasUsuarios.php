<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<?php
				$usuario=$_GET[var1];
				echo "<span class='right'>Hola, <font color='red'>".$usuario."</font></span>";
		?>
      	<span class="right"><a href="Layout.html">Logout</a></span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
	  <?php
			$usuario=$_GET[var1];
			echo "<span><a href='itzAlumno.php?var1=".$usuario."'>Inicio</a></spam>"; 
			echo "<span><a href='itzAlumnoInPreg.php?var1=".$usuario."'> Insertar Pregunta</a></spam>";
                        echo "<span><a href='VerPreguntasUsuarios.php?var1=".$usuario."'> Preguntas</a></spam>";
         ?>
	</nav>
    <section class="main" id="s1">
    
	<div>
    <?php
	
		#ConexiÃ³n con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u923585965_root", "Informatica", "u923585965_quiz");
		if(!$link){
		echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
        $sql="select MAX(ID_CONEXION) as ID_CON from CONEXIONES where CORREO='$_GET[var1]'";
		if (!($result=mysqli_query($link ,$sql))){
			die('Error en la consulta: ' . mysqli_error($link));
		}
        $resultado = mysqli_fetch_array($result);
        date_default_timezone_set('Europe/Madrid');
        $date=date("Y-m-d H:i:s");
        $ip_maquina =$_SERVER['REMOTE_ADDR'];
        $accion = "Ver preguntas";
		$id_conex=$resultado['ID_CON'];
	    $sql2="INSERT INTO ACCIONES VALUES (NULL,'$id_conex','$_GET[var1]','$accion', '$date', '$ip_maquina')";
		if (!mysqli_query($link ,$sql2)){
			die('Error al insertar tupla: ' . mysqli_error($link));
		}

	
		#Consulta de SQL: Obtener todas las preguntas de la BD.
		$preguntas = mysqli_query($link, "select CORREO, TXT_PREG,COMPLEJIDAD from pregunta" );
	
		#Creamos la tabla <html> donde queremos que se visualicen las preguntas.
		echo '<table border=1> <tr> <th> Autor </th> <th> Pregunta </th>  <th> Compeljidad </th> </tr>';
	
	
		#Insertamos los datos de cada pregunta (obtenidos tras la consulta) en la tabla creada anteriormente.
		while ($row = mysqli_fetch_array( $preguntas )) {
				echo '<tr><td>' . $row['CORREO'] . '</td> <td>' . $row['TXT_PREG'] . '</td> <td>' . $row['COMPLEJIDAD'] . '</td></tr>';
		}
		echo '</table>';
		$preguntas->close();
 
		#Cierre de la conexiÃ³n con la BD.
		mysqli_close($link);

    ?>

	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>