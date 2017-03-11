<?php
define("IN_JIANJI", true);
/* Clean xss at first*/
include('system/security.php');
/* todo: Then check token */
/* Finally include core */
include('system/router.php');
?>
