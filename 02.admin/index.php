<?php
  session_start();
  error_reporting(0);
  if(isset($_SESSION['admin_username']) AND !empty($_SESSION['admin_password'])):
    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $sql_1 = "SELECT * FROM `personnel`";
    $stmt_1 = $dbh->prepare($sql_1);

    $count1 = "SELECT count(*) FROM `personnel`";
    $result1 = $dbh->prepare($count1);
    $result1->execute();
    $Personnel = $result1->fetchColumn();
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
  <?php require(dirname(__FILE__).'/../main_menu/admin/admin_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

  <div class="container">
      <div class="shadow p-3 mb-5 bg-white rounded id="admin">
      <h1 style="text-align: center;">จัดการข้อมูลพนักงาน</h1>
        <nav class="navbar navbar-light" style="">
          <p class="lead">รายชื่อพนักงานทั้งหมด จำนวน <span class="badge badge-danger"><?php echo $Personnel ?></span> คน | <a href="/tot/02.admin/insert_user.php" class="badge badge-success">เพิ่มบุคลากร</a></p>
        </nav>
      <table class="table table-responsive" id="myTable">
        <thead>
          <tr>
            <th>No.</th>
            <th>Personnel_code</th>
            <th>Personnel_FL_Name</th>
            <th>Position</th>
            <th>Number_Phone</th>
            <th>Useranme</th>
            <th>Option</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
           ?>
           <tr>
            <th><center><?=$i++ ?></center></th>
             <td><center><?php echo $row['Personnel_code']; ?></center></td>
             <td><center><?php echo $row['Personnel_FL_Name']; ?></center></td>
             <td><center><?php echo $row['Personnel_Position']; ?></center></td>
             <td><center><?php echo $row['Personnel_Phone']; ?></center></td>
             <td><center><?php echo $row['Personnel_Usermae']; ?></center></td>
             <td>
              <center>
                <a href="update_user.php?uid=<?php echo $Personnel_code;?>" class="btn btn-warning">แก้ไข</a>
                <a href="delete_user_process.php?uid=<?php echo $Personnel_code;?>" class="btn btn-danger" onclick="if(confirm('ยืนยันการลบ?')) return true; else return false;">ลบ</a>
              </center>
            </td>
          </tr>
         <?php }
        $dbh = null;
        ?>
      </tbody>
     </table>
    </div>
    
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