<?php
// General Information
$title = "Remote Ticket Management"; // Title you'll see on every page.
$server = "Example-WoW"; // Server name.


// Multi-Core Support
//Trinity Core = 1
//Elysium = 2
//Sunwell Core = 3
$core = "1";

// In-Game Account Information Used To Send Ticket Replies.
$soapAccount = "Username"; // In-game Account - Requires game master permissions. 
$soapPassword = "Password"; // In-game Account Password
$soapPort = "7878"; // Soap Port - Default port is usally 7878 for trinity core.

// Database information
$host = "localhost"; // Host name usually localhost or 127.0.0.1
$dbuser = "root"; // Database username
$dbpass = "ascent"; // Database password
$c_dbname = "characters"; // Characters database
$a_dbname = "auth"; // Account database

$conn = mysqli_connect($host, $dbuser, $dbpass);
?>