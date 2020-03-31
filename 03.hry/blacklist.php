<?php
 session_start();
 error_reporting(0);
 if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):
   require(dirname(__FILE__).'/../../tot/config/connect.php');
  
   $sql_1 = "SELECT * FROM `petition` WHERE p_status='ค้างชำระ'  ORDER BY p_code ASC";
   $stmt_1 = $dbh->prepare($sql_1);

   $count1 = "SELECT count(*) FROM `petition` WHERE p_status ='ค้างชำระ'";
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
    <title>ยินดีต้อนรับ : <?php echo $_SESSION["Personnel_FL_Name"]; ?></title>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/datatables.min.css"/>
    </head>
      <body>
        <?php require(dirname(__FILE__).'/../main_menu/hry/hry_menubar.php');?>
        <?php echo "<br><br><br>"; ?>
  
    <div class="container">
      <div class="shadow-lg p-3 mb-5 bg-white rounded" id="admin">
      <b><h3 style="text-align: center;">รายชื่อพนักงานที่ติดแบล็กลิสต์</h3></b>
        <nav class="navbar navbar-light" style="">
        <p class="lead">รายชื่อพนักงานที่ติดแบล็กลิสต์ จำนวน <span class="badge badge-danger"><?php echo $Personnel ?></span> ครั้ง
        <table class="table table-responsive" id="myTable">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name_of_Borrow</th>
            <th>Position</th>
            <th>Amount</th>
            <th>Date_of_Borrow</th>
            <th>Status</th>
            <th>Total_Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php  while ($data = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
            extract($data);
           ?>

                    <?php $daylast = $data['p_date_approve2'];
                      $return_date = $daylast;//วันที่กำหนดส่งคืน
                      $today = date('Y-m-d');//วันที่ปัจจุบัน
                    
                      $time_today = strtotime($today);     //แปลงวันที่ส่งคืนจริง เป็นตัวเลข timestamp
                      $time_return = strtotime($return_date);    //แปลงวันที่กำหนดส่งคืน เป็นตัวเลข timestamp
                      $day_late_qty = ($time_today - $time_return) / ( 60 * 60 * 24 );
                    ?>

                  <tr>
                  <?php 
                      if($day_late_qty >= 1){
                        echo "<th><center>".$i++."</center></th>";
                        echo "<td><center>".$data['p_signature2']."</center></td>";
                        echo "<td><center>".$data['p_position']."</center></td>";
                        echo "<td><center>".$data['p_amount']."</center></td>";
                        echo "<td><center>".$data['p_date_borrow']."</center></td>";
                        echo "<td><center><b><font color='red'>".$data['p_status']."</b></center></td>"; 
                        echo "<td><center><b><font color='red'>".$day_late_qty."</b></center></td>"; 
                        echo "<td>";
                        echo "<center>";
                          $p_code1 = $data['p_code'];
                            echo " <a href='update_hry2.php?p_code=".$p_code1."' class='btn btn-warning'>เพิ่มเติม</a>";
                        echo "</center>";
                        echo " </td> "; 
                      }
                      ?>
                    </tr>
           <?php } ?>
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