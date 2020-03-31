<?php
  session_start();
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $Personnel_code = $_SESSION["Personnel_code"];

    $stmt = $dbh->prepare("SELECT * FROM `personnel`"
                      . "WHERE Personnel_code = $Personnel_code");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    try
    {
      extract($row);
    }
    catch (PDOException $e)
    {
      echo 'เกิดข้อผิดพลาด : ' . $e->getMessage();
    }
  else:
    header('Location:\tot\01.login\login.php');
  endif;
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
    <title>ข้อมูลส่วนตัว: <?php echo $_SESSION["Personnel_FL_Name"]; ?></title>
  </head>
  <body>

    <?php require(dirname(__FILE__).'/../main_menu/user/user_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

    <div class="container">
      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
          <div class="jumbotron">
            <h2 style="text-align:center;">ข้อมูลส่วนตัว</h2>

            <p class="text-md-left">เลขที่ : <?php echo $Personnel_code; ?></p>
            <p class="text-md-left">ชื่อ-สกุล : <?php echo $Personnel_FL_Name; ?></p>
            <p class="text-md-left">ตำแหน่ง : <?php echo $Personnel_Position; ?></p>
            <p class="text-md-left">เบอร์โทรศัพท์ : <?php echo $Personnel_Phone; ?></p>
            <p class="text-md-left">ชื่อผู้ใช้ : <?php echo $Personnel_Usermae; ?></p>

            <div class="float-sm-right">
              <div class="form-row">
                <div class="form-group">
                  <a class="btn btn-warning" href="\tot\06.employer\update_os.php?uid=<?php echo $Personnel_code;?>">แก้ไขข้อมูล</a>
                  <a class="btn btn-danger" href="\tot\06.employer\index.php" role="button">กลับ</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-2"></div>
      </div>
    </div>

    <?php require(dirname(__FILE__).'/../main_menu/footer.html');?>

    <script src="\tot\assets\jquery\jquery.js"></script>
    <script src="\tot\assets\bootstrap\dist\js\bootstrap.min.js"></script>
  </body>
</html>
