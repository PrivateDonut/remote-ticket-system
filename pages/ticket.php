<?php
session_start();
include_once 'config.php';
?>
<head>
  <title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../include/css/bootstrap.min.css" rel="stylesheet">
  <link href="../include/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<form action="soapscript" method="POST">
	<?php
    // Get ticket information.
		mysqli_select_db($conn, $c_dbname);
		$stmt = $conn->prepare("SELECT id, description, name FROM gm_ticket WHERE id = ?");
		$stmt->bind_param("i", $_GET['ticket']);
		$stmt->execute();
		$stmt->bind_result($id, $description, $name);
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			while($stmt->fetch()) {
				$_SESSION['ticketId'] = $id
?>
</form>
<body>
 <div class="container">
      <form action="include/reply.php" class="form-signin" method="post">
        <h3 class="form-signin-heading">Ticket Created By: <b><?php echo $name?></b></h3>
        <input type="text" name="ticketId" class="form-control" value="Ticket ID: <?php echo $id ?>" disabled>
        <input type="text" name="accountName" class="form-control" value="Name: <?php echo $name?>" disabled>
        <textarea class="form-control" rows="5" name="ticketMessage" disabled><?php echo $description ?></textarea>
        <textarea class="form-control" rows="5" placeholder="Ticket Reply Goes Here..." name="ticketReply"></textarea>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Reply</button>
      </form>
    </div>
</body>	
<?php 
		}
	}
?>