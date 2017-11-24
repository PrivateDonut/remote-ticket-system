<?php
session_start();
if(isset($_SESSION['username'])) {
  session_unset($_SESSION['username']);
  header('location: /index.php');
}else{
 echo "You are already logged out!";
 header('refresh:2; /index.php');
}
?>
