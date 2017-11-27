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
        header('location: ?p=home');
      }
	}
  }else {
  	// Do nothing, handled in another script.
  	}
 }


// Display tickets on home page
 function getTickets(){
 	include 'config.php';
 	mysqli_select_db($conn, $c_dbname);

 	// Trinity Core Support
 	if($core == 1){
 	$stmt = $conn->prepare("SELECT id, playerguid, name, type, completed, closedBy FROM gm_ticket");
	$stmt->execute();
	$stmt->bind_result($id, $guid, $name, $type, $completed, $closedBy);
	$stmt->store_result();
	if($stmt->num_rows > 0) {
		while($stmt->fetch()) {
      if ($closedBy == 0 ){
      if ($completed == 0) {
      	echo "<tr>";
        echo "<td>$id</td>";
     	  echo "<td>$guid</td>";
        echo "<td>$name</td>";
        echo "<td>$type</td>";
        echo "<td>$completed</td>";
        echo "<td><a href=\"?ticket=$id\" class=\"btn btn-info\" role=\"button\">View</a></td>";
        echo "</tr>";
    		} else {
          // Show no tickets if completed == 1 or higher. 
        } 
      }else {
        // Show no tickets if closedBy == 1 or higher.
      }
	}
 }
}
// Elysium Core Support
if($core == 2){
 	$stmt = $conn->prepare("SELECT ticketId, guid, name, closedBy, completed, ticketType FROM gm_tickets");
	$stmt->execute();
	$stmt->bind_result($id, $guid, $name, $closedBy, $completed, $type);
	$stmt->store_result();
	if($stmt->num_rows > 0) {
		while($stmt->fetch()) {
      if ($closedBy == 0 ){
      if ($completed == 0) {
      	echo "<tr>";
        echo "<td>$id</td>";
     	  echo "<td>$guid</td>";
        echo "<td>$name</td>";
        echo "<td>$type</td>";
        echo "<td>$completed</td>";
        echo "<td><a href=\"?ticket=$id\" class=\"btn btn-info\" role=\"button\">View</a></td>";
        echo "</tr>";
    		} else {
          // Show no tickets if completed == 1 or higher. 
        } 
      }else {
        // Show no tickets if closedBy == 1 or higher.
      }
	}
  }
}
}

// Get ticket information in order to display it on /pages/ticket.php.
function getTikcetInfo(){
	include 'config.php';
	mysqli_select_db($conn, $c_dbname);
	if($core == 1){
		$stmt = $conn->prepare("SELECT id, playerGuid, description, name FROM gm_ticket WHERE id = ?");
		$stmt->bind_param("i", $_GET['ticket']);
		$stmt->execute();
		$stmt->bind_result($id, $playerGuid, $description, $name);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['ticketId'] = $id;
				$_SESSION['description'] = $description;
				$_SESSION['name'] = $name;
				$_SESSION['pGuid'] = $playerGuid;
		}
	}
  }
  if($core == 2){
  	$stmt = $conn->prepare("SELECT ticketId, guid, name, message FROM gm_tickets WHERE ticketId = ?");
		$stmt->bind_param("i", $_GET['ticket']);
		$stmt->execute();
		$stmt->bind_result($id, $playerGuid,  $name, $description);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['ticketId'] = $id;
				$_SESSION['description'] = $description;
				$_SESSION['name'] = $name;
				$_SESSION['c_pGuid'] = $playerGuid;
  	}
  }
}
}

// Handles the ticket reply by using soap to send in-game commands.
function ticketReply(){

include 'config.php';
$ticketiD = $_SESSION['ticketId'];

if($core == 1){
$client = new SoapClient(NULL, array(
	'location' => "http://$host:$soapPort/",
	'uri' => 'urn:TC',
	'style' => SOAP_RPC,
	'login' => $soapAccount,
	'password' => $soapPassword,
));
}else if ($core == 2){
	$client = new SoapClient(NULL, array(
	'location' => "http://$host:$soapPort/",
	'uri' => 'urn:MaNGOS',
	'style' => SOAP_RPC,
	'login' => $soapAccount,
	'password' => $soapPassword,
));
}

$ticketID=$ticketiD;
// Obtains ticket reply from /pages/ticket.php
if(isset($_POST['ticketReply'])) {
$reply=$_POST['ticketReply'];


$command1 = "ticket response append $ticketID $reply";
$command2 = "ticket complete $ticketID";

$result = $client->executeCommand(new SoapParam($command1, 'command'));
$result2 = $client->executeCommand(new SoapParam($command2, 'command'));
header('location: index.php?success');
	}
}

// Checks account permissions.
function getUsername(){
	include 'config.php';
	mysqli_select_db($conn, $a_dbname);
	if($core == 1){
		$stmt = $conn->prepare("SELECT username FROM account WHERE id = ?");
		$stmt->bind_param("i", $_SESSION['pGuid']);
		$stmt->execute();
		$stmt->bind_result($userAccount);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['userAccount'] = $userAccount;
		}
	}
}else if($core == 2){
		// Grab Character Account ID
		mysqli_select_db($conn, $c_dbname);
		$stmt = $conn->prepare("SELECT account FROM characters WHERE guid = ?");
		$stmt->bind_param("s", $_SESSION['c_pGuid']);
		$stmt->execute();
		$stmt->bind_result($cGuid);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['getUseraccount'] = $cGuid;
		}
	}	// Grab Character Account Username
		mysqli_select_db($conn, $a_dbname);
		$stmt = $conn->prepare("SELECT username FROM account WHERE id = ?");
		$stmt->bind_param("s", $_SESSION['getUseraccount']);
		$stmt->execute();
		$stmt->bind_result($userAccount);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['userAccount'] = $userAccount;
		}
	}
}
}

function getAccess(){
	if($_SESSION['staff'] == 0){
	header('location: pages/logout.php');
	}else{
		// Redirect to home page.
	}
}
?>