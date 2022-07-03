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
if(isset($_POST['save']))
{
  if(isset($_POST['examid']))
  {
    //save already saved Exam
    if($_POST['question'])
    {
      $sql="SELECT * FROM `question` WHERE examid='$_POST[examid]' ORDER by (questionNo) DESC LIMIT 1";
      $result=mysqli_query($conn,$sql);
      if($result->num_rows > 0)
      {
        $row=mysqli_fetch_array($result);
        $num=$row['questionNo'];
        $question=$_POST['question'];
        $ansers=$_POST['ansers'];
        $noques=count($question);
    
        for($i=0;$i<$noques;$i++)
        {
            $num+=1;
          $canser=$_POST['correctans'];
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
      }
    }
    $uexam=$_POST['exam'];
    $udatetime=$_POST['datetime'];
    $uduration=$_POST['duration'];
    echo $uexam.$udatetime.$uduration;
    $sqlupdate="UPDATE `exams` SET `name`='$uexam',`duration`='$uduration',dateandtime='$udatetime'	 WHERE id='1' and teacherid='2'";
    mysqli_query($conn,$sqlupdate);
    header("Location: single_Exam.php?id=$_POST[examid] & success=successfully updated");

  

  }
  else
  {
    //save NEw Exam Deails
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
            header("Location: single_Exam.php?success=successfully exam created & id=$exam_id");
    }
    else 
    {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
}
//this for publish the Exam
if(isset($_POST['publish']))
{

  if(isset($_POST['examid']))
  {
    if($_POST['question'])
    {
      $sql="SELECT * FROM `question` WHERE examid='$_POST[examid]' ORDER by (questionNo) DESC LIMIT 1";
      $result=mysqli_query($conn,$sql);
      if($result->num_rows > 0)
      {
        $row=mysqli_fetch_array($result);
        $num=$row['questionNo'];
        $question=$_POST['question'];
        $ansers=$_POST['ansers'];
        $noques=count($question);
    
        for($i=0;$i<$noques;$i++)
        {
            $num+=1;
          $canser=$_POST['correctans'];
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
      }
    }
    $sql="UPDATE `exams` SET `status`='published' WHERE id='$_POST[examid]'";
    if ($conn->query($sql) === TRUE) 
    {
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