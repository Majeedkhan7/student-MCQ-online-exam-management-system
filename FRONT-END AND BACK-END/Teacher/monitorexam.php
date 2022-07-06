<?php 
session_start();
//include database connection
require '../database_connection.php'; 

//teacher auth
if (!isset($_SESSION['teacher_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}

//End The Exam
if(isset($_GET['delete'])){
    $exid=$_GET['delete'];
    $deleteanswers="DELETE FROM `answers` WHERE exam_id='$exid'";
    $deleteexam="DELETE FROM `exams` WHERE id='$exid'";
    $deletequestion="DELETE question,options FROM question LEFT JOIN options ON question.id=options.questionId WHERE question.examid='$exid' or question.examid is null";
    $deleteresult="DELETE FROM `student_has_exam` WHERE Exam_id='$exid'";
    if (($conn->query($deleteanswers) === TRUE) && ($conn->query($deleteexam) === TRUE) && ($conn->query($deletequestion) === TRUE) && ($conn->query($deleteresult) === TRUE) ){
    
        header("Location:Teacher_home.php");
      } else {
        echo "Error deleting record: " . $conn->error;
      }  
  }
//get the Exam detals using get Method
if(isset($_GET['id'])){
    $sql="SELECT * FROM `exams` WHERE id='$_GET[id]'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();   
      $_SESSION['duration']=$row['duration'];
      $_SESSION['start_time']=$row['dateandtime'];
      
    } 
  }
//calculate Number of student
$noofstudent=0;
$countstudent="SELECT COUNT(id)FROM `students`";
$CountStudentResult=mysqli_query($conn,$countstudent);
if($CountStudentResult->num_rows>0){
    $studentdata=$CountStudentResult->fetch_assoc();
    $noofstudent=$studentdata['COUNT(id)'];
} 
//Calculate no atten student
$NoAttenStudents=0;
$Query="SELECT COUNT(id) FROM `student_has_exam` WHERE Exam_id='$_GET[id]'";
$QueryResult=mysqli_query($conn,$Query);
if($QueryResult->num_rows>0){
    $AttenData=$QueryResult->fetch_assoc();
    $NoAttenStudents=$AttenData['COUNT(id)'];
}

//include the asia time 
date_default_timezone_set('Asia/Kolkata');
//Calculate Exam End time And save into seesion
$end_time=date(' Y-m-d H:i:s',strtotime('+'.$_SESSION["duration"].'minute',strtotime($_SESSION["start_time"])));
$_SESSION["end_time"]=$end_time;


$userdata="SELECT * FROM mcqsystem.teachers where user_login_id='$_SESSION[teacher_login_id]'";
$userresult=mysqli_query($conn,$userdata);
$userdetails=mysqli_fetch_assoc($userresult);
?>

<script>

//<========   This Call for Time Count =====> 
var countDownDate = <?php echo strtotime($_SESSION["end_time"]) ?> * 1000;
var now = <?php echo time() ?> * 1000;

// Update the count down every 1 second
var x = setInterval(function() {
now = now + 1000;
// Find the distance between now an the count down date
var distance = countDownDate - now;
// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
// Output the result in an element with id="demo"



<?php
    $date_now=strtotime(date('Y-m-d h:i:sa'));
    $startdate=strtotime($_SESSION['start_time']);
    $startdatetime=$_SESSION['start_time'];
    $end_time=$end_time=date(' Y-m-d H:i:s',strtotime('+'.$_SESSION["duration"].'minute',strtotime($_SESSION["start_time"])));
    $end_time=strtotime($end_time);

 if ($date_now > $startdate) {
    if($date_now > $end_time){
       
    }else{
  echo ' document.getElementById("time").innerHTML ="Timeleft :"+" "+ days + "d " + hours + "h " +
minutes + "m " + seconds + "s "';
    }


  
}else{
  
}
?>


// If the count down is over, write some text 
if (distance < 0) {
clearInterval(x);
 document.getElementById("time").innerHTML = "TIME END";
}   
}, 1000);
</script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Tachers || monitor exam page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/Teacher/monitorexam.css">
<body>
<nav class="shadow-sm navbar navbar-expand-lg navbar-light bg-ligh bg-white rounded">
  <a class="navbar-brand" href="#">SCHOOL MCQ ONLINE APPLICATION</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="navbar-nav align-items-center">
        <li class="nav-item ">
          <a class="nav-link" href="dashboard.php">Dashboard </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="student_home.php">Exams<span class="sr-only">(current)</span></a>
        </li>
      </ul>
    <ul class="navbar-nav ml-auto">
    <div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link  dropdown-toggle-nocaret" href="#" role="button" data-toggle="dropdown"  aria-expanded="false">
							<img src="../assets/u.jpg" width="50" class="rounded-circle" alt="user avatar">
							<div class="user-info ps-3 ml-1">
								<p class="user-name mb-0"><?php echo $userdetails['name']; ?></p>
								<p class="designattion mb-0">Teacher</p>
							</div>
						</a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                    <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
             </div>
		  </div>
    </ul>
  </div>
</nav> 
            <div class="side2 border" style="height:631.2px;">
                <div class="examname">
                    <a href="Teacher_home.php" class="mt-1"><i class="fas fa-chevron-left fa-2x"></i></a>
                    <h3 class="ml-2"><?php echo $row['name'];?></h3>
                </div>
                <div class="w-90 d-flex flex-row main">   
                    <div class="w-50 d-flex flex-column">
                        <div class="w-100 p-3 border Exam_Completed">
                            <h3>Exam Completed</h3>
                                <div class="align-items-center row d-flex flex-column  ">
                                    <h1 class="Student"><?php echo $NoAttenStudents ;?>/<?php echo $noofstudent; ?></h2>
                                    <label for="" id="time"><?php echo $_SESSION['start_time'];?></label>
                                </div>
                        </div>
                        <div class="w-100 border Exam_time">
                            <div class=" row d-flex flex-column time">
                                <?php
                                $minutes_to_add = $_SESSION['duration'];

                                $time = new DateTime($_SESSION['start_time']);
                                $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                                $stamp = $time->format('Y-m-d H:i:s');
                                ?>  
                                <h4>Exam started Time: <?php echo   $_SESSION['start_time']; ?></h4>
                                <h4 >Exam ending Time:  <?php echo  $stamp;  ?></h4>    
                             </div>
                        </div>
                    </div>
                    <div class="col-sm-5 border Student_atten p-2 ml-auto" id="jar">
                        <h3>Attending Student List</h3>
                      <?php
                         require '../database_connection.php'; 
                         $sql="SELECT * FROM mcqsystem.students";    
                         $sqlresult=$conn->query($sql);
                         if($sqlresult->num_rows > 0) 
                         {
            
                             while($studentdata =$sqlresult->fetch_assoc()) 
                             { 
                                echo'<div class="p-2 group shadow-sm list content">'.$studentdata['name'];
                                $sq2="SELECT * FROM mcqsystem.student_has_exam where student_id= $studentdata[user_login_id] and Exam_id =$_GET[id] and Examstatus='attended'";    
                                $sqlresult1=$conn->query($sq2);
                                if($sqlresult1->num_rows > 0) 
                                {
                                 echo '<span class="Correct">Completed</span>';
                                }
                                echo '</div>';
                             }  
                         }
                      ?>
                    </div>
                    
                </div>
                <nav class="bar">
                    <ul class="pagination justify-content-center pagination-sm">
                    </ul>
                </nav>
               <?php echo'<a class="btn btn-danger btnexam" href="monitorexam.php?delete='.$_GET['id'].'">END Exam</a>';?>
            </div> 

</body>
</html>
<script src="../assets/js/Teacher/MonitorExamPargination.js"></script>
