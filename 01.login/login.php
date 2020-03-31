<?php
  session_start();

  require(dirname(__FILE__).'/../../tot/config/connect.php');

  if (isset($_SESSION['username']) AND !empty($_SESSION['password']))
  {
    header('Location:\tot\02.admin\index.php');
  }
  else
  {
    try
    {
      $connect = new PDO($dsn, $username, $password);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(isset($_POST["login"]))
      {
        if(empty($_POST["username"]) || empty($_POST["password"]))
        {
          echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!');</script>";
        }
        else
        {
          $query1 = "SELECT * FROM personnel WHERE Personnel_Usermae = :username AND Personnel_Password = :password";
          $statement1 = $connect->prepare($query1);
          $statement1->execute(
          array(
                'username' => $_POST["username"],
                'password' => sha1(MD5($_POST["password"]))
                )
          );
          $count1 = $statement1->rowCount();
          //----------------------------------------------------------------------------------------------
          if($count1 > 0)
          {
            session_start();
            $_SESSION["username"] = $_POST["username"];
            $_SESSION['password'] = sha1(MD5($_POST["password"]));
            header("location:login_process.php");
          }
          else
          {
              echo "<script>alert('ไม่พบข้อมูล! กรุณากรอกข้อมูลให้ถูกต้อง');</script>";
          }
        }
      }
   }
   catch(PDOException $error)
   {
        $message = $error->getMessage();
   }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="\tot\img\tot_favicon.ico">
    <link rel="stylesheet" type="text/css" href="\tot\assets\bootstrap\dist\css\glyphicon.css">
    <link rel="stylesheet" type="text/css" href="\tot\assets\bootstrap\dist\css\style.css">
    <link rel="stylesheet" href="\tot\assets\bootstrap\dist\css\bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Athiti" rel="stylesheet">
    <link href="/tot/css/fonts.css" rel="stylesheet">
    <link href="/tot/css/signin.css" rel="stylesheet">
    <title>เข้าสู่ระบบ</title>
    <style>
    </style>
  </head>
  
  <body>
    <?php require(dirname(__FILE__).'/../../tot/main_menu/login/login_bar.php'); ?>
    <br>
    
   
    <form class="form-signin" method="post" name="login">
      <div class="shadow-lg p-3 mb-5 bg-white rounded">
        <center><h1 class="h3 mb-3 font-weight-normal">
          <p class="font-weight-bold text-primary">
          <img src="\tot\img\totlogo.png" width="65" height="35" class="d-inline-block align-top" alt=""> ยินดีต้อนรับ</p>
        </h1></center>&nbsp;
        <label for="inputEmail" class="sr-only">ชื่อผู้ใช้</label>
        <input type="text" name="username" id="inputEmail" class="form-control" placeholder="ชื่อผู้ใช้" required autofocus>&nbsp;
        <label for="inputPassword" class="sr-only">รหัสผ่าน</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="รหัสผ่าน" required>
        <center><button name="login" class="btn btn-lg btn-warning btn-block" type="submit">เข้าสู่ระบบ</button>
        <p class="mt-5 mb-3 text-muted">&copy; TOT ยินดีต้อนรับ</p></center>
      </div>
    </form>

    <script src="\tot\assets\jquery\jquery.js"></script>
    <script src="\tot\assets\bootstrap\dist\js\bootstrap.min.js"></script>
  </body>
</html>
