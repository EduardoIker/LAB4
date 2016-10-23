<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login</title>
  <link rel="stylesheet" href="estilos/stylelogin.css">
  
  <script language="javascript">
	
		function verificar(){
			var correo=document.getElementById("email");
			var password=document.getElementById("password");

			//Correo
			if(correo.value==""){
				alert("Completa el campo 'Correo'");
				return false;
			}
			//Contraseña
			if(password.value==""){
				alert("Completa el campo 'Password'");
				return false;
			}
			return true;
		}

  </script>
</head>
<body>
  <section class="container">
    <div class="login">
      <h1 align="center" >Acceder a QUIZ</h1>
      <form action="login.php" method="post" onSubmit='return verificar()'>
        <p> Email : <input type="text" name="email" size="21" id="email"/>
	<p> Password: <input type="password" name="pass" size="21"  id="password"/>
        <br>
        <p> <input type="submit" style="background:lime" value="Entrar" id="submit"/>
      </form>
    </div>
    <div class="goback">
      <p align="center"><a href="Layout.html">Volver a la pagina principal</a></p>
    </div>
  </section>
</body>
</html>


<?php
if(isset($_POST[email])){
    #Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u923585965_root", "Informatica", "u923585965_quiz");
	if(!$link){
		echo "Fallo al conectar a MySQL:" . $link->connect_error;
		mysqli_close($link);
	}
	
	# VALIDACIONES DE LOS DATOS 
	$StringVacio="";
	
	#Correo
    if(strcmp($_POST[email],$StringVacio)==0){
		echo "<script>alert('Completa el campo Email')</script>";
		echo "<p> <a href='login.html'> Volver a la página de login </a>";
		exit(1);
	}
	
	#Password
    if(strcmp($_POST[pass],$StringVacio)==0){
		echo "<script>alert('Completa el campo Password')</script>";
		echo "<p> <a href='login.html'> Volver a la página de login </a>";
		exit(1);
	}
	
	
	
	$email=$_POST[email];
	$pass=$_POST[pass];
	
	$sql="SELECT * from usuario where CORREO='$email' and PASSWORD='$pass'";
	if (!($result=mysqli_query($link ,$sql))){
				die('Error en la consulta: ' . mysqli_error($link));
			}
	$cont= mysqli_num_rows($result);
	if($cont==1){
		$row = mysqli_fetch_array($result);
                date_default_timezone_set('Europe/Madrid');
                $date=date("Y-m-d H:i:s");
                $sql="INSERT INTO CONEXIONES VALUES (NULL,'$_POST[email]', '$date')";
		if (!mysqli_query($link ,$sql)){
			die('Error al insertar tupla: ' . mysqli_error($link));
		}
                echo "<script>alert('Bienvenido!')</script>";
                header('location:itzAlumno.php?var1='.$row['CORREO'].'');
	}else{
		echo "<script>alert('Datos de acceso incorrectos. Intentalo de nuevo.')</script>";
	}
}						