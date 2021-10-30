<?php
    include('conn/conn.php');

    session_destroy();
    header("Location:index.php");
?>