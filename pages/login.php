<?php

if(isset($_SESSION['staff']) == false) {
?>
 <div class="container">
      <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Log Into <?php echo $server ?></h3>
        <input type="text" name="userName" class="form-control" placeholder="Username" required>
        <input type="password" name="passWord" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
      </form>
    </div>
  <div class="response">
		<?php logIn(); ?>
	</div>
</body>
</html>
<?php
}else {
  header('location: ?p=home');
}
?>