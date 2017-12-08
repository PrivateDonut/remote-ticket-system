<?php 
getAccess();
mysqli_select_db($conn, $c_dbname);
 ?>
<a href="?p=logout" class="btn btn-info pull-right" role="button">Logout</a>
<!-- Table Rows Start -->
<div class="container">     
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Guid</th>
        <th>Name</th>
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
