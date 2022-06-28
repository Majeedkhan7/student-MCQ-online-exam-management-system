<?php 
session_start();

if (!isset($_SESSION['teacher_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Home || Page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/teachers_home.css">
</head>
<body>
    <div style="height:100%;">
        <div class="side"> 
        </div>
        <div class="side2 border"> 
            <div class="main">   
              <form action="" method="POST">
                <div class="form-group pull-right search">
                    <input type="text" class="search form-control datasearch" placeholder="Search..." name="searchvalue" required>
                    <button type="submit" class="btn btn-primary btnsearch" name="search">Search</button>
                    <a href="Teacher_home.php" class="btn btn-warning ml-3">Reset</a>
              </form>  
                    <a href="single_Exam.php" class="btn btn-success p-2 ml-auto">New Exam</a>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Exam</th>
                      <th>Laste Updated</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="jar">
                  <?php 
                  require('../database_connection.php');
                  $sql = "SELECT * FROM `exams` WHERE teacherid='$_SESSION[teacher_login_id]'";
                  if(isset($_POST['search'])){
                    $sql="SELECT * FROM `exams` WHERE teacherid='$_SESSION[teacher_login_id]' and name LIKE '%$_POST[searchvalue]%'";
                  }
                  $result=mysqli_query($conn,$sql);
                  if($result->num_rows > 0)
                  {
                     
                      while ($row=mysqli_fetch_array($result))
                      {
                       echo"<tr class='content'>";
                       echo"<td>".$row['name']."</td>";
                       echo"<td>".$row['updatedate']."</td>"; 
                       if($row['status']=='draft'){
                        echo"<td>".'<a href="single_Exam.php?id=' . $row['id'] . '">'.$row['status']."</td>";
                       }else{
                        echo"<td>".'<a href="monitorexam.php?id=' . $row['id'] . '">'.$row['status']."</td>";
                       }
                     
                       echo"</tr>";
                      }
                  }
                    ?>
                  </tbody>
                </table>
                <nav class="bar">
                  <ul class="pagination justify-content-center pagination-sm">
                  </ul>
              </nav>
              </div>
        </div>
    </div>
</body>
</html>
<script src="../assets/js/script.js"></script>
