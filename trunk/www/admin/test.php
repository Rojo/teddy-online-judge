<?php
	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");
	require_once("require_login.php");
	require_once("require_admin.php");
?>

<div class="post_blanco"  align=left>
	<h2>Estructura de Teddy</h2>

	<p>Teddy debe tener permisos de escritura en estás rutas</p>
	<table border=0>
    <?php
  		$files = array(
        "../../work_zone",
        "../../codigos"
      );

    	foreach($files as $file){
    		echo "<tr>";
    		echo "<td>" . $file . "</td>";
    		if (is_writable($file)) {
    			echo "<td><b style='color: green'>OK</b></td>";
    		} else {
    			echo "<td><b style='color: red'>FAIL</b></td>";
    		}
    		echo "</tr>";
    	}
    ?>
	</table>

	<br><br>

	<p>Teddy debe poder ejecutar estos archivos</p>
	<table border=0>
    <?php
    	$files = array(
        "../../bin/compileC",
        "../../bin/compileCrystal",
        "../../bin/compileC++",
        "../../bin/compileC#",
        "../../bin/runC",
        "../../bin/runCrystal",
        "../../bin/runC#",
        "../../bin/runElixir",
        "../../bin/runJava",
        "../../bin/runJS",
        "../../bin/runPerl",
        "../../bin/runPhp",
        "../../bin/runPython",
        "../../bin/runRuby"
      );

    	foreach($files as $file){
    		echo "<tr>";
    		echo "<td>" . $file . "</td>";
    		if (is_executable($file)) {
    			echo "<td><b style='color: green'>OK</b></td>";
    		} else {
    			echo "<td><b style='color: red'>FAIL</b></td>";
    		}
    		echo "</tr>";
    	}
    ?>
	</table>

	<hr>
	<h2>Sistema de correos</h2>
	<p>Probando <a href="http://pear.php.net/package/Mail">Mail-1.2.0</a> del framework Pear, los paquetes a necesarios son : Mail y Net_STMP</p>
    <?php
    	require_once "Mail.php";

    	$from = "Teddy Online Judge <teddy@clubdeprogra.com>";
    	$to = "Alan Gonzalez <alan.gohe@gmail.com>";

    	$subject = "Hi!";
    	$body = "Hi,\n\nHow are you?";

    	$host = "mail.clubdeprogra.com";
    	$port = "25";
    	$username = "teddy@clubdeprogra.com";
    	$password = "nizI3KyoqPTz3z";

    	$headers = array (
    		'From' => $from,
    		'To' => $to,
    		'Subject' => $subject);

    	$smtp = Mail::factory('smtp',
    		array ('host' => $host,
    		'port' => $port,
    		'auth' => true,
    		'username' => $username,
    		'password' => $password));

			/*
			$mail = $smtp->send($to, $headers, $body);

			if (PEAR::isError($mail)) {
				echo("<p>" . $mail->getMessage() . "</p>");
			} else {
				echo("<p>Message successfully sent!</p>");
			}*/
    ?>

	<hr>

	<h2>Compiladores y entornos de programación</h2>
	<b>Java Runtime</b>
  <?php
  	$out = array();
  	$com= "java -version";
  	echo "<pre>" ;
  	echo exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

	<b>Java Compiler</b>
  <?php
  	$out = array();
  	$com= "javac -version";
  	echo "<pre>" ;
  	echo exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

	<b>C Compiler</b>
  <?php
  	$out = array();
  	$com= "gcc -v";
  	echo "<pre>" ;
  	echo exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		//echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

	<b>C++ Compiler</b>
  <?php
  	$out = array();
  	$com= "g++ -v";
  	echo "<pre>" ;
  	echo exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		//echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

	<b>Python</b>
  <?php
  	$out = array();
  	$com= "python -V";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

	<b>Perl</b>
  <?php
  	$out = array();
  	$com= "perl -v";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>


	<b>C# Compiler</b>
  <?php
  	$out = array();
  	$com= "gmcs --version";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

  <b>Crystal</b>
  <?php
  	$out = array();
  	$com= "crystal -v";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

  <b>Ruby</b>
  <?php
  	$out = array();
  	$com= "ruby -v";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

  <b>Elixir</b>
  <?php
  	$out = array();
  	$com= "elixir -v";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>

  <b>Node.js (Javascript)</b>
  <?php
  	$out = array();
  	$com= "nodejs -v";
  	echo "<pre>" ;
  	exec("$com 2>&1", $out, $err);
  	foreach ($out as $value) {
  		echo "$value\n";
  	}
  	echo "</pre>" ;
  ?>
</div>

<?php include_once("post_footer.php"); ?>
