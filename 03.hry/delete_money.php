<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $M_id  = $_GET['uid'];

    if ($_SESSION["M_id"] == $_GET['uid'])
    {
      echo "
      <script>
        if (confirm('ลบตัวเองไม่ได้!'))
        {
          window.history.back();
        }
      </script>";
    }
    else
    {
      
        $stmt1 = $dbh->prepare('DELETE FROM `money` WHERE M_id = :P1');
        $stmt1->bindParam(':P1', $M_id);
        $stmt1->execute();

        header('Location:\tot\03.hry\money.php');
    }

  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
