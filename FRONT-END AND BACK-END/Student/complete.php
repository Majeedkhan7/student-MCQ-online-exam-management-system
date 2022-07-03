<?php
//all code are work complete the exam
session_start();
//include database connection
require '../database_connection.php';
//user auth
if (!isset($_SESSION['student_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}
//Exam auth
if (!isset($_SESSION["examid"]))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}
//get Exam Details Of Student
$sql="SELECT * FROM `student_has_exam` WHERE  student_id='$_SESSION[student_login_id]' AND Exam_id='$_SESSION[examid]'";
$result=mysqli_query($conn,$sql);
if($result->num_rows > 0)
{   
  //complete the already saved Exam
  if(isset($_POST['id']) && isset($_POST['name'])){
    $question_an = $_POST['id'];
    $no = $_POST['name'];
    $c=array_combine($no,$question_an);
    foreach($c as $qus=>$ans)
    {
    
        $sql="SELECT * FROM `question` WHERE examid='$_SESSION[examid]' AND questionNo='$qus'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
             $row = $result->fetch_assoc();
             $questionID=$row['id'] ;
  
            $sqlnew="SELECT * FROM `answers` WHERE  question_id='$questionID' AND student_id='$_SESSION[student_login_id]'";
            $resultnew = $conn->query($sqlnew);
            if ($resultnew->num_rows > 0) 
            {
              $sql1="SELECT * FROM `options` WHERE questionId='$questionID' AND optionvalue='$ans'";
              $result1=$conn->query($sql1);
              if ($result1->num_rows > 0) 
              {
               $row1= $result1->fetch_assoc();
               $optionID=$row1['id'];
               $answercheck=$row1['iscoorect'];
               if($answercheck==1){
                  $mark="Pass";
               }
               else{
                  $mark="fail";
               }
               $sql3="UPDATE `answers` SET `option_id`='$optionID',`question_result`='$mark' WHERE student_id='$_SESSION[student_login_id]' AND question_id='$questionID'";
               if ($conn->query($sql3) === TRUE) {
                  echo "New record created successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
      
              }
            }
            else{
              $sql1="SELECT * FROM `options` WHERE questionId='$questionID' AND optionvalue='$ans'";
            $result1=$conn->query($sql1);
            if ($result1->num_rows > 0) 
            {
             $row1= $result1->fetch_assoc();
             $optionID=$row1['id'];
             $answercheck=$row1['iscoorect'];
             if($answercheck==1){
                $mark="Pass";
             }
             else{
                $mark="fail";
             }
             $sql3="INSERT INTO `answers`(`option_id`, `question_id`, `student_id`, `exam_id`, `question_result`) 
             VALUES ('$optionID','$questionID','$_SESSION[student_login_id]','$_SESSION[examid])','$mark')";
             if ($conn->query($sql3) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
    
            }
  
            }
             
        }    
    }
  
  }
  //calculate the result and save into database
  $noofquestion="SELECT COUNT(id) as noofquestion FROM `question` WHERE examid='$_SESSION[examid]'";
  $noofquestionresult=mysqli_query($conn,$noofquestion);
  $data=$noofquestionresult->fetch_assoc();
  $no_of_question=(int)$data['noofquestion'];
  $markperquestion=(100/$no_of_question);

  $count_correct="SELECT COUNT(id) AS nocorrect FROM `answers` WHERE student_id='$_SESSION[student_login_id]' AND exam_id='$_SESSION[examid]' AND question_result='pass'";
  $no_correct_result=mysqli_query($conn,$count_correct);
  $data1=$no_correct_result->fetch_assoc();
  $no_of_correct=(int)$data1['nocorrect'];

  $exam_totall_marks=($markperquestion*$no_of_correct);

  $updateExamResult="UPDATE `student_has_exam` SET `Examstatus`='attended',`result`='$exam_totall_marks'
   WHERE student_id='$_SESSION[student_login_id]' AND Exam_id='$_SESSION[examid]'";
    if ($conn->query($updateExamResult) === TRUE) {
       echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
else
{
  //complete without saved Exam
  $sqlFisrt="INSERT INTO `student_has_exam`(`student_id`, `Exam_id`, `Examstatus`) 
VALUES ('$_SESSION[student_login_id]','$_SESSION[examid]','attended')";
if ($conn->query($sqlFisrt) === TRUE) 
{
$question_an = $_POST['id'];
$no = $_POST['name'];
$c=array_combine($no,$question_an);

foreach($c as $qus=>$ans)
{

    $sql="SELECT * FROM `question` WHERE examid='$_SESSION[examid]' AND questionNo='$qus'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
         $row = $result->fetch_assoc();
         $questionID=$row['id'] ;
         $sql1="SELECT * FROM `options` WHERE questionId='$questionID' AND optionvalue='$ans'";
        $result1=$conn->query($sql1);
        if ($result1->num_rows > 0) 
        {
         $row1= $result1->fetch_assoc();
         $optionID=$row1['id'];
         $answercheck=$row1['iscoorect'];
         if($answercheck==1){
            $mark="Pass";
         }
         else{
            $mark="fail";
         }
         $sql3="INSERT INTO `answers`(`option_id`, `question_id`, `student_id`, `exam_id`, `question_result`) 
         VALUES ('$optionID','$questionID','$_SESSION[student_login_id]','$_SESSION[examid])','$mark')";
         if ($conn->query($sql3) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }

        }
    }    
}
  //calculate the result and save into database
$noofquestion="SELECT COUNT(id) as noofquestion FROM `question` WHERE examid='$_SESSION[examid]'";
$noofquestionresult=mysqli_query($conn,$noofquestion);
$data=$noofquestionresult->fetch_assoc();
$no_of_question=(int)$data['noofquestion'];
$markperquestion=(100/$no_of_question);

$count_correct="SELECT COUNT(id) AS nocorrect FROM `answers` WHERE student_id='$_SESSION[student_login_id]' AND exam_id='$_SESSION[examid]' AND question_result='pass'";
$no_correct_result=mysqli_query($conn,$count_correct);
$data1=$no_correct_result->fetch_assoc();
$no_of_correct=(int)$data1['nocorrect'];

$exam_totall_marks=($markperquestion*$no_of_correct);

$updateExamResult="UPDATE `student_has_exam` SET `Examstatus`='attended',`result`='$exam_totall_marks'
 WHERE student_id='$_SESSION[student_login_id]' AND Exam_id='$_SESSION[examid]'";
if ($conn->query($updateExamResult) === TRUE) {
 
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}
?>