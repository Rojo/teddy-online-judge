<?php 

	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");

?>
	<div class="post_blanco">
	<?php
	//encontrar todos los titulos y asignarselos a un array
	$query = mysql_query("select probID, titulo from Problema");
	$probset = array();

	while($foo = mysql_fetch_array($query)){
		$probset[ $foo["probID"] ] = $foo["titulo"];
	}


	$consulta = "SELECT * FROM `Ejecucion` order by fecha desc LIMIT 100";
	$resultado = mysql_query($consulta);
	?>

	<div align="center" >
	<table border='0' style="font-size: 14px;" > 
	<thead> <tr >
		<th width='12%'>ID</th> 
		<th width='12%'>Problema</th> 
		<th width='12%'>Usuario</th> 
		<th width='12%'>Lenguaje</th> 
		<th width='12%'>Resultado</th> 
		<th width='12%'>Tiempo</th> 
		<th width='12%'>Fecha</th>
		<th width='12%'>IP</th> 
		<th width='12%'></th> 
		</tr> 
	</thead> 
	<tbody>
	<?php
	$flag = true;
    	while($row = mysql_fetch_array($resultado)){
		$color = "black";
		$ESTADO = $row['status'];

		$nick = htmlentities( $row['userID'] );

		$foobar = $row['execID'];
		$tooltip = "Ver este Codigo";

		if( $row["Concurso"] != -1 ){
			$foobar = "{" . $row['execID'] . "}";
			$tooltip = "Este run fue parte de algun concurso online";
		}


        
		if($flag){
			echo "<TR style='background:#e7e7e7;'>";
			$flag = false;
		}else{
			echo "<TR style='background:white;'>";
			$flag = true;
		}



		echo "<TD align='center' ><a title='$tooltip' href='verCodigo.php?execID={$row['execID']}'>". $foobar  ."</a></TD>";
		echo "<TD align='center' ><a href='verProblema.php?id=". $row['probID']  ."'>". $row['probID']   ." - ".$probset[ $row["probID"] ]."</a> </TD>";
		echo "<TD align='center' ><a title='Ver perfil' href='runs.php?user=". $row['userID']  ."'>". $nick ."</a> </TD>";
		echo "<TD align='center' >". $row['LANG']   ."</TD>";
		echo "<TD align='center' ><div style=\"color:".$color."\">". $ESTADO   ."</div> </TD>";
		echo "<TD align='center' >". $row['tiempo']  ." ms </TD>";
		echo "<TD align='center' >". date( "g:i:sa  d/M/Y", strtotime($row['fecha']))   ." </TD>";
		echo "<TD align='center' >". $row['remoteIP']   ." </TD>";
		echo "<TD align='center' >[borrar] [ver] [rejudge]</TD>";

		echo "</TR>";
	}
	?>		
	</tbody>
	</table>
	</div>
	</div>

	<?php include_once("post_footer.php"); ?>

