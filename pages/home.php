<?php 
session_start();
getAccess();
mysqli_select_db($conn, $c_dbname);
 ?>
<!DOCTYPE html>
<html>
<body>
<a href="/pages/logout.php" class="btn btn-info pull-right" role="button">Logout</a>
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
    echo getTickets();
	?>
	</tbody>
  </table>
</div>
</body>
</html>
