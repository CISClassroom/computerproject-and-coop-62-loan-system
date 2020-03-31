<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['callcenter_username']) AND !empty($_SESSION['callcenter_password'])):
    require(dirname(__FILE__).'/../../tot/config/connect.php');

    date_default_timezone_set('Asia/Bangkok');
    
    $SS = $_SESSION["Personnel_FL_Name"]; 
    $SA = $_SESSION["Personnel_code"];

    $sql_1 = "SELECT * FROM `personnel`"
    . "LEFT JOIN petition "
    . "ON personnel.Personnel_FL_Name = petition.p_signature2 "
    . "WHERE  Personnel_FL_Name = '$SS'"
    . "ORDER BY p_code DESC";
    $stmt_1 = $dbh->prepare($sql_1);
    $row = $stmt_1->fetch(PDO::FETCH_ASSOC);
    
    $count1 = "SELECT count(*) FROM `petition` WHERE p_signature2 = '$SS'";
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
  <?php require(dirname(__FILE__).'/../main_menu/user/user_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

    <div class="container">
      <div class="shadow p-3 mb-5 bg-white rounded id="admin">
      <h3 style="text-align:center;">ประวัติการกู้ยืมทั้งหมด</h3>
        <nav class="navbar navbar-light" style="">
        <p class="lead">ประวัติการยืม จำนวน <span class="badge badge-danger"><?php echo $Personnel ?></span> ครั้ง | 
        <a href="\tot\06.employer\insert_form_callcenter.php?Personnel_code=<?php echo $SA;?>" class="badge badge-success">สัญญากู้ยืมเงิน</a></p>
        </nav>
      <table class="table table-responsive" id="myTable">
        <thead>
          <tr>
            <th>Number</th>
            <th>Personnel_code</th>
            <th>Name_of_Borrow</th>
            <th>Date_of_Borrow</th>
            <th>Amount</th>
            <th>Payment_Date</th>
            <th>Success_Status</th>
            <th>Detail_of_Borrow</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
                  extract($row)

           ?>
           <tr>
                  <td><center><?=$i++?></center></td>
                  <td scope="row"><center><?php echo $row['Personnel_code'] ?></center></td>
                  <td><center><?php echo $row['Personnel_FL_Name'] ?></center></td>
                  <td><center><?php echo $row['p_date_borrow'] ?></center></td>
                  <td><center><?php echo $row['p_amount'] ?></center></td>
                  <td><center><?php echo $row['payment_date'] ?></center></td>
                  
                  
                  <?php $FA = $row['p_status'] ?>
                  <?php if($row['p_status'] == "รอดำเนินการ")
                      echo "<td><b><center><font color='blue'> $FA</center></b></td>";
                      elseif($row['p_status'] == "อนุมัติเรียบร้อย")
                      echo "<td><b><center><font color='green'> $FA</center></b></td>";
                      elseif($row['p_status'] == "ค้างชำระ")
                      echo "<td><b><center><font color='red'> $FA</center></b></td>";
                      elseif($row['p_status'] == "ชำระเรียบร้อย")
                      echo "<td><b><center><font color='green'> $FA</center></b></td>";?>
                       <td>
                  <center>
                      <a href="detail.php?uid=<?php echo $p_code;?>" class="btn btn-warning">เพิ่มเติม</a>
                      <a href="delete_callcenter.php?uid=<?php echo $p_code;?>" class="btn btn-danger" 
                      onclick="if(confirm('ยืนยันการลบ?')) return true; else return false;">ลบ</a>
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



            
