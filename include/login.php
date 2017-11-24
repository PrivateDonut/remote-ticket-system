<?php
session_start();
include_once '../config.php';

function shaenc($user, $pass){
  $user = strtoupper($user);
  $pass = strtoupper($pass);
  return sha1($user. ':'.$pass);
}

$username = $_POST['userName'];
$password = shaenc($_POST['userName'], $_POST['passWord']);
$currentip = $_SERVER['REMOTE_ADDR'];

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
  } else {
    echo "Account either doesn't exist or missing correct permissions.";
  }
?>