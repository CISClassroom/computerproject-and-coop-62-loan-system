<?php
 session_start();
 error_reporting(0);
 if(isset($_SESSION['admin_username']) AND !empty($_SESSION['admin_password'])):
   require(dirname(__FILE__).'/../../tot/config/connect.php');
  
   $sql_2 = "SELECT * FROM `petition` WHERE p_status = 'ชำระเรียบร้อย' ORDER BY p_code ASC";
   $stmt_2 = $dbh->prepare($sql_2);

   $count2 = "SELECT count(*) FROM `petition` WHERE p_status ='ชำระเรียบร้อย'";
   $result2 = $dbh->prepare($count2);
   $result2->execute();
   $count_Project2 = $result2->fetchColumn();  
   $i = 1;

   try
   {
     $stmt_2->execute();
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
    <link href="/tot/css/backtotop.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/datatables.min.css"/>
    <title>ยินดีต้อนรับ : <?php echo $_SESSION["Personnel_FL_Name"]; ?></title>
  </head>
  <body>
  <?php require(dirname(__FILE__).'/../main_menu/admin/admin_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

    <div class="container"><center>
      <div class="shadow p-3 mb-5 bg-white rounded id="admin">
      <b><h3 style="text-align: center;">รายชื่อพนักงานที่ชำระเงินเสร็จเรียบร้อย</h3></b>

        <nav class="navbar navbar-light" style="">
        <p class="lead">ประวัติการที่ชำระเงินเสร็จเรียบร้อย จำนวน <span class="badge badge-danger"><?php echo $count_Project2 ?></span> ครั้ง
        <table class="table table-responsive" id="myTable">
        <thead>
          <tr>
            <th>Number</th>
            <th>Personnel_code</th>
            <th>Name_of_Borrow</th>
            <th>Date_Borrow</th>
            <th>Amount</th>
            <th>Payment_Date</th>
            <th>Success_Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt_2->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
  
           ?>
           <tr>
                  <td><center><?=$i++?></center></td>
                  <td><center><?php echo $row['personnel_code'] ?></center></td>
                  <td><center><?php echo $row['p_signature2'] ?></center></td>
                  <td><center><?php echo $row['p_date_borrow'] ?></center></td>
                  <td><center><?php echo $row['p_amount'] ?></center></td>
                  <td><center><?php echo $row['payment_date'] ?></center></td>
                  <td><b><font color='orange'><center><?php echo $row['p_status'] ?></center></b></td>
                </tr>
                <?php }
                  $dbh = null;
                ?>
              </tbody>
            </table>
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



            
