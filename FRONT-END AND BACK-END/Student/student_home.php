<?php 
session_start();

if (!isset($_SESSION['student_login_id']))
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
<title>Student || Home Page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/student/student_home.css">
</head>
<body>
    <div style="height:100%;">
        <div class="side"> 
        </div>
        <div class="side2 border"> 
            <div class="main">   
              <form action="" method="POST">
                <div class="form-group pull-right search">
                    <input type="text" class="search form-control datasearch" placeholder="Search... " name="searchvalue"  required>
                    <button type="submit" class="btn btn-primary btnsearch" name="search">Search</button>
                    <a href="student_home.php" class="btn btn-warning ml-3">Reset</a>
              </form>  
              <a href="../logout.php" class="btn btn-info btn  p-2 ml-auto" style="width: 50px;"><i class="fas fa-sign-out-alt fa-lg"></i></a>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Exam</th>
                      <th>Exam Start Time</th>
                      <th>Exam Duration</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="jar">
                  <?php 
                  require('../database_connection.php');
                
                    $sql1 = "SELECT  exams.id AS id, exams.name AS name, exams.dateandtime AS dateandtime,exams.duration AS duration,student_has_exam.Examstatus AS Examstatus FROM mcqsystem.exams left join mcqsystem.student_has_exam on mcqsystem.exams.id = mcqsystem.student_has_exam.Exam_id and (mcqsystem.student_has_exam.student_id ='$_SESSION[student_login_id]' or mcqsystem.student_has_exam.student_id is null) where mcqsystem.exams.status = 'published'";  
                    if(isset($_POST['search'])){
                      $sql1="SELECT  exams.id AS id, exams.name AS name, exams.dateandtime AS dateandtime,exams.duration AS duration,student_has_exam.Examstatus AS Examstatus FROM mcqsystem.exams left join mcqsystem.student_has_exam on mcqsystem.exams.id = mcqsystem.student_has_exam.Exam_id and (mcqsystem.student_has_exam.student_id = 1 or mcqsystem.student_has_exam.student_id is null) where mcqsystem.exams.status = 'published' AND exams.name LIKE '%$_POST[searchvalue]%'";
                    }
                    $result1=mysqli_query($conn,$sql1);
                      while ($row=mysqli_fetch_array($result1))
                      {
                       echo"<tr class='content'>";
                       echo"<td>".$row['name']."</td>";
                       echo"<td>".$row['dateandtime']."</td>"; 
                       echo"<td>".$row['duration']."</td>"; 
                       if($row['Examstatus']==null){
                        echo"<td>".'<a href="SingleExam.php?id=' . $row['id'] . ' & status=' . $row['Examstatus'] . '">'.'pending'."</td>";
                       }else{
                        echo"<td>".'<a href="SingleExam.php?id=' . $row['id'] . ' & status=' . $row['Examstatus'] . '">'.$row['Examstatus']."</td>";
                       }  
                       echo"</tr>";
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
<script src="../assets/js/student/ParginationOfHomePage.js"></script>