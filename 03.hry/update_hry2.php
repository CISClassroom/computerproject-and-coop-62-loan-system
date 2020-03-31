<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');


    $uid = $_GET['p_code'];

    $stmt = $dbh->prepare("SELECT * FROM `petition`"
                      . "WHERE p_code = $uid");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    try
    {
      extract($row);

      $sql2 = "SELECT * FROM petition";
      $stmt2 = $dbh->prepare($sql2);
      $stmt2->execute();
      //$branch = $stmt2->fetchAll();
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
    <title>แก้ไขข้อมูลบุคลากร</title>
  </head>
  <body>
  <?php require(dirname(__FILE__).'/../main_menu/hry/hry_menubar.php');?>
    <?php echo "<br><br><br>"; ?>
    <div class="container">
      <div class="shadow-lg p-3 mb-5 bg-white rounded">
        <h2 style="text-align:center;">แก้ไขข้อมูลการชำระเงิน</h2><br>
        <div class="container">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
              <form method="post" action="update_hry_process2.php" name='form1' class="needs-validation" novalidate>
                <div class="form-row">

                  <input type="text" style="display: none;" class="form-control" id="Personnel_code" value="<?php echo $row['p_code'] ?>" name="p_code" required>

                  <div class="form-group col-md">
                    <label for="flname">ชื่อจริง-นามสกุล</label>
                    <input type="text" maxlength="255" class="form-control" id="flname" placeholder="กรอกชื่อจริง-นามสกุล" value="<?php echo $row['p_signature2'] ?>" name="flname" required readonly>
                    <div class="invalid-feedback">
                      กรุณากรอกชื่อจริง-นามสกุล!
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md">
                    <label for="">สถานะ</label>
                    <select id="position" class="form-control selectpicker" data-live-search="true" name="p_status" required >
                      <option>ชำระเรียบร้อย</option>
                    </select>
                    
                  </div>
                  <div class="form-group col-md">
                    <label for="">ตำแหน่ง</label>
                    <input type="text" minlength="10" maxlength="10" class="form-control" id="tell" placeholder="เลือกสถานะการยืม" value="<?php echo $row['p_position'] ?>" name="tell" onkeypress="javascript:return isNumber(event)" required readonly>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md">
                    <label for="username">จำนวนเงิน</label>
                    <input type="text" minlength="8" maxlength="50" class="form-control" maxlength="20" id="username" value="<?php echo $row['p_amount'] ?>" name="p_amount" required readonly>
                    
                    <label for="username">วันที่อนุมัติ<abel>
                    <input type="text" minlength="8" maxlength="50" class="form-control" maxlength="20" id="username" value="<?php echo $row['p_date_approve'] ?>" name="username" required readonly>
                    
                  </div>
                  <div class="form-group col-md">
                    <label for="password1">วันที่กู้ยืม</label>
                    <input type="text" minlength="6" maxlength="20" class="form-control" id="password1"  value="<?php echo $row['p_date_borrow'] ?>" name="password1" required readonly>
                    
                    <label for="username">ลายเซนต์ผู้อนุมัติ</label>
                    <input type="text" minlength="8" maxlength="50" class="form-control" maxlength="20" id="username" value="<?php echo $row['m_approve'] ?>" name="username" required readonly>
                    
                  </div>
                  <div class="form-group col-md">
                    <label for="password2">ลายเซนต์ผู้กู้</label>
                    <input type="text" minlength="6" maxlength="20" class="form-control" id="password2" value="<?php echo $row['p_signature'] ?>" name="password2" required readonly>
                    
                    <label for="">วันที่ชำระเงิน</label>
                    <input type="date" minlength="8" maxlength="50" class="form-control" maxlength="20" id="username" name="payment_date" value="<?=date('Y-m-d')?>" required readonly>
                  </div>
                </div>


                <div class="float-sm-right">
                  <div class="form-row">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success" name="submit" value="Edit Now" onclick="if(confirm('ยืนยันการชำระเงิน ยืนยัน?')) return true; else return false;">บันทึก</button>
                      <a class="btn btn-danger" href="\tot\03.hry\index.php" role="button" onclick="if(confirm('ต้องการยกเลิก?')) return true; else return false;">ยกเลิก</a>
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="col-2"></div>
          </div>
        </div>
      </div>
    </div>

    <?php require(dirname(__FILE__).'/../main_menu/footer.html');?>

    <script src="\tot\assets\jquery\jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="/tot/js/jquery.datetimepicker.full.js"></script>
    <script src="/tot/js/accounting.min.js"></script>


  </body>
</html>
