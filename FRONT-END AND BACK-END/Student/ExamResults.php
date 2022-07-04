<?php 
session_start();
//include database connection
require '../database_connection.php'; 
//user authentication
if (!isset($_SESSION['student_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}
//get the exam id using get method
if(isset($_GET['exid'])){
    $sql = "SELECT * FROM `exams` WHERE id='$_GET[exid]'";
    $result = $conn->query($sql);
    $exam = $result->fetch_assoc();
//store exam details in session varible
    $_SESSION["name"] = $exam['name'];
    $_SESSION["examid"] = "$_GET[exid]";
    
  }
  //get the result of student from database
  $selectResult="SELECT * FROM `student_has_exam` WHERE student_id='$_SESSION[student_login_id]' AND Exam_id='$_SESSION[examid]'";
  $sresult = $conn->query($selectResult);
  $resultdata = $sresult->fetch_assoc();
  //store exam mark of this student
  $marks=(int)$resultdata['result'];
  $state;
//exam result calculation
  if ($marks>85)
  {
      $grade = "A";
      $state="Passed";
  }
  else if($marks>65)
  {
      $grade = "B";
      $state="Passed";
  }
  else if($marks>45)
  {
      $grade = "C";
      $state="Passed";
  }
  else if($marks>25)
  {
      $grade = "S";
      $state="Passed";
  }
  else
  {
      $grade = "W";
      $state="Failed";
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Student || Exam Results page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/student/examresult.css">
<body>
  	<div>
        <div class="side"></div>
            <div class="side2 border d-flex flex-column"  style="height:713.2px;">
                <div class="mt-4 ml-3 d-flex flex-row">
                    <a href="student_home.php" class="mt-0"><i class="fas fa-chevron-left fa-2x"></i></a>
                    <h3 class="ml-3 mt-0" ><?php echo $_SESSION['name']?></h3>
                </div>
                
                    <div class="border mb-1 w-25 align-items-center Result">
                        <label class="ml-4 mt-3"><b>Exam Completed</b></label>
                        <div class="d-flex flex-column text-center">
                            <?php
                                if($state=="Passed")
                                {
                               echo'<h1 class="pass display-4">'. $state.'</h2>';
                                }
                                else{
                                echo'<h1 class="fail display-4">'. $state.'</h2>';
                                }
                            ?>
                            <label for=""><?php echo $grade.'-'.  $marks;?> Points</label>    
                        </div>
    
                    </div>
                    <div class="border pb-2  w-25  align-items-center Result">
                        <label class="ml-4 mt-3"><b> Questions</b> </label>
                        <div class="d-flex flex-column" id="jar">

                                <?php
                                $sql1="SELECT * FROM question where examid=$_SESSION[examid]";
                                $sql1result=$conn->query($sql1);
                                if ($sql1result->num_rows > 0) 
                                {
                                    while($row =$sql1result->fetch_assoc()) 
                                    {
                                    echo'<div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question '.$row['questionNo'];
                                    $sql2="SELECT * FROM mcqsystem.answers where student_id=$_SESSION[student_login_id] and question_id=$row[id] and exam_id='$_SESSION[examid]'";
                                    $sql2result=$conn->query($sql2);
                                    if ($sql2result->num_rows > 0) 
                                    {
                                        $row2=$sql2result->fetch_assoc();
                                        if($row2['question_result']=="Pass")
                                        {
                                            echo '<span class="Correct">Correct</span>';
                                        }else{
                                            echo '<span class="wrong" >Wrong</span>';
                                        }

                                    }
                                    else{
                                        echo'<span class="wrong">not answered</span>';        
                                    }
                                    echo '</div>';
                                    }
                                }
                                ?>
                        </div>
                   
                        <nav class="mt-1 mr-2 float-right" >
                            <ul class="pagination justify-content-center pagination-sm">
                            </ul>
                        </nav>
                        <div class="closebtn mt-5 ml-2">
                        <a class="btn btn-secondary" href="student_home.php">Close</a>
                        </div>
                    </div>    
            </div> 
    </div>
</body>
</html>
<script src="../assets/js/student/ParginationOfExamResult.js"></script>
