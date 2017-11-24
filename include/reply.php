<?php
session_start();
include ('../config.php');
$ticketiD = $_SESSION['ticketId'];
$client = new SoapClient(NULL, array(
	'location' => "http://$host:$soapPort/",
	'uri' => 'urn:TC',
	'style' => SOAP_RPC,
	'login' => $soapAccount,
	'password' => $soapPassword,
));
//var_dump($client);
$ticketID=$ticketiD;
$reply=$_POST['ticketReply'];

$command1 = "ticket response append $ticketID $reply";
$command2 = "ticket complete $ticketID";

$result = $client->executeCommand(new SoapParam($command1, 'command'));
$result2 = $client->executeCommand(new SoapParam($command2, 'command'));
header('location: /index.php');
?>