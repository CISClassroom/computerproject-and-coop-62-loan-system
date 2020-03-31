<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):
    require(dirname(__FILE__).'/../../tot/config/connect.php');

    date_default_timezone_set('Asia/Bangkok');

    $date_check = date('Y-m-d');
    
    $SA = $_GET['Personnel_FL_Name'];
    $SS = $_GET['Personnel_code'];

    /* $count2 = "SELECT * FROM `petition` WHERE `p_status` != 'ชำระเรียบร้อย' and  p_signature2 = '$SA'";
		$result2 = $dbh->prepare($count2);
		$result2->execute();
		$num2 = $result2->fetchColumn();
		if($num2 > 0)
		{				 
			echo "<script language='javascript' type='text/javascript'> alert('ไม่สามารถทำรายการได้เนื่องจาก คุณมียอดคค้างชำระ กรุณาชำระยอดคงเหลือทั้งหมดก่อนยืมครั้งต่อไป');</script>";
			echo '<meta http-equiv= "refresh" content="0; url=index.php"/>';
    }
    else{
      */



    $count2 = "SELECT * FROM `petition` WHERE `p_status` != 'ชำระเรียบร้อย' and personnel_code = '$SS' ORDER BY p_code ASC LIMIT 1";
		$result2 = $dbh->prepare($count2);
		$result2->execute();
		$num2 = $result2->fetchColumn();
		if($num2 > 0)
		{				 
			echo "<script language='javascript' type='text/javascript'> alert('ไม่สามารถทำรายการได้เนื่องจาก คุณมียอดคค้างชำระ กรุณาชำระยอดคงเหลือทั้งหมดก่อนยืมครั้งต่อไป');</script>";
			echo '<meta http-equiv= "refresh" content="0; url=index.php"/>';
    }
    else{
      

    try
    {          
      $sql2 = "SELECT * FROM `personnel` WHERE Personnel_code='$SS'";
      $stmt2 = $dbh->prepare($sql2);
      $stmt2->execute();
      $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    }
    
    catch (PDOException $e)
    {
      echo 'เกิดข้อผิดพลาด : ' . $e->getMessage();
    }
 }
  else:
    header('Location:\tot\01.login\login.php');

    /*   if (date("d") <= 21){
      echo "<script language='javascript' type='text/javascript'>";
      echo "alert('ขณะนี้ระบบไม่สามารถทำการกู้ยืมได้ เนื่องจากระบบสามารถทำการกู้ยืมได้ทุกวันที่ 15');</script>";
      echo '<meta http-equiv= "refresh" content="0; url=index.php"/>';
    }
    */
    
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
  <?php require(dirname(__FILE__).'/../main_menu/user/user_menubar.php'); ?>
  <?php echo "<br><br><br>"; ?>
     
    <div class="container"><center>
    <div class="shadow-lg p-3 mb-5 bg-white rounded" id="admin">
        <p><div style="border: 1px overflow: auto; width: 80%; height:auto; text-align: center;"><br></p>
        <form action="insert_callcenter_process.php" method="post" name="form1" onSubmit="JavaScript:return fncSubmit();">
              
        <p><b><h4> สัญญากู้ยืมเงิน </h4></b></p>
        <p><b><h4> กองทุน ลภน.2 </h4></b></p>
        <hr class="my-4">

        <div class="text-right">
        <p><span style="padding-right:70px">วันเดือนปีที่กู้ยืมเงิน : <input type="datetime"  name="p_date_borrow"  id="p_date_borrow" class="form-control-sm" value="<?=date('Y-m-d H:i:s')?>" required readonly /></span></p>
        </div>

        
        <div class="text-left">
        <p><span style="padding-left:150px">สัญญาฉบับนี้ทำขึ้นเพื่อกู้ยืมเงินฉุกเฉิน สำหรับ Call Center & HD & SUP</p></div>

        
        <div class="text-left">
        <p><span style="padding-left:150px">
        <b>ข้อ 1.</b> ผู้กู้ได้กู้ยืมเงิน เป็นจำนวนเงิน : <input type="text" name="p_amount" id="p_amount" class="form-control-sm" onkeypress="javascript:return isNumber(event)" required>&ensp;บาท</p>
        

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
	      <p><span style="padding-right:30px">ลงชื่อ : <img src="..\signature\sign_image\<?php echo $row['Personnel_sign'] ?>" name="p_signature" width="170" alt="">
	      <p><span style="padding-right:70px"><input  name="p_signature2" id="p_signature2" class="form-control-sm" value="<?php echo $row['Personnel_FL_Name']; ?>" required readonly></p>
        <input type="hidden" name="p_position" id="p_signature2" value="<?php echo $row['Personnel_Position']; ?>">
	      <p><span style="padding-right:119px">ผู้กู้ยืมเงิน</p><br><br>
        </div>

        <div class="text-center">
        <button type="submit" class="btn btn-success" name="btnSubmit1" value="Submit" 
            onclick="if(confirm('ต้องการยื่นคำร้อง ยืนยัน?')) return true; else return false;">ยื่นคำร้อง</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-danger" href="\tot\06.employer\index.php" role="button" 
            onclick="if(confirm('ต้องการยกเลิก?')) return true; else return false;">ยกเลิก
            </a>
            </div>
          </div>
        </div>
        
  
    <script>
        // WRITE THE VALIDATION SCRIPT.
        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
        }
    </script>

    <script type="text/javascript">
    function not_number(e) {
      if(window.event){
          keynum = e.keyCode;
      }
      else if(e.which){
          keynum = e.which;
      }
      if ((keynum == 13 || keynum == 110) && (keynum > 48) || (keynum < 57)) {
         event.returnValue = false;
      }
    }
    </script>

  </body>
</html>
