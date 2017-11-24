<?php
include_once 'config.php';
session_start();
if(isset($_SESSION['staff']) == false) {
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title?> - Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../include/css/bootstrap.min.css" rel="stylesheet">
  <link href="../include/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
 <div class="container">
      <form action="include/login.php" class="form-signin" method="post">
        <h3 class="form-signin-heading">Log Into <?php echo $server ?></h3>
        <input type="text" name="userName" class="form-control" placeholder="Username" required>
        <input type="password" name="passWord" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div>
</body>

<!-- Developer Credits -->
<div class="footer-copyright">
    <div align="center" class="container-fluid">
        Made By - <a href="http://www.ac-web.org/forums/member.php?212435-PrivateDonut">PrivateDonut</a>
    </div>
</div>
</html>
<?php
}else {
  header('location: ../?p=home');
}
?>