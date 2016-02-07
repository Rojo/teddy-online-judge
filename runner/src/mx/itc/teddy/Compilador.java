package mx.itc.teddy;

import java.io.*;
import java.util.Arrays;

public class Compilador {

	private String fileName;
	private String LANG;
	private String runId;
	private final boolean printOutput = true;
	private static final String[] INTERPRETED = new String[] {
    "Elixir",
    "Go",
    "Javascript",
		"Perl",
		"PHP",
		"Python",
    "Ruby"
	};

	public boolean compile() {
		String command = "";

		// no hay necesidad de compilar estos lenguajes
		if (Arrays.asList(INTERPRETED).contains(LANG)) { return true; }

		// estos lenguajes sí se compilan
		if (LANG.equals("C")) {
			command = "gcc " +
			  fileName + " -o /var/tmp/teddy/work_zone/" +
			  runId  + "/a.out -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE";
		}

		if (LANG.equals("C++")){
			command = "g++ " +
				fileName + " -o /var/tmp/teddy/work_zone/" +
				runId  + "/a.out -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE";
		}

		if (LANG.equals("C#")) { command = "gmcs " + fileName; }

		if (LANG.equals("Crystal")) { command = "crystal build " + fileName + " --release"; }

		if (LANG.equals("Erlang")) { command = "erlc " + fileName; }

		if (LANG.equals("Java")) { command = "javac " + fileName; }

		if (LANG.equals("Rust")) { command = "rustc -O " + fileName; }

		if (LANG.equals("Swift")) { command = "swiftc -O " + fileName; }

		TeddyLog.logger.info("Comando para compilar > " + command);
		int exitVal = -1;

		// intentar la compilacion
		try {
			Process proc = Runtime.getRuntime().exec(command);

			// esperar hasta que termine el proceso
			exitVal = proc.waitFor();

			// si es que vamos a imprimir salida
			if (printOutput) {
				// capturar la salida
				InputStreamReader isr = new InputStreamReader(proc.getInputStream());
				BufferedReader br = new BufferedReader(isr);

				String line = "";
				while ((line = br.readLine()) != null) {
					// imprimir en salida estandar
					TeddyLog.logger.warn("StdOut>>> " + line);
				}

				// leer salida de error
				InputStreamReader isr2 = new InputStreamReader( proc.getErrorStream() );
				BufferedReader br2 = new BufferedReader( isr2 );

				String line2 = null;
				String endString = "";

				while ((line2 = br2.readLine()) != null) {
					TeddyLog.logger.warn("StdErr>>> " + line2);
					endString += line2 + "\n";
				}

				if(endString.length() > 0){
					PrintWriter pw = new PrintWriter( new FileWriter( "/usr/teddy/codigos/" + runId + ".compiler_out") );
					pw.println( endString );
					pw.flush();
					pw.close();
				}
			}

		} catch(Exception e) {
			// error interno del juez
			TeddyLog.logger.fatal("ERROR EN EL JUEZ: " + e);
			return false;
		}

		// ¿si pudo compilar el juez? depende lo que regrese el compilador es si compiló o no compiló
		return (exitVal == 0);
	}

	// constructor
	Compilador() { TeddyLog.logger.info("Creando compilador..."); }
	void setLang(String LANG) { this.LANG = LANG; }
	void setFile(String fileName) { this.fileName = fileName; }
	void setRunId(String runId) { this.runId = runId; }

}

