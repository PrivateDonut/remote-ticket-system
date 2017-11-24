<?php 
session_start();
include 'config.php';
mysqli_select_db($conn, $c_dbname);

if(isset($_SESSION['staff']) == 1) {
 ?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<a href="/?p=logout" class="btn btn-info pull-right" role="button">Logout</a>
<!-- Table Rows Start -->
<div class="container">     
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Guid</th>
        <th>Name</th>
        <th>Ticket Type</th>
        <th>Completed</th>
        <th>View</th>
      </tr>
    </thead>
<!-- Table Data Starts -->
    <tbody>
    <?php
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
	?>
	</tbody>
  </table>
</div>
<!-- Developer Credits -->
<div class="footer-copyright">
    <div align="center" class="container-fluid">
        Made By - <a href="http://www.ac-web.org/forums/member.php?212435-PrivateDonut">PrivateDonut</a>
    </div>
</div>
</body>
</html>

<?php
} else {
  // Show nothing yet... 
  echo "5";
}
?>