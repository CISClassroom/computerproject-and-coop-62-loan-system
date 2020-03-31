<?php
 session_start();
 error_reporting(0);
 if(isset($_SESSION['admin_username']) AND !empty($_SESSION['admin_password'])):
   require(dirname(__FILE__).'/../../tot/config/connect.php');
  
   $sql_1 = "SELECT * FROM `petition`";
    $stmt_1 = $dbh->prepare($sql_1);

    $count1 = "SELECT count(*) FROM `petition`";
    $result1 = $dbh->prepare($count1);
    $result1->execute();
    $count_Project1 = $result1->fetchColumn();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <title>ยินดีต้อนรับ : <?php echo $_SESSION["Personnel_FL_Name"]; ?></title>
  </head>
  <body>
  <?php require(dirname(__FILE__).'/../main_menu/admin/admin_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

    <div class="container"><center>
      <div class="shadow p-3 mb-5 bg-white rounded id="admin">
      <b><h3 style="text-align: center;">ประวัติการกู้ยืมทั้งหมด</h3></b>

        <nav class="navbar navbar-light" style="">
        <p class="lead">ประวัติการกู้ยืมทั้งหมด จำนวน <span class="badge badge-danger"><?php echo $count_Project1 ?></span> ครั้ง | 
        <table class="table table-responsive" id="myTable">
        <thead>
          <tr>
            <th>No.</th>
            <th>Personnel_code</th>
            <th>Name_of_Borrow</th>
            <th>Position</th>
            <th>Date_of_Borrow</th>
            <th>Amount</th>
            <th>Success_Status</th>
         
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
  
           ?>
           <tr>
                  <td><center><?=$i++?></center></td>
                  <td><center><?php echo $row['personnel_code'] ?></center></td>
                  <td><center><?php echo $row['p_signature2'] ?></center></td>
                  <td><center><?php echo $row['p_position'] ?></center></td>
                  <td><center><?php echo $row['p_date_borrow'] ?></center></td>
                  <td><center><?php echo $row['p_amount'] ?></center></td>
              
                  

                  <?php $FA = $row['p_status'] ?>
                  <?php if($row['p_status'] == "รอดำเนินการ")
                      echo "<td><b><center><font color='blue'> $FA</center></b></td>";
                      elseif($row['p_status'] == "อนุมัติเรียบร้อย")
                      echo "<td><b><center><font color='green'> $FA</center></b></td>";
                      elseif($row['p_status'] == "ค้างชำระ")
                      echo "<td><b><center><font color='red'> $FA</center></b></td>";
                      elseif($row['p_status'] == "ชำระเรียบร้อย")
                      echo "<td><b><center><font color='orange'> $FA</center></b></td>";?>
                      
                      
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



            
