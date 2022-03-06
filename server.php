<?php
	
	$host = "127.0.0.1";
	$port = 8080;
	$output = "";
	$param = "";
	// No Timeout 
	set_time_limit(0);

	//Create Socket
	$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

	//Bind the socket to port and host
	$result = socket_bind($sock, $host, $port) or die("Could not bind to socket\n");

	while(true) {
		//Start listening to the port
		$result = socket_listen($sock, 3) or die("Could not set up socket listener\n");

		//Make it to accept incoming connection
		$spawn = socket_accept($sock) or die("Could not accept incoming connection\n");

		//Read the message from the client socket
		$input = socket_read($spawn, 1024) or die("Could not read input\n");
        if (count($str=explode(" ",$input)) > 1) {
			$input = $str[0];
			$param = $str[1];
		}
		$output = "";
		
		switch ($input) {
		  case "Help":
			echo "Help\n";			
			exec('help', $output_arr, $retval);
			foreach ($output_arr as $item) { $output .= $item."\n"; }			
			break;
		  case "Search":
			echo "Search\n";
			exec('wget https://www.google.co.il/search?q='.$param, $output_arr, $retval);
			// Here need to add parsing of output result
			// ...
			foreach ($output_arr as $item) { $output .= $item."\n"; }		
			break;
		  case "Diskspace":
			echo "Diskspace\n";
			exec('df', $output_arr, $retval);
			echo $retval;
			if (!$retval) {
				foreach ($output_arr as $item) { $output .= $item."\n"; }			
			}
			// For Windows OS
			//$last_line = system('dir', $retval);
			//exec('dir', $output_arr, $retval);
			//system('dir', $output);
			//$output = $output_arr[count($output_arr)-1];
			//$output = ltrim($output);
			break;
		  default:	
		    $output = "No such command!";
		}

		//$output = 'I received your message "'.$input.'"';

		//Send message back to client socket
		socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");
	}

	socket_close($spawn);
	socket_close($socket);

?>