<?php
require '../database_connection.php';
session_start();

if (!isset($_SESSION['teacher_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}

if(isset($_POST['save']))
{
  if(isset($_POST['examid']))
  {
    if($_POST['question']==''){
      header("Location: single_Exam.php?id=$_POST[examid]");
    }
  $sql="SELECT * FROM `question` WHERE examid='$_POST[examid]' ORDER by (questionNo) DESC LIMIT 1";
  $result=mysqli_query($conn,$sql);
  if($result->num_rows > 0){
    $row=mysqli_fetch_array($result);
    $num=$row['questionNo'];
    $question=$_POST['question'];
    $ansers=$_POST['ansers'];
    $noques=count($question);

    for($i=0;$i<$noques;$i++)
    {
        $num+=1;
       $sql="INSERT INTO `question`(`questionNo`, `Question`, `examid`)
       VALUES ('$num','$question[$i]','$_POST[examid]')";
       if (mysqli_query($conn, $sql)) 
       {
         $ques_id = mysqli_insert_id($conn);
         $name=(explode(",",$ansers[$i])); 
         foreach ( $name as $value) 
         {        
           if($value==$canser[$i])
           {
             $c=1;
           }
           else
           {
             $c=0;
           }
           $sql="INSERT INTO `options`(`optionvalue`, `questionId`, `iscoorect`)
           VALUES ('$value','$ques_id','$c')";
           mysqli_query($conn,$sql);
         }
       }
       else 
       {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
       }

     }
     header("Location: single_Exam.php?id=$_POST[examid]");
  }
  }
  else
  {
    if($_POST['question']==''){
      header("Location: single_Exam.php?error=Please add Question");
    }
      $exam=$_POST['exam'];
      $datetime=$_POST['datetime'];
      $duration=$_POST['duration'];
      $question=$_POST['question'];
      $ansers=$_POST['ansers'];
      $noques=count($question);
  
      $canser=$_POST['correctans'];
      $sql="INSERT INTO `exams`(`name`, `dateandtime`, `duration`, `teacherid`, `status`)
      VALUES ('$exam','$datetime','$duration','$_SESSION[teacher_login_id]','draft')";
      if(mysqli_query($conn, $sql)) 
      {
            $exam_id = mysqli_insert_id($conn);
           for($i=0;$i<$noques;$i++)
           {
              $qusno=$i+1;
              $sql="INSERT INTO `question`(`questionNo`, `Question`, `examid`)
              VALUES ('$qusno','$question[$i]','$exam_id')";
              if (mysqli_query($conn, $sql)) 
              {
                $ques_id = mysqli_insert_id($conn);
                $name=(explode(",",$ansers[$i])); 
                foreach ( $name as $value) 
                {        
                  if($value==$canser[$i])
                  {
                    $c=1;
                  }
                  else
                  {
                    $c=0;
                  }
                  $sql="INSERT INTO `options`(`optionvalue`, `questionId`, `iscoorect`)
                  VALUES ('$value','$ques_id','$c')";
                  mysqli_query($conn,$sql);
                }
  
  
              }
              else 
              {
                   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
  
            }
            header("Location: single_Exam.php?success=successfully exam created");
    }
    else 
    {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

 
}



if(isset($_POST['publish']))
{
  if(isset($_POST['examid']))
  {
    $sql="UPDATE `exams` SET `status`='published' WHERE id='$_POST[examid]'";
    if ($conn->query($sql) === TRUE) 
    {
      $sql="SELECT * FROM `students`";
      $result=mysqli_query($conn,$sql);
      if ($result->num_rows >= 0) {
        while($row = $result->fetch_assoc()) {
          echo $row['id'];
        $sql2="INSERT INTO `student_has_exam`(`student_id`, `Exam_id`, `Examstatus`) 
         VALUES ('$row[id]','$_POST[examid]','Pending')";
         mysqli_query($conn,$sql2);
        }
      } 
      else {
        echo "0 results";
      }

      header("Location: Teacher_home.php");
    }


  }
  else{
    if($_POST['question']==''){
      header("Location: single_Exam.php?error=Please add Question");
    }
      $exam=$_POST['exam'];
      $datetime=$_POST['datetime'];
      $duration=$_POST['duration'];
      $question=$_POST['question'];
      $ansers=$_POST['ansers'];
      $noques=count($question);
  
      $canser=$_POST['correctans'];
      $sql="INSERT INTO `exams`(`name`, `dateandtime`, `duration`, `teacherid`, `status`)
      VALUES ('$exam','$datetime','$duration','$_SESSION[teacher_login_id]','published')";
      if(mysqli_query($conn, $sql)) 
      {
            $exam_id = mysqli_insert_id($conn);
           for($i=0;$i<$noques;$i++)
           {
              $qusno=$i+1;
              $sql="INSERT INTO `question`(`questionNo`, `Question`, `examid`)
              VALUES ('$qusno','$question[$i]','$exam_id')";
              if (mysqli_query($conn, $sql)) 
              {
                $ques_id = mysqli_insert_id($conn);
                $name=(explode(",",$ansers[$i])); 
                foreach ( $name as $value) 
                {        
                  if($value==$canser[$i])
                  {
                    $c=1;
                  }
                  else
                  {
                    $c=0;
                  }
                  $sql="INSERT INTO `options`(`optionvalue`, `questionId`, `iscoorect`)
                  VALUES ('$value','$ques_id','$c')";
                  mysqli_query($conn,$sql);
                }
  
                $sql3="SELECT * FROM `students`";
                $result3=mysqli_query($conn,$sql3);
                if ($result3->num_rows >= 0) {
                  while($row3 = $result3->fetch_assoc()) {
                  $sql4="INSERT INTO `student_has_exam`(`student_id`, `Exam_id`, `Examstatus`) 
                   VALUES ('$row3[id]','$exam_id','Pending')";
                   mysqli_query($conn,$sql4);
                  }
                }
              }
              else 
              {
                   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
  
            }
            header("Location: Teacher_home.php");
    }
    else 
    {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
}

?>