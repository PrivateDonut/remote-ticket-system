<?php
session_start();
if(isset($_SESSION['username'])) {
  session_unset($_SESSION['username']);
  header('location: ?p=login');
}else{
 echo "You are already logged out!";
 header('refresh:2; ?p=login');
}
?>
