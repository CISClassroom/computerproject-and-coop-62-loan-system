<?php
session_start();
error_reporting(0);

   /* else{
      //$update = "INSERT INTO petition (p_sign,m_approve) VALUES ('".$p_sign."','".$m_approve."')";
      $update2 = "UPDATE petition SET p_sign='$signatureFileName' WHERE m_approve='$fullname' AND p_sign='$fullname'";
      if(mysqli_query($dbh,$update2)){
        echo "<script language='javascript' type='text/javascript'> alert('บันทึกลายเซ็นของคุณเรียบร้อยแล้ว');window.location='project_detail3.php';</script>";
                //echo $update;
      }else{
        echo "Error".mysqli_error($dbh);
      }
    }
    */

  /*  $update = "UPDATE personnel SET Personnel_sign = '$signatureFileName' WHERE Personnel_FL_name = '$fullname'";
		if(mysqli_query($dbh,$update))
		{
			echo "<script language='javascript' type='text/javascript'> alert('บันทึกลายเซ็นของคุณเรียบร้อยแล้ว');  window.history.back(); </script>";          
		}else{
			echo "Error".mysqli_error($dbh);
    }
    
  
    if($customer == ""){
      $insert = "UPDATE petition SET m_approve = '$signatureFileName' WHERE m_approve2 = '$fullname'";
      if($query = mysqli_query($dbh,$insert))
      {
        echo "<script language='javascript' type='text/javascript'> alert('บันทึกลายเซ็นของคุณเรียบร้อยแล้ว'); </script>";  
      }
      else{
        echo "Error".mysqli_error($dbh);
      }
    }
    */

    //$insert = "INSERT INTO signature1(signature_personnel,signature_name,signature_position,signature_img,dateadd,status) VALUE ('$code','$name','$position','$signatureFileName','$dateadd',1)";
    //$query = mysqli_query($dbh,$update) or die(mysql_error());
  
?>


<?php
  session_start();
  error_reporting(0);
  if( isset($_SESSION['username']) AND !empty($_SESSION['password'])):

    require(dirname(__FILE__).'/../../tot/config/connect.php');

    $Personnel_code = $_SESSION["Personnel_code"];

    $stmt = $dbh->prepare("SELECT * FROM `personnel`"
                      . "WHERE Personnel_code = $Personnel_code");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        #canvasDiv{
	position: relative;
	border: 1px dashed grey;
	height: 250px;
        }
    </style>
    <title>แบบฟอร์มวาดลายเซ็น</title>
  </head>
  
  <?php
   $customer = "$customer";
  ?>

<body>
<?//php require(dirname(__FILE__).'/../main_menu/user/user_menubar.php');?>
<?php echo "<br><br><br>"; ?>
<div class="container">
      <div class="shadow-lg p-3 mb-5 bg-white rounded">
        <h2 style="text-align:center;">เพิ่มลายเซ็น</h2><br>
        <div class="container">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

            <form id="signatureform" action="signature_db.php"  method="post">
            <div class="form-row">

            <input type="text" style="display: none;" class="form-control" id="Personnel_code" value="<?php echo $row['p_code'] ?>" name="p_code" required>
            
                  <div class="form-group col-md">
                  <label for="code">รหัสพนักงาน</label>
                    <input type="text" minlength="8" maxlength="10" class="form-control" id="code" placeholder="กรอกรหัสพนักงาน" value="<?php echo $row['Personnel_code'] ?>" name="code" required readonly>
                  </div>
                  <div class="form-group col-md">
                  <label for="fullname">ชื่อ-นามสกุล</label>
                    <input type="text" minlength="8" maxlength="10" class="form-control" id="fullname" placeholder="กรอก" value="<?php echo $row['Personnel_FL_Name'] ?>" name="fullname" required readonly>
                  </div>

                  <div class="form-group col-md">
                  <label for="position">ชื่อ-นามสกุล</label>
                    <input type="text" minlength="8" maxlength="10" class="form-control" id="position" placeholder="กรอก" value="<?php echo $row['Personnel_Position'] ?>" name="position" required readonly>
                  </div>
               
                <input type="hidden" id="signature" name="signature">
                <input type="hidden" name="signaturesubmit" value="1">
                <input type="hidden" name="customer" value="<?php echo $customer; ?>">
                </div>
          

               
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <?php echo isset($msg)?$msg:''; ?>
                <label>พื้นที่วาดลายเซ็น</label>
              <div id="canvasDiv"></div>
                <br><div class="float-sm-right">
                  <div class="form-row">
                    <div class="form-group">
                    <a href="javascript:history.back()" class="btn btn-warning">ย้อนกลับ</a>
                    <button type="button" class="btn btn-danger" id="reset-btn">ล้างข้อมูล</button>
                    <button type="button" class="btn btn-success" id="btn-save">บันทึก</button>
                    </div>
                  </div>
                </div>
          </div>
        </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </form>

</body>
<script src="js/jquery-3.4.1.slim.min.js" ></script>
<script src="js/html2canvas.min.js"></script>
<script>
    $(document).ready(() => {
        var canvasDiv = document.getElementById('canvasDiv');
        var canvas = document.createElement('canvas');
        canvas.setAttribute('id', 'canvas');
        canvasDiv.appendChild(canvas);
        $("#canvas").attr('height', $("#canvasDiv").outerHeight());
        $("#canvas").attr('width', $("#canvasDiv").width());
        if (typeof G_vmlCanvasManager != 'undefined') {
            canvas = G_vmlCanvasManager.initElement(canvas);
        }
        
        context = canvas.getContext("2d");
        $('#canvas').mousedown(function(e) {
            var offset = $(this).offset()
            var mouseX = e.pageX - this.offsetLeft;
            var mouseY = e.pageY - this.offsetTop;

            paint = true;
            addClick(e.pageX - offset.left, e.pageY - offset.top);
            redraw();
        });

        $('#canvas').mousemove(function(e) {
            if (paint) {
                var offset = $(this).offset()
                //addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                addClick(e.pageX - offset.left, e.pageY - offset.top, true);
                console.log(e.pageX, offset.left, e.pageY, offset.top);
                redraw();
            }
        });

        $('#canvas').mouseup(function(e) {
            paint = false;
        });

        $('#canvas').mouseleave(function(e) {
            paint = false;
        });

        var clickX = new Array();
        var clickY = new Array();
        var clickDrag = new Array();
        var paint;

        function addClick(x, y, dragging) {
            clickX.push(x);
            clickY.push(y);
            clickDrag.push(dragging);
        }

        $("#reset-btn").click(function() {
            context.clearRect(0, 0, window.innerWidth, window.innerWidth);
            clickX = [];
            clickY = [];
            clickDrag = [];
        });

        $(document).on('click', '#btn-save', function() {
            var mycanvas = document.getElementById('canvas');
            var img = mycanvas.toDataURL("image/png");
            anchor = $("#signature");
            anchor.val(img);
            $("#signatureform").submit();
            if(img == "")
            {
                alert("กรุณาวาดลายเซ็น");
            }
        });

                    
        var drawing = false;
        var mousePos = {
            x: 0,
            y: 0
        };
        var lastPos = mousePos;

        canvas.addEventListener("touchstart", function(e) {
            mousePos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);


        canvas.addEventListener("touchend", function(e) {
            var mouseEvent = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(mouseEvent);
        }, false);


        canvas.addEventListener("touchmove", function(e) {

            var touch = e.touches[0];
            var offset = $('#canvas').offset();
            var mouseEvent = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);



        // Get the position of a touch relative to the canvas
        function getTouchPos(canvasDiv, touchEvent) {
            var rect = canvasDiv.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }


        var elem = document.getElementById("canvas");

        var defaultPrevent = function(e) {
            e.preventDefault();
        }
        elem.addEventListener("touchstart", defaultPrevent);
        elem.addEventListener("touchmove", defaultPrevent);


        function redraw() {
            //
            lastPos = mousePos;
            for (var i = 0; i < clickX.length; i++) {
                context.beginPath();
                if (clickDrag[i] && i) {
                    context.moveTo(clickX[i - 1], clickY[i - 1]);
                } else {
                    context.moveTo(clickX[i] - 1, clickY[i]);
                }
                context.lineTo(clickX[i], clickY[i]);
                context.closePath();
                context.stroke();
            }
        }
    })

</script>
</html>