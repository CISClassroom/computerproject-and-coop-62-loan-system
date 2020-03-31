<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $uid = $_GET['uid'];

    $stmt = $dbh->prepare("SELECT * FROM `personnel`"
                      . "WHERE Personnel_code = $uid");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    try
    {
      extract($row);

      $sql2 = "SELECT * FROM `personnel`";
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
    <title>แก้ไขข้อมูลบุคลากร</title>
  </head>
  <body>
  <?php require(dirname(__FILE__).'/../main_menu/user/user_menubar.php');?>
    <?php echo "<br><br><br>"; ?>
    <div class="container">
      <div class="shadow-lg p-3 mb-5 bg-white rounded">
        <h2 style="text-align:center;">แก้ไขข้อมูลบุคลากร</h2><br>
        <div class="container">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
              <form method="post" action="update_os_profile.php" name='form1' class="needs-validation" novalidate>
                <div class="form-row">

                  <input type="text" style="display: none;" class="form-control" id="Personnel_code" value="<?php echo $row['Personnel_code'] ?>" name="Personnel_code" required>

                  <div class="form-group col-md">
                    <label for="flname">ชื่อจริง-นามสกุล</label>
                    <input type="text" maxlength="255" class="form-control" id="flname" placeholder="กรอกชื่อจริง-นามสกุล" value="<?php echo $row['Personnel_FL_Name'] ?>" name="flname" required>
                    <div class="invalid-feedback">
                      กรุณากรอกชื่อจริง-นามสกุล!
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md">
                    <label for="Personnel_Position">ตำแหน่ง</label>
                      <input type="text" minlength="10" maxlength="10" class="form-control" id="position" placeholder="" value="<?php echo $row['Personnel_Position'] ?>" name="position" required readonly>
                    <div class="invalid-feedback">
                      กรุณาระบุตำแหน่ง!
                    </div>
                  </div>
                  <div class="form-group col-md">
                    <label for="tell">เบอร์โทรศัพท์มือถือ</label>
                    <input type="text" minlength="10" maxlength="10" class="form-control" id="tell" placeholder="กรอกเบอร์โทรศัพท์" value="<?php echo $row['Personnel_Phone'] ?>" name="tell" onkeypress="javascript:return isNumber(event)" required>
                    <div class="invalid-feedback">
                      กรุณากรอกเบอร์โทรศัพท์มือถือ!
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md">
                    <label for="username">ชื่อผู้ใช้ (username)</label>
                    <input type="text" minlength="6" maxlength="50" class="form-control" maxlength="20" id="username" placeholder="กรอกชื่อผู้ใช้ (username)" value="<?php echo $row['Personnel_Usermae'] ?>" name="username" required>
                    <div class="invalid-feedback">
                      กรุณากรอกชื่อผู้ใช้ (username) ให้มีความยาวเท่ากับหรือมากกว่า 6 ตัวอักษร!
                    </div>
                  </div>
                  <div class="form-group col-md">
                    <label for="password1">รหัสผ่าน</label>
                    <input type="password" minlength="6" maxlength="20" class="form-control" id="password1" placeholder="รหัสผ่าน" value="<?php echo $row['Personnel_Password'] ?>" name="password1" required>
                    <div class="invalid-feedback">
                      กรุณากรอกรหัสผ่านให้มีความยาวเท่ากับหรือมากกว่า 6 ตัวอักษร!
                    </div>
                  </div>
                  <div class="form-group col-md">
                    <label for="password2">ยืนยันรหัสผ่าน</label>
                    <input type="password" minlength="6" maxlength="20" class="form-control" id="password2" placeholder="ยืนยันรหัสผ่าน" value="<?php echo $row['Personnel_Password'] ?>" name="password2" required>
                    <div class="invalid-feedback">
                      กรุณายืนยันรหัสผ่านให้มีความยาวเท่ากัน!
                    </div>
                  </div>
                </div>

                <div class="float-sm-right">
                  <div class="form-row">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success" name="submit" value="Edit Now" onclick="if(confirm('ยืนยันการแก้ไขข้อมูล?')) return true; else return false;">บันทึก</button>
                      <a class="btn btn-danger" href="\tot\06.employer\callcenter_profile.php" role="button" onclick="if(confirm('ต้องการยกเลิก?')) return true; else return false;">ยกเลิก</a>
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

    <script type="text/javascript">
    (function() {
      'use strict';
      window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
      if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
      }
      form.classList.add('was-validated');
      }, false);
      });
      }, false);
      })();
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

    <!-- ..........................เช็คการกรอก Username ภาษาอังกฤษ.............................. -->
    <script type="text/javascript">
    $(function(){
      $("#username").keypress(function(event){
          var ew = event.which;
          if(ew == 32)
              return true;
          if(48 <= ew && ew <= 57)
              return true;
          if(65 <= ew && ew <= 90)
              return true;
          if(97 <= ew && ew <= 122)
              return true;
          return false;
      });
    });
    </script>

    <!-- ..........................เช็คการกรอก Password ภาษาอังกฤษ.............................. -->
    <script type="text/javascript">
    $(function(){
      $("#password1").keypress(function(event){
          var ew = event.which;
          if(ew == 32)
              return true;
          if(48 <= ew && ew <= 57)
              return true;
          if(65 <= ew && ew <= 90)
              return true;
          if(97 <= ew && ew <= 122)
              return true;
          return false;
      });
    });
    </script>

    <!-- ..........................เช็คการ ยืนยัน Password ภาษาอังกฤษ.............................. -->
    <script type="text/javascript">
    $(function(){
      $("#password2").keypress(function(event){
          var ew = event.which;
          if(ew == 32)
              return true;
          if(48 <= ew && ew <= 57)
              return true;
          if(65 <= ew && ew <= 90)
              return true;
          if(97 <= ew && ew <= 122)
              return true;
          return false;
      });
    });
    </script>

    <!-- ..........................เช็คการกรอกเฉพาะตัวเลข.............................. -->
    <script>
        // WRITE THE VALIDATION SCRIPT.
        function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
        }
    </script>

  </body>
</html>
