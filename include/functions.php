<?php
// Handles Password
function shaenc($user, $pass){
  $user = strtoupper($user);
  $pass = strtoupper($pass);
  return sha1($user. ':'.$pass);
}

// Account Login & Set Functions
function logIn(){
	if(isset($_POST['login'])) {
	$username = $_POST['userName'];
	$password = shaenc($_POST['userName'], $_POST['passWord']);
	$currentip = $_SERVER['REMOTE_ADDR'];
}
include 'config.php';
mysqli_select_db($conn, $a_dbname);
  $stmt = $conn->prepare("SELECT username, sha_pass_hash, staff FROM account WHERE username = ? AND sha_pass_hash = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $stmt->bind_result($user, $pass, $staff);
  $stmt->store_result();
  if($stmt->num_rows > 0) {
    while($stmt->fetch()) {
      $stmt = $conn->prepare("UPDATE account SET last_ip = ? WHERE username = ?");
      $stmt->bind_param("ss", $currentip, $user);
      if ($stmt->execute()) {
        $_SESSION['username'] = $user;
        $_SESSION['staff'] = $staff;
        header('location: ../?p=home');
      }
	}
  }else {
  	// Do nothing, handled in another script.
  	}
 }

 function loggedOut(){
 if(isset($_SESSION['username'])) {
  	session_unset($_SESSION['username']);
  	header('location: /index.php');
  }else{
 	echo "You are already logged out!";
 	header('refresh:2; /index.php');
	}
 }

function getTikcetInfo(){
	include 'config.php';
	mysqli_select_db($conn, $c_dbname);
		$stmt = $conn->prepare("SELECT id, description, name FROM gm_ticket WHERE id = ?");
		$stmt->bind_param("i", $_GET['ticket']);
		$stmt->execute();
		$stmt->bind_result($id, $description, $name);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['ticketId'] = $id;
				$_SESSION['description'] = $description;
				$_SESSION['name'] = $name;
		}
	}
}
function ticketReply(){

include 'config.php';
$ticketiD = $_SESSION['ticketId'];
$client = new SoapClient(NULL, array(
	'location' => "http://$host:$soapPort/",
	'uri' => 'urn:TC',
	'style' => SOAP_RPC,
	'login' => $soapAccount,
	'password' => $soapPassword,
));

$ticketID=$ticketiD;
// Obtains ticket reply from /pages/ticket.php
if(isset($_POST['ticketReply'])) {
$reply=$_POST['ticketReply'];


$command1 = "ticket response append $ticketID $reply";
$command2 = "ticket complete $ticketID";

$result = $client->executeCommand(new SoapParam($command1, 'command'));
$result2 = $client->executeCommand(new SoapParam($command2, 'command'));
header('location: /index.php?success');
	}
}

?>