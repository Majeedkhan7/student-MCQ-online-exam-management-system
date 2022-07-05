
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css" integrity="sha512-cyIcYOviYhF0bHIhzXWJQ/7xnaBuIIOecYoPZBgJHQKFPo+TOBA+BY1EnTpmM8yKDU4ZdI3UGccNGCEUdfbBqw==" crossorigin="anonymous" referrerpolicy="no-referrer" /><script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js" integrity="sha512-IZ95TbsPTDl3eT5GwqTJH/14xZ2feLEGJRbII6bRKtE/HC6x3N4cHye7yyikadgAsuiddCY2+6gMntpVHL1gHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<?php 
session_start();
require '../database_connection.php';

if (!isset($_SESSION['student_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}

$userdata="SELECT * FROM mcqsystem.students where user_login_id='$_SESSION[student_login_id]'";
$userresult=mysqli_query($conn,$userdata);
$userdetails=mysqli_fetch_assoc($userresult);


if(isset($_GET['error'])){
echo"<script>Swal.fire({
  title: 'Exam Time!',
  icon: 'warning',
  text: '$_GET[error]',
  confirmButtonText: 'OK',
   
  }).then((result) => {
  if (result.isConfirmed) {
    window.location.assign('student_home.php')
  } 
  })</script>";

}
 ?>
<nav class="shadow-sm navbar navbar-expand-lg navbar-light bg-ligh bg-white rounded">
  <a class="navbar-brand" href="#">SCHOOL MCQ ONLINE APPLICATION</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 
    <ul class="navbar-nav ml-auto">
    <div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link  dropdown-toggle-nocaret" href="#" role="button" data-toggle="dropdown"  aria-expanded="false">
							<img src="../assets/u.jpg" width="50" class="rounded-circle" alt="user avatar">
							<div class="user-info ps-3 ml-1">
								<p class="user-name mb-0"><?php echo $userdetails['name']; ?></p>
								<p class="designattion mb-0">Student</p>
							</div>
						</a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                    <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
             </div>
		  </div>
    </ul>
  </div>
</nav>


        <div class="side2 border"> 
            <div class="main">   
              <form action="" method="POST">
                <div class="form-group pull-right search">
                    <input type="text" class="search form-control datasearch" placeholder="Search... " name="searchvalue"  required>
                    <button type="submit" class="btn btn-primary btnsearch" name="search">Search</button>
                    <a href="student_home.php" class="btn btn-warning ml-3">Reset</a>
              </form>  
            
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
                      if(mysqli_num_rows($result1)>0)
                      {
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
                         echo" </tbody>
                         </table>
                         <nav class='bar'>
                           <ul class='pagination justify-content-center pagination-sm'>
                           </ul>
                       </nav> ";
                      
                      }else{
                        echo'<tr><td colspan="4" class="text-center">NO DATA AVAILABLE</td></tr>';
                        echo" </tbody></table>";
                      }
                    
                    ?>
                 
              </div>
        </div>
</body>
</html>
<script src="../assets/js/student/ParginationOfHomePage.js"></script>
