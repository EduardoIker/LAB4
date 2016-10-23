<?php
	echo "<h3 align='center'>COLECCION DE PREGUNTAS</h3>";
	echo "<h5 align='center'>Estas son las preguntas que han quedado registradas:</h5>";
	#Estilo para la tbala
    echo "<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
			background-color: #4CAF50;
			color: white;
		}
		</style>";
	
	# Creamos la cabecera de la tabla
	echo "<table border='1'>";
	echo "<tr><td>ENUNCIADO</td><td>COMPLEJIDAD</td><td>TEMATICA</td></tr>";
	
	# Comenzamos con la lectura del fichero XML 
		#Carga del fichero
	$xml=simplexml_load_file('preguntas.xml');
		#Para cada pregunta...
	foreach($xml->assessmentItem as $assessmentItem){
			#Obtenemos los valores de los atributos complexity y subject
		$complejidad=$assessmentItem['complexity'];
		$tematica=$assessmentItem['subject'];
			#Para cada hijo de assessmentItem...
		foreach($assessmentItem->children() as $child){
				#... si se trata de itemBody, obtenemos el valor del enunciado y lo visualizamos en la tabla
			if($child->getName()=='itemBody'){
				$enunciado=$child->p;
				echo utf8_decode("<tr><td>".$enunciado."</td><td>".$complejidad."</td><td>".$tematica."</td></tr>");
			}
		}
	}
	
	# Cerramos el tag de table
	echo "</table>";
	
	# Enlace para volver a la pagina de inicio del usuario
	$usuario=$_GET[var1];
	echo "<a href='itzAlumno.php?var1=".$usuario."'>Volver a la pagina de inicio</a>";
?>