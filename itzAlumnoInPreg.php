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
		   
	<script language="javascript">
	
		function verificar(){
			var pregunta=document.getElementById("pregunta");
			var respuesta=document.getElementById("respuesta");
			var complejidad=document.getElementById("complejidad");
                        var tema=document.getElementById("tema");

			//Pregunta
			if(pregunta.value==""){
				alert("Introduce una pregunta");
				return false;
			}
			//Respuesta
			if(respuesta.value==""){
				alert("Introduce una respuesta a la pregunta");
				return false;
			}
			//Complejidad
			if(complejidad.value!="1"&&complejidad.value!="2"&&complejidad.value!="3"&&complejidad.value!="4"&&complejidad.value!="5"&&complejidad.value!=""){
				alert("Introduce un valor de complejidad válido (entre 1 y 5)");
				return false;
			}
            //Tema
			if(tema.value==""){
				alert("Introduce el tema de la pregunta");
				return false;
			}
			return true;
		}

  </script>
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
				echo "<span><a href='itzAlumnoInPreg.php?var1=".$usuario."'>Insertar Pregunta</a></spam>";
			echo "<span><a href='VerPreguntasUsuarios.php?var1=".$usuario."'> Preguntas</a></spam>";
		?>
	</nav>
    <section class="main" id="s1">
    
	<div>
            <?php
			$usuario=$_GET[var1];
			echo "<form action='itzAlumnoInPreg.php?var1=".$usuario."' method='post' onSubmit='return verificar()'>";
            ?>
        <p align='left'> Pregunta: <input type="text" name="pregunta" size="42" id="pregunta"/>
		<p align='left'> Respuesta: <input type="text" name="respuesta" size="21"  id="respuesta"/>
		<p align='left'> Complejidad: <input type="text" name="complejidad" size="1"  id="complejidad"/>
        <p align='left'> Tema: <input type="text" name="tema" size="17"  id="tema"/>
		<p align='left'> <input type="submit" value="Guardar Pregunta" id="submit"/>
      </form>
	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>
<?php
if(isset($_POST[pregunta]) && isset($_POST[respuesta]) && isset($_POST[complejidad]) && isset($_POST[tema])){
	#Conexion con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u923585965_root", "Informatica", "u923585965_quiz");
	if(!$link){
		echo "Fallo al conectar a MySQL:" . $link->connect_error;
		mysqli_close($link);
		exit(1);
	}
	
	#Abrir el fichero XML
	$xml = simplexml_load_file('preguntas.xml');
	if (!$xml) {
		echo "Error cargando XML";
		exit(1);
	}
	
	# VALIDACIONES DE LOS DATOS 
	#Pregunta
    if(strcmp($_POST[pregunta],"")==0){
		echo "<script>alert('Introduce una pregunta')</script>";
		exit(1);
	}
	
	#Respuesta
    if(strcmp($_POST[respuesta],"")==0){
		echo "<script>alert('Introduce una respuesta')</script>";
		exit(1);
	}
	
	#Complejidad
    if((strcmp($_POST[complejidad],"1")!=0) && (strcmp($_POST[complejidad],"2")!=0) && (strcmp($_POST[complejidad],"3")!=0) && (strcmp($_POST[complejidad],"4")!=0) && (strcmp($_POST[complejidad],"5")!=0) && (strcmp($_POST[complejidad],"")!=0)){
		echo "<script>alert('Introduce un valor de complejidad válido (entre 1 y 5)')</script>";
		exit(1);
	}

    #Tema
    if(strcmp($_POST[tema],"")==0){
		echo "<script>alert('Introduce un tema')</script>";
		exit(1);
	}
	
	#Insertamos la pregunta si todo ha ido bien...
	
		#En la BD
	$sql="INSERT INTO pregunta VALUES (NULL,'$_GET[var1]','$_POST[pregunta]','$_POST[respuesta]','$_POST[complejidad]')";
	if (!mysqli_query($link ,$sql)){
		die('Error al insertar tupla: ' . mysqli_error($link));
	}
        $sql="select MAX(ID_CONEXION) as ID_CON from CONEXIONES where CORREO='$_GET[var1]'";
	if (!($result=mysqli_query($link ,$sql))){
		die('Error en la consulta: ' . mysqli_error($link));
	}
        $resultado = mysqli_fetch_array($result);
        $id_conex=$resultado['ID_CON'];
        date_default_timezone_set('Europe/Madrid');
        $date=date("Y-m-d H:i:s");
        $ip_maquina =$_SERVER['REMOTE_ADDR'];
        $accion = "Insertar pregunta";
	$sql2="INSERT INTO ACCIONES VALUES (NULL,'$id_conex','$_GET[var1]','$accion', '$date', '$ip_maquina')";
		if (!mysqli_query($link ,$sql2)){
			die('Error al insertar tupla: ' . mysqli_error($link));
		}
	
		#En el fichero preguntas.xml
    $assessmentItem = $xml->addChild('assessmentItem');
    $assessmentItem->addAttribute('complexity', $_POST['complejidad']);//
    $assessmentItem->addAttribute('subject', $_POST['tema']);//
    $itemBody =$assessmentItem->addChild('itemBody');
    $itemBody->addChild('p', $_POST['pregunta']);
    $correctResponse =$assessmentItem->addChild('correctResponse');
    $correctResponse->addChild('value', $_POST['respuesta']);
    $xml->asXML('preguntas.xml');
	
	
	#Enlace para visualizar el fichero preguntas.xml
	$usuario=$_GET[var1];
    echo "<p> <a href='VerPreguntasXML.php?var1=".$usuario."'> Ver preguntas </a>";
    
	#Alert para indicar que la pregunta se ha insertado correctamente
	echo "<script>alert('Pregunta guardada correctamente')</script>";
}
?>		