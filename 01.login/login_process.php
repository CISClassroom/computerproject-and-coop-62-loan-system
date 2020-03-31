<?php
  session_start();
  if( isset($_SESSION['username']) AND !empty($_SESSION['password']))
  {
    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $user = $_SESSION['username'];
    $pass = $_SESSION['password'];

    $dbh = new PDO($dsn, $username ,$password, $options);
    $sql = "SELECT * FROM `personnel` WHERE `Personnel_Usermae` = '$user' AND `Personnel_Password` = '$pass'";
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $stmt = $dbh->prepare($sql);
    try {
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $f_name = '';
      $l_name = '';

      if ($row["Personnel_Position"] == 'Administrator')
      {
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['admin_username'] = $user;
        $_SESSION['admin_password'] = $pass;
        header('Location:\tot\02.admin\index.php');
      }
      elseif($row["Personnel_Position"] == "CallCenter"){
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['callcenter_username'] = $user;
        $_SESSION['callcenter_password'] = $pass;
        header('Location:\tot\06.employer\index.php');
      }
      elseif($row["Personnel_Position"] == "Manager" && $row["Personnel_FL_Name"] == "นายสุนย์ทร อรรคแสง"){
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['approve_username'] = $user;
        $_SESSION['approve_password'] = $pass;
        header('Location:\tot\05.approve\index_approve.php');
      }
      elseif($row["Personnel_Position"] == "Manager" && $row["Personnel_FL_Name"] == "นายสมชัย โยหา"){
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['approve_username'] = $user;
        $_SESSION['approve_password'] = $pass;
        header('Location:\tot\05.approve\index_approve2.php');
      }
      elseif($row["Personnel_Position"] == "Supervisor"){
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['callcenter_username'] = $user;
        $_SESSION['callcenter_password'] = $pass;
        header('Location:\tot\06.employer\index.php');
      }
      elseif($row["Personnel_Position"] == "HelpDesk"){
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['callcenter_username'] = $user;
        $_SESSION['callcenter_password'] = $pass;
        header('Location:\tot\06.employer\index.php');
      } 
      elseif($row["Personnel_Position"] == "Account"){
        $_SESSION["Personnel_code"] = $row['Personnel_code'];
        $_SESSION["Personnel_FL_Name"] = $row['Personnel_FL_Name'];
        $_SESSION["Personnel_Position"] = $row['Personnel_Position'];
        $_SESSION["Personnel_Phone"] = $row['Personnel_Phone'];
        $_SESSION['Account_username'] = $user;
        $_SESSION['Account_password'] = $pass;
        header('Location:\tot\03.hry\index.php');
      }
      else
      {
        return false;
      }

    }
    catch (PDOException $e) {
      echo 'เกิดข้อผิดพลาด : ' . $e->getMessage();
    }
  }
  else
  {
    header('Location:\tot\01.login\login.php');
  }
?>
