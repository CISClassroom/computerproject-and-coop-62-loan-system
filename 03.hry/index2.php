<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['Account_username']) AND !empty($_SESSION['Account_password'])):
    require(dirname(__FILE__).'/../../tot/config/connect.php');
    $SA = $_SESSION['Personnel_FL_Name'];
    
    try
    {
      $sql = "SELECT * FROM `money`";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      $money = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql_1 = "SELECT * FROM `petition` WHERE p_status='ค้างชำระ'  ORDER BY p_code ASC";
      $stmt_1 = $dbh->prepare($sql_1);
      $stmt_1->execute();

      $count1 = "SELECT count(*) FROM `petition` WHERE  p_status='ค้างชำระ'";
      $result1 = $dbh->prepare($count1);
      $result1->execute();
      $count_Project = $result1->fetchColumn();
    $i = 1;
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
  <?php require(dirname(__FILE__).'/../main_menu/hry/hry_menubar.php');?>
    <?php echo "<br><br><br>"; ?>

    <div class="container">
      <div class="shadow p-3 mb-5 bg-white rounded id="admin">
      <h3 style="text-align: center;">รายละเอียดการกู้ยืมพนักงานที่ค้างชำระ</h3>
          <p class="lead">รายชื่อพนักงานที่ค้างชำระ จำนวน <span class="badge badge-success"><?php echo $count_Project ?></span> คน 
            <table class="table table-responsive" id="myTable">
            <thead>
            <tr>
                  <th>ID</th>
                  <th>Name_of_Borrow</th>
                  <th>Position</th>
                  <th>Date_of_Borrow</th>
                  <th>Amount</th>
                  <th>Success_Status</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $stmt_1->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                ?>
                <tr>
                  <th><?=$i++?></th>
                  <td><center><?php echo $row['p_signature2'] ?></center></td>
                  <td><center><?php echo $row['p_position'] ?></center></td>
                  <td><center><?php echo $row['p_date_borrow'] ?></center></td>
                  <td><center><?php echo $row['p_amount'] ?></center></td>
                  <td><b><center><font color='red'><?php echo $row['p_status'] ?></span></center></b></td>
                  <td>
                    <center>
                    <center>
                      <a href="update_hry2.php?p_code=<?php echo $row['p_code'];?>" class="btn btn-warning">แก้ไข</a>
                    </center>
                    </center>
                  </td>
                </tr>
                <?php };
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
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

            
