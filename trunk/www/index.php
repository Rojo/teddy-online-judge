<?php
	require_once("../serverside/bootstrap.php");
	require_once("head.php");

	// Move this to some controller
	$sql = "SELECT table_name, TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?;";
	$inputarray = array("teddy");
	$result = $db->Execute($sql, $inputarray);
	$stats = $result->GetArray();

	$namedStats = array();
	for ($i = 0 ; $i < sizeof($stats); $i++)
	{
		switch($stats[$i]["table_name"])
		{
			case "Ejecucion":
				$namedStats["Ejecucion"] = $stats[$i]["TABLE_ROWS"];
				break;

			case "Usuario"  :
				$namedStats["Usuario"] = $stats[$i]["TABLE_ROWS"];
				break;

			case "Problema" :
				$namedStats["Problema"] = $stats[$i]["TABLE_ROWS"];
				break;

			case "Concurso" :
				$namedStats["Concurso"] = $stats[$i]["TABLE_ROWS"];
				break;
		}
	}
?>

<div class="post_blanco">
	<div align="center" >
		<h2>Bienvenido a Teddy</h2>
		<b><?php echo $namedStats["Ejecucion"]; ?></b> ejecuciones &nbsp;
		<b><?php echo $namedStats["Usuario"]; ?></b> usuarios &nbsp;
		<b><?php echo $namedStats["Problema"]; ?></b> problemas &nbsp;
		<b><?php echo $namedStats["Concurso"]; ?></b> concursos &nbsp;
	</div>
	<table>
		<tr>
			<td style="text-align:justify;">
				<br>
				<p>
				  Teddy es un oso de peluche, como se puede apreciar en la figura 1.0. Lo que lo distingue
				  de los dem&aacute;s peluches es que Teddy sabe programar.<br><br>
				  Introducido al mundo de la programaci&oacute;n a la tierna edad de d&iacute;a y medio de
				  haber sido fabricado, Teddy es uno de los programadores m&aacute;s h&aacute;biles,
				  habiendo resuelto todos los problemas del mundo. Conoce todos los trucos y t&eacute;cnicas
				  para convertir un problema aparentemente imposible en algo tan sencillo que hasta un oso
				  podr&iacute;a resolver.<br><br>
				  Hoy en d&iacute;a, Teddy dedica su tiempo libre a ayudar a los programadores a resolver
				  sus propios problemas, y les ofrece un reto cada semana para que practiquen.<br><br>
					Teddy no tiene dificultad evaluando c&oacute;digo en C, C++, C#, Crystal, Elixir, Java,
					Python, PHP y Ruby.<br><br>
					Teddy ir&aacute; llevando un conteo de qu&eacute; problemas ha resuelto cada quien, y en
					cu&aacute;nto tiempo. Si logras acumular una cantidad considerable de puntos, quien
					sabe... &iexcl;Teddy te podr&iacute;a dar una sorpresa!
				</p>
			</td>
		<td valign="top">
			<img style="border: 1px" src="img/teddy.jpg">
		</td>
	</tr>
	</table>
</div>

<div class="post_blanco">

	<div align="center">
		<h2>Estadísticas</h2>
	</div>

	<div align ="center">
	<?php
		# Esto aún es feo: debería tener su propio modelo y funciones helper,
	  # pero al menos se podrán agregar consultas de nuevos lenguajes de
	  # forma más sencilla.
	  # BTW, tal vez sería mejor listar los 5 lenguajes más usados de la
	  # plataforma.
		$lenguajes = array(
			"C"           => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"C++"         => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"C#"          => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Crystal"     => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Elixir"      => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Erlang"      => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Go"          => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Java"        => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Javascript"  => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Perl"        => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"PHP"         => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Python"      => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Ruby"        => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Rust"        => array( "ejecuciones" => 0, "porcentaje" => 0.0 ),
			"Swift"       => array( "ejecuciones" => 0, "porcentaje" => 0.0 )
		);

		# Consulta y calculo de datos sobre los lenguajes
		$total = 0;
		foreach ($lenguajes as $lenguaje => $datos) {
			$datos["ejecuciones"] = mysql_num_rows(
				mysql_query( "SELECT LANG FROM `Ejecucion` WHERE LANG = '".$lenguaje."';" )
			);
			$total += $datos["ejecuciones"];
		}

		if($total == 0) { $total = 1; };

		foreach ($lenguajes as $lenguaje => $datos) {
			$datos["porcentaje"] = $datos["ejecuciones"] * 100 / $total;
		}

		# Strings para la generación de gráficos
		$img_porcentajes = "";
		$img_etiquetas = "";
		foreach ($lenguajes as $lenguaje => $datos) {
			$img_porcentajes .= $datos["porcentaje"].",";
			$img_etiquetas .= urlencode($lenguaje)."|";
		}

	?>

	<img src="https://chart.googleapis.com/chart?
		chs=400x200
		&amp;	chtt=Lenguajes+usados
		&amp;	chd=t:<?php print( rtrim( $img_porcentajes, ',' ) ); ?>
		&amp;	cht=p
		&amp;	chl=<?php print( rtrim( $img_etiquetas, '|' ) ); ?>"
		alt="Lenguajes enviados a Teddy"
	/>

	<?php
		$ok = mysql_num_rows( mysql_query("SELECT LANG FROM `Ejecucion` WHERE status = 'OK'") );
		$tiempo = mysql_num_rows( mysql_query("SELECT LANG FROM `Ejecucion` WHERE status = 'TIEMPO'") );
		$compilacion = mysql_num_rows( mysql_query("SELECT LANG FROM `Ejecucion` WHERE status = 'COMPILACION'") );
		$runtime = mysql_num_rows( mysql_query("SELECT LANG FROM `Ejecucion` WHERE status = 'RUNTIME_ERROR'") );
		$wrong = mysql_num_rows( mysql_query("SELECT LANG FROM `Ejecucion` WHERE status = 'INCORRECTO'") );
		$total = mysql_num_rows( mysql_query("SELECT LANG FROM `Ejecucion`") );

		$otros = $total - ($ok + $tiempo + $compilacion + $runtime + $wrong);
		if($total == 0) { $total = 1; };

		$ok = ($ok * 100) / $total;
		$tiempo = ($tiempo * 100) / $total;
		$compilacion = ($compilacion * 100) / $total;
		$runtime = ($runtime * 100) / $total;
		$wrong = ($wrong * 100) / $total;
		$otros = ($otros * 100) / $total;
	?>

	<img src="https://chart.googleapis.com/chart?
		chs=400x200
		&amp;	chtt=Status+de+envios
		&amp;	chd=t:<?php print($ok.','.$wrong.','.$tiempo.','.$compilacion.','.$runtime.','.$otros); ?>
		&amp;	cht=p
		&amp;	chl=Aceptado|Incorrecto|Tiempo|Compilacion|Runtime+Error|Otros"
		alt="Lenguajes enviados a Teddy"
	/>

	<?php
		$days = 6;
		$data_for_chart  = "";
		$data_for_chart_dates  = "";

		while ( $days >= 0 )
		{
			$dia  = mktime(0, 0, 0, date("m")  , date("d")-$days, date("Y"));
			$res = mysql_query("SELECT execID, fecha FROM `Ejecucion` WHERE fecha like '" . date("Y-m-d", $dia) . " %:%:%'");
			$data_for_chart .= mysql_num_rows($res) . ",";
			$data_for_chart_dates .= date("M+d|", $dia);
			$days -- ;
		}

		$data_for_chart = substr($data_for_chart , 0, strlen($data_for_chart) - 1 );
		$data_for_chart_dates = substr($data_for_chart_dates , 0, strlen($data_for_chart_dates) - 1 );
	?>
	</div>

	<br>

	<div align="center">
		<img src="https://chart.googleapis.com/chart?
			chs=400x200
			&amp;	chtt=Envios+de+los+ultimos+7+dias
			&amp;	cht=ls
			&amp;	chd=t:<?php echo $data_for_chart; ?>
			&amp;	chds=0,100
			&amp;	chg=20,20
			&amp;	chm=N,000000,0,-1,11
			&amp;	chxt=x,y
			&amp;	chco=0000FF
			&amp;	chl=<?php echo $data_for_chart_dates; ?>"
			alt="Lenguajes enviados a Teddy"
		/>

		<?php
			$days = 6;
			$data_for_chart  = "";
			$data_for_chart_dates  = "";

			while ( $days >= 0 )
			{
				$dia = strtotime("first day of this month -$days month");
				$res = mysql_query("sELECT count(execID) FROM `Ejecucion` WHERE fecha like '" . date("Y-m", $dia) . "-% %:%:%'");
				$row = mysql_fetch_array($res);
				$data_for_chart .= $row[0] . ",";
				$data_for_chart_dates .= date("M|", $dia);
				$days -- ;
			}

			$data_for_chart = substr($data_for_chart , 0, strlen($data_for_chart) - 1 );
			$data_for_chart_dates = substr($data_for_chart_dates , 0, strlen($data_for_chart_dates) - 1 );
		?>

			<img src="https://chart.googleapis.com/chart?
				chs=400x200
				&amp;	chtt=Envios+de+los+ultimos+meses
				&amp;	cht=ls
				&amp;	chd=t:<?php echo $data_for_chart; ?>
				&amp;	chds=0,1000
				&amp;	chg=20,20
				&amp;	chm=N,000000,0,-1,11
				&amp;	chxt=x,y
				&amp;	chco=0000FF
				&amp;	chl=<?php echo $data_for_chart_dates; ?>"
				alt="Envios a Teddy"
			/>

	</div>
</div>

<?php include_once("post_footer.php"); ?>
