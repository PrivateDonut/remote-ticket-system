<?php
include "include/head.php";
if(isset($_GET['p'])) {
    $page = $_GET['p'];
    if(file_exists("pages/$page.php")) {
        include("pages/$page.php");
    }else{
        include("pages/404.php");
    }
}
elseif(isset($_GET['ticket'])) {
        include("pages/ticket.php");
    }else{
    include("pages/login.php");
}
include "include/foot.php";
?>