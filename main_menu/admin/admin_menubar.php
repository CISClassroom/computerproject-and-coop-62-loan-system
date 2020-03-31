
<?php
  require(dirname(__FILE__).'/../../../tot/config/connect.php');
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top font-weight-bold" 
style="background-color: #8B8970;">
    <a class="navbar-brand text-warning" href="\tot\02.admin\index.php">
        <img src="\tot\img\totlogo.png" width="65" height="34" class="d-inline-block align-top" alt=""> 
        <span class="text-white">Administrator TOT</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent"> <!-- เอาไว้ใส่เมนูบาร์ -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> จัดการข้อมูล
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="\tot\02.admin\index.php">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> ข้อมูลส่วนตัว
                </a>
              </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> ข้อมูลการกู้ยืมทั้งหมด
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="\tot\02.admin\loan.php">
                  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> ประวัติการกู้ยืม
                </a>
                <a class="dropdown-item" href="\tot\02.admin\payment.php">
                  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> ประวัติการชำระเงิน
                </a>
                <a class="dropdown-item" href="\tot\02.admin\blacklist.php">
                  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> รายชื่อพนักงานแบล็กลิสต์
                </a>
              </div>
            </li>

          </ul>
          <form class="form-inline my-2 my-lg-0">
            <ul class="navbar-nav mr-auto">
              <a class="nav-item nav-link active"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
              <?php echo $_SESSION["Personnel_Position"] ?> : <?php echo $_SESSION["Personnel_FL_Name"] ?>
              </a>
              <a class="btn btn-danger font-weight-bold" href="\tot\01.login\logout.php" onclick="if(confirm('ออกจากระบบ ยืนยัน?')) return true; else return false;">
                  <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> ออกจากระบบ
              </a>
            </ul>
          </form>
    </div>
</nav>