<?php
	
	//Must be same with server
	$host = "127.0.0.1";
	$port = 8080;

	// No Timeout 
	set_time_limit(0);

while(true) {
	
	//Create Socket
	$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

	//Connect to the server
	$result = socket_connect($sock, $host, $port) or die("Could not connect to server\n");

	$message = 'What should I do?';
	$message = readline('Enter a string: ');
	
	//Write to server socket
	socket_write($sock, $message, strlen($message)) or die("Could not send data to server\n");

	//Read server respond message
	$result = socket_read($sock, 1024) or die("Could not read server response\n");
	echo "Reply From Server:\n".$result."\n";

	//Close the socket
	socket_close($sock);

}

?>