<?php
    session_start();

    error_reporting(0);

    session_unset();

    session_destroy();

    ob_start();

    while (ob_get_status())
    {
        ob_end_clean();
    }
    
    header('Location:\tot\01.login\login.php');
?>
