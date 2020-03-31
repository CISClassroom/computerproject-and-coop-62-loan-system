<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $p_code  = $_GET['uid'];

   
    if ($_SESSION["p_code"] == $_GET['uid'])
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
        $stmt1 = $dbh->prepare('DELETE FROM petition WHERE p_code = :P1');
        $stmt1->bindParam(':P1', $p_code);
        $stmt1->execute();

        header('Location:\tot\06.employer\index.php');
     
    }

  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
