<?php
  session_start();
  error_reporting(0);

  $SS = $_GET['p_code'];

  if( isset($_SESSION['approve_username']) AND !empty($_SESSION['approve_password'])):
    require(dirname(__FILE__).'/../../tot/config/connect.php');
    $SA = $_SESSION['Personnel_FL_Name'];
    try
    {
    
      $sql_1 = "SELECT * FROM `petition` WHERE p_code='$SS'";
      $stmt_1 = $dbh->prepare($sql_1);
      $stmt_1->execute();
      $row = $stmt_1->fetch(PDO::FETCH_ASSOC);

      $sql2 = "SELECT * FROM petition";
      $stmt2 = $dbh->prepare($sql2);
      $stmt2->execute();
      $branch = $stmt2->fetchAll();
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

    <!-- .....................................................สำหรับใช้ค้นหาภายใน Dropdown.........................................-................. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="\tot\assets\bootstrap\dist\js\bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <!-- ......................................................................................................................................... -->

    <link href="https://fonts.googleapis.com/css?family=Athiti" rel="stylesheet">
    <link href="/tot/css/jquery.datetimepicker.css" rel="stylesheet">
    <link href="/tot/css/fonts.css" rel="stylesheet">
    <link href="/tot/css/backtotop.css" rel="stylesheet">
    <link href="/tot/css/table_overtext.css" rel="stylesheet">
    <link href="/tot/css/fonts.css" rel="stylesheet">
    <title>สัญญาการกู้ยืมเงิน</title>
  </head>
  <body>
    <?php require(dirname(__FILE__).'/../main_menu/faculty_plan_officer/approve_menubar1.php');?>
    <?php echo "<br><br><br>"; ?>
  
    <div class="container"><center>
    <div class="shadow-lg p-3 mb-5 bg-white rounded" id="admin">
        <p><div style="border: 1px overflow: auto; width: 80%; height:auto; text-align: center;"><br></p>
        <form method="post" action="update_project_process4.php" name='form1' class="needs-validation" novalidate>
      
        <p><b><h4> สัญญากู้ยืมเงิน </h4></b></p>
        <p><b><h4> กองทุน ลภน.2 </h4></b></p>
        <hr class="my-4">
       
        <div class="text-right">
        <p><span style="padding-right:70px">วันเดือนปีที่กู้ยืมเงิน : <?php echo $row['p_date_borrow']; ?>
        </div>
        <input type="hidden"  name="p_code"  id="p_dateborrow" value="<?php echo $row['p_code']; ?>"readonly/>
        <div class="text-left">
        <p><span style="padding-left:150px">สัญญาฉบับนี้ทำขึ้นเพื่อกู้ยืมเงินฉุกเฉิน สำหรับ Call Center & HD & SUP</p></div>
        
        <div class="text-left">
        <p><span style="padding-left:150px">
        <b>ข้อ 1.</b> ผู้กู้ได้กู้ยืมเงิน เป็นจำนวนเงิน : <?php echo $row['p_amount']; ?>&ensp; บาท

	      <p><span style="padding-left:150px"><b>ข้อ 2.</b> ผู้กู้ยืมยอมหักค่าธรรมเนียมตามสัญญา ณ ที่จ่าย</span></p>
	      <p><span style="padding-left:200px">- กู้ยืม จำนวนเงิน 1-500 บาท ค่าธรรมเนีนม 5 บาท/ครั้ง</span></p>
	      <p><span style="padding-left:200px">- กู้ยืม จำนวนเงิน 501-1,000 บาท ค่าธรรมเนีนม 10 บาท/ครั้ง</span></p>
    
	      <p><span style="padding-left:150px"><b>ข้อ 3.</b> ผู้กู้ยอมสัญญาว่าจะนำเงินมาชำระ ภายในวันที่ 3 ของเดือนถัดไปหลังจากที่ผู้กู้ได้ยืมเงิน</span></p>
	      <p><span style="padding-left:200px">ตัวอย่างเช่น กู้ช่วงันที่ 1-31 ธันวาคม พ.ศ.2562 ต้องชำระคืนภายในวันที่ 3 มกราคม พ.ศ.2563</span></p><br>
    
	      <p><span style="padding-left:50px"><u>กรณีผิดการชำระ หรือไม่คืน</u></p> 
	      <p><span style="padding-left:50px">1.ไม่ให้กู้ยืมอีก</p>
	      <p><span style="padding-left:50px">2.ตัดค่าแรงแปรผันตามยอดเงินที่ค้างชำระ</p><br><br>
        </div>

        <div class="text-right">
        <p><span style="padding-right:70px">ลงชื่อ : <img src="..\signature\sign_image\<?php echo $row['p_signature'] ?>" width="170" alt="">
        <p><span style="padding-right:70px">(<?php echo $row['p_signature2']; ?>)
	      <p><span style="padding-right:70px">ผู้กู้ยืมเงิน</p><br><br>
        </div>

        <div class="text-right">
        <p><span style="padding-right:70px">ลงชื่อ : <img src="..\signature\sign_image\<?php echo $row['m_approve'] ?>" width="170" alt="">
        <p><span style="padding-right:70px">(<?php echo $SA; ?>)</p>
	      <p><span style="padding-right:70px">ผู้อนุมันติให้กู้</p><br><br>
        </div>

        <div class="text-center">
        <button type="submit" class="btn btn-warning" name="submit" value="Edit Now" 
            onclick="if(confirm('ยกเลิกการอนุมัติ ยืนยัน?')) return true; else return false;">ยกเลิกการอนุมัติ</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-danger" href="\tot\05.approve\index_approve1.php" role="button" 
            onclick="if(confirm('ยืนยันการอนุมัติ ตกลง?')) return true; else return false;">ตกลง
            </a>
            </div>
            </div>
            </div>

    <?php require(dirname(__FILE__).'/../main_menu/footer.html');?>

    <script src="\tot\assets\jquery\jquery.js"></script>
    <script src="/tot/ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="/tot/js/jquery.datetimepicker.full.js"></script>
    <script src="/tot/js/accounting.min.js"></script>

    

  </body>
</html>

