<?php
//include database connection
require '../database_connection.php';
session_start();
//teacher auth
if (!isset($_SESSION['teacher_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}
//save Exam 
if($_POST['main_id']==0)
{

  $duration=$_POST['duration'];
  $ExamName=$_POST['exam'];
  $examdate=$_POST['examdatetime'];

  $sql="INSERT INTO `exams`( `name`, `dateandtime`, `duration`, `teacherid`, `status`) 
  VALUES ('$ExamName','$examdate','$duration','$_SESSION[teacher_login_id]','draft')";
  $result=mysqli_query($conn,$sql);
  $ex_id = mysqli_insert_id($conn);
  if(isset($_POST['question']))
  {
    $data=$_POST['question'];
    $length=count($data);

    for($i=0;$i<$length;$i++)
    {
      $qno=$i+1;
      for($j=0;$j<5;$j++)
      {
          if($j==0)
          {
              $questionvalue=$data[$i][$j];
              $insert="INSERT INTO `question`( `questionNo`, `Question`, `examid`) VALUES ('$qno',' $questionvalue','$ex_id')";
              mysqli_query($conn,$insert);
              $ques_id = mysqli_insert_id($conn);
          }
          if($j>=1 && $j<5)
          {
              if($data[$i][$j]==$data[$i][5]){
                  $c=1;
              }else{
                  $c=0;
              }
              $optionvalue=$data[$i][$j];
              $insert1="INSERT INTO `options`(`optionvalue`, `questionId`, `iscoorect`) VALUES ('$optionvalue','$ques_id','$c')";
              mysqli_query($conn,$insert1);

          }
      }
    }
  }
  echo "single_Exam.php?id=$ex_id & success=successfully created";
}
else
{
  $id=$_POST['main_id'];
  $duration=$_POST['duration'];
  $ExamName=$_POST['exam'];
  $examdate=$_POST['examdatetime'];

  $sql="UPDATE `exams` SET `name`='$ExamName',`dateandtime`='$examdate',`duration`='$duration' WHERE id=$id";
  $result=mysqli_query($conn,$sql);
  if(isset($_POST['question']))
  {
    $data=$_POST['question'];
    $sql="SELECT * FROM mcqsystem.question where examid=$id";
    $result=mysqli_query($conn,$sql);
    $rows=mysqli_num_rows($result);

    if($rows>0){
      while($row=mysqli_fetch_assoc($result)){
          $sql2="DELETE FROM `options` WHERE questionId=$row[id]";
          mysqli_query($conn,$sql2);
      }
      $sql3="DELETE FROM `question` WHERE examid=$id";
      mysqli_query($conn,$sql3);

    }
    $length=count($data);

    for($i=0;$i<$length;$i++)
    {
      $qno=$i+1;
      for($j=0;$j<5;$j++)
      {
          if($j==0)
          {
              $questionvalue=$data[$i][$j];
              $insert="INSERT INTO `question`( `questionNo`, `Question`, `examid`) VALUES ('$qno',' $questionvalue','$id')";
              mysqli_query($conn,$insert);
              $ques_id = mysqli_insert_id($conn);
          }
          if($j>=1 && $j<5)
          {
              if($data[$i][$j]==$data[$i][5]){
                  $c=1;
              }else{
                  $c=0;
              }
              $optionvalue=$data[$i][$j];
              $insert1="INSERT INTO `options`(`optionvalue`, `questionId`, `iscoorect`) VALUES ('$optionvalue','$ques_id','$c')";
              mysqli_query($conn,$insert1);

          }
      }
    }
  }
  echo "single_Exam.php?id=$id & success=successfully updated";

}

?>