<?php
  session_start();
  error_reporting(0);
  if(isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):
    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $SS = $_SESSION['M_id'];

    $sql_1 = "SELECT * FROM `money`";
    $stmt_1 = $dbh->prepare($sql_1);

    $count1 = "SELECT count(*) FROM `money`";
    $result1 = $dbh->prepare($count1);
    $result1->execute();
    $money = $result1->fetchColumn();
    $i = 1;

    try
    {
      $stmt_1->execute();
    }
    catch (PDOException $e)
    {
      echo 'เกิดข้อผิดพลาด : ' . $e->getMessage();
    }
  else:
    header('Location:\tot\01.login\login.php');
  endif;
?>
<!DOCTYPE html>
<html>
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
    <link href="/tot/css/backtotop.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/datatables.min.css"/>
    <title>ยินดีต้อนรับ : <?php echo $_SESSION["Personnel_FL_Name"]; ?></title>
 
  </head>
  <body>
  <?php require(dirname(__FILE__).'/../main_menu/hry/hry_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

  <div class="container">
      <div class="shadow p-3 mb-5 bg-white rounded id="admin">
      <h4 style="text-align: center;">ข้อมูลโครงการวงเงินทั้งหมด</h4>
        <nav class="navbar navbar-light" style="">
          <p class="lead">โครงการวงเงินทั้งหมด จำนวน <span class="badge badge-danger"><?php echo $money ?></span> คน | <a href="/tot/03.hry/addmoney.php" class="badge badge-success">เพิ่มจำนวนวงเงินกู้ยืม</a></p>
        </nav>
      <table class="table table-responsive" id="myTable">
        <thead>
          <tr>
            <th>No.</th>
            <th>Project_code</th>
            <th>Project_Name</th>
            <th>Total_Limit</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
           ?>
           <tr>
            <th><center><?=$i++ ?></center></th>
            <td><center><?php echo $row['M_code']; ?></center></td>
             <td><center><?php echo $row['M_name']; ?></center></td>
             <td><center><?php echo $row['M_money']; ?></center></td>
             <td>
                  <center>
                      <a href="update_money.php?uid=<?php echo $M_id;?>" class="btn btn-warning">แก้ไข</a>
                      <a href="delete_money.php?uid=<?php echo $M_id;?>" class="btn btn-danger" onclick="if(confirm('ยืนยันการลบวงเงินในระบบ ยืนยัน?')) return true; else return false;">ลบ</a>
                    </center>
                  </td>
                </tr>
                <?php }
                  $dbh = null;
                ?>
              </tbody>
            </table>
    </div>
    <!-- Latest compiled and minified JavaScript -->
    <script src="\tot\assets\jquery\jquery.js"></script>
    <script src="\tot\assets\bootstrap\dist\js\bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/datatables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#myTable').DataTable();
    } );
    </script>

  </body>
</html>