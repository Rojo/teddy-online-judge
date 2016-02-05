package mx.itc.teddy;

import java.io.*;

public class Ejecutar implements Runnable{

	private final  boolean printOutput = true;
	private String execID;
	private String LANG;
	private Process proc;
	private String PID;
	private String command;
	private String killcommand;
  public String status = "TIME";

	public void destroyProc(){
		proc.destroy();
		destroyPID();
	}

	public void destroyPID(){
		// destruir pid con kill
		try {
			proc = Runtime.getRuntime().exec("./killprocess " + killcommand);
		} catch(IOException ioe) {
			System.out.println(ioe);
		}
	}

	public void run(){

		synchronized(this){

			// ubicacion de el script sh externo
			command = "";

			double uid = Math.random();

			// comandos por lenguaje
      if (LANG.equals("C")) {
        command = "./runC " + execID  + " " + uid;
        killcommand = "a.out USER_CODE " + uid;
      }

      if (LANG.equals("C++")) {
        command = "./runC " + execID  + " " + uid;
        killcommand = "a.out USER_CODE " + uid;
      }

			if (LANG.equals("C#")) {
				command = "./runC# " + execID  + " " + uid;
				killcommand = "mono " + execID + ".exe USER_CODE " + uid;
			}

      if (LANG.equals("Crystal")) {
        command = "./runCrystal " + execID  + " " + uid;
        killcommand = execID + " USER_CODE " + uid;
      }

      if (LANG.equals("Elixir")) {
        command = "./runElixir " + execID  + " " + uid;
        killcommand = "elixir " + execID +".ex USER_CODE " + uid;
      }

      if (LANG.equals("Erlang")) {
        command = "./runErlang " + execID  + " " + uid;
        killcommand = "erl -noshell -s " + execID + " main " + uid + " -s init stop";
      }

			if (LANG.equals("Java")) {
				command = "./runJava " + execID + " " + uid ;
				killcommand = "java " + execID + " USER_CODE " + uid;
			}

      if (LANG.equals("Javascript")) {
        command = "./runJS " + execID  + " " + uid;
        killcommand = "node " + execID +".js USER_CODE " + uid;
      }

			if (LANG.equals("Perl")) {
				command = "./runPerl " + execID + " " + uid ;
				killcommand = "perl " + execID + ".pl USER_CODE " + uid;
			}

			if (LANG.equals("PHP")) {
				command = "./runPHP " + execID + " " + uid ;
				killcommand = "php "+ execID + ".php USER_CODE " + uid;
			}

      if (LANG.equals("Python")) {
        command = "./runPython "+ execID  + " " + uid;
        killcommand = "python " + execID + ".py USER_CODE " + uid;
      }

      if (LANG.equals("Ruby")) {
        command = "./runRuby " + execID  + " " + uid;
        killcommand = "ruby " + execID +".rb USER_CODE " + uid;
      }

      if (LANG.equals("Rust")) {
        command = "./runRust " + execID  + " " + uid;
        killcommand = execID + " USER_CODE " + uid;
      }

      if (LANG.equals("Swift")) {
        command = "./runSwift " + execID  + " " + uid;
        killcommand = execID + " USER_CODE " + uid;
      }

      if (LANG.equals("Go")) {
        command = "./runGo "+ execID  + " " + uid;
        killcommand = "go run " + execID + ".py USER_CODE " + uid;
      }

			int exitVal = 0;

			PID = command;

			try {
				// ejecutar el script
				proc = Runtime.getRuntime().exec(command);

				if (printOutput) {

					// leer salida estandar
					InputStreamReader isr = new InputStreamReader( proc.getInputStream() );
					BufferedReader br = new BufferedReader(isr);
					String linea = null;

					while ((linea = br.readLine()) != null) {
						TeddyLog.logger.warn("StdOut>" + linea);
					}

					// leer salida de error
					InputStreamReader isr2 = new InputStreamReader( proc.getErrorStream() );
					BufferedReader br2 = new BufferedReader( isr2 );
					String linea2 = null;

					while ((linea2 = br2.readLine()) != null) {
						TeddyLog.logger.warn("StdErr>" + linea2);
					}
				}

				// esperar a que termine el proceso
				exitVal =	 proc.waitFor();

			} catch( Exception e ) {
				// error interno del juez
				// status = "ERROR_JUEZ";
				System.out.println("Error, el juez no ha podido ejecutar el programa. \n" + e);
			}

			// alguna exception del progrma invitado
			if ( exitVal != 0 ) {
				System.out.println(exitVal);
				status = "EXCEPTION";
				return;
			}

			// avisar al otro hilo que hemos terminado
			status = "OK";
			notify();
		}
	} // run code thread

	void setLang( String lang ){
		LANG = lang;
	}

	// constructor
	Ejecutar(String s){
		this.execID = s;
	}

}
