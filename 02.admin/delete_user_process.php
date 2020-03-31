<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['admin_username']) AND !empty($_SESSION['admin_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $Personnel_code  = $_GET['uid'];

   
    if ($_SESSION["Personnel_code"] == $_GET['uid'])
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
      // if ($num1 > 0 || $num2 > 0 || $num3 > 0 || $num4 > 0 || $num5 > 0)
      // {
      //   echo "<script>alert('ข้อมูลถูกอ้างอิง! ลบไม่ได้');</script>";
      // }
      // else
      // {
        $stmt1 = $dbh->prepare('DELETE FROM Personnel WHERE Personnel_code = :P1');
        $stmt1->bindParam(':P1', $Personnel_code);
        $stmt1->execute();

        header('Location:\tot\02.admin\index.php');
      // }
    }

  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
