<?php
session_start();
getAccess();
getTikcetInfo();
getUsername();
?>
<body>
 <div class="container">
      <form action="include/reply.php" class="form-signin" method="post">
        <h3 class="form-signin-heading">Ticket Created By: <b><?php echo $_SESSION['name']; ?></b></h3>
        <input type="text" name="ticketId" class="form-control" value="Ticket ID: <?php echo $_SESSION['ticketId'] ?>" disabled>
        <input type="text" name="accountName" class="form-control" value="Account: <?php echo $_SESSION['userAccount']; ?>" disabled>
        <textarea class="form-control" rows="5" name="ticketMessage" disabled><?php echo $_SESSION['description']; ?></textarea>
        <textarea class="form-control" rows="5" placeholder="Ticket Reply Goes Here..." name="ticketReply"></textarea>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Reply</button>
      </form>
    </div>
    <div class="response">
    	<?php ticketReply(); ?>
    </div>
</body>	
