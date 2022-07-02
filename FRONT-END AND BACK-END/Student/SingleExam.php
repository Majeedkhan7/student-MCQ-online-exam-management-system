<?php 
session_start();

require '../database_connection.php';
if (!isset($_SESSION['student_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}


if(isset($_GET['id'])){
     $sql = "SELECT * FROM `exams` WHERE id='$_GET[id]'";
     $result = $conn->query($sql);
     $exam = $result->fetch_assoc();
   
     $_SESSION["name"] = $exam['name'];
     $_SESSION["examid"] = "$_GET[id]";
     
   }
if((isset($_GET['status'])))
{
     if($_GET['status']=="attended"){
           header("Location:ExamResults.php?exid=$_GET[id]");
     }
}


$getans="SELECT options.optionvalue as value FROM `answers` INNER JOIN options ON answers.option_id=options.id WHERE answers.exam_id='$_SESSION[examid]' AND answers.student_id='$_SESSION[student_login_id]'";
$getAnswer=array();
$getansresult = $conn->query($getans);

if ($getansresult ->num_rows > 0) {
   // output data of each row
   while($ansdata = $getansresult ->fetch_assoc()) {
   array_push($getAnswer,$ansdata['value']);
   }

}
 ?>
 <?php

$sql="SELECT * FROM `exams` WHERE id='$_GET[id]'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$durantion=$row['duration'];

date_default_timezone_set('Asia/Kolkata');
$_SESSION['duration']=$durantion;
$_SESSION['start_time']=$row['dateandtime'];
$end_time=$end_time=date(' Y-m-d H:i:s',strtotime('+'.$_SESSION["duration"].'minute',strtotime($_SESSION["start_time"])));

$_SESSION["end_time"]=$end_time;

?>

<script>
var countDownDate = <?php 
echo strtotime($_SESSION["end_time"]) ?> * 1000;
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
document.getElementById("response").innerHTML ="Timeleft :"+" "+ days + "d " + hours + "h " +
minutes + "m " + seconds + "s ";
// If the count down is over, write some text 
if (distance < 0) {
clearInterval(x);
document.getElementById("myCheck").click()
}
    
}, 1000);
</script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Student || Single exam page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/Exam.css">
<style>
      .radio1{
        position: relative;
        top: -5px;
        margin-right: 10px;
        }
</style>
<body>

  	    <div style="height:100%;">
            <div class="side"> 
            </div>
            <div class="side2 border">
              <div class="mt-5 ml-3 d-flex flex-row">
                <a href="student_home.php"><i class="fas fa-chevron-left fa-2x"></i></a>
                <h3 class="ml-3" ><?php echo   $_SESSION["name"] ;?></h3>
           
               </div>
          
                <h5 class="ml-2 text-center" id="response"></h5>
                <div class="d-flex flex-column align-items-center" id="pagination_data">


                </div>
                <div class="mt-5 btncontrol">
                  <button class="btn btn-primary" onclick="save()">Save</button>
                  <button class="btn btn-info" id="myCheck" onclick="complete()">Complete</button>
                </div>
            </div> 

        </div>
</body>
</html>

<script>  
var abc=<?php echo json_encode($getAnswer);?>;
const main=[];
const quesno=[];

 $(document).ready(function(){  
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url:"pagination.php",  
                method:"POST",  
                data:{page:page},  
                success:function(data){  
                     $('#pagination_data').html(data); 
                     ok(); 
                }  
           })  
        
       
      }  
      $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id");  
           load_data(page);  
      });
      $(document).on('click', '.next', function(){  
           var totall = $(this).attr("id");  
           var page = parseInt($(this).attr("page")); 
           if(page<totall){
              page+=1;
           }
           load_data(page);  
          
      });

      $(document).on('click', '.Perviou', function(){  
           var totall = $(this).attr("id");  
           var page = parseInt($(this).attr("page")); 
           if(page>1){
              page-=1;
           }
           load_data(page);  
          
      });
      
      
      $(document).on('change', '.radio1', function(){  
           var ans = $(this).data("value");  
           var questionNo= $(this).data("id");
          main.push(ans);
          quesno.push(questionNo)
           ok(); 
      });  
 });  

function ok(){
  const nodeList = document.querySelectorAll("[name='choice']");
  for(var j=0; j<abc.length; j++){
      
      for(var i=0; i<nodeList.length; i++){

           if(abc[j]==nodeList[i].value){
                nodeList[i].checked=true;
           }
      }
}

    for(var j=0; j<main.length; j++){
      
          for(var i=0; i<nodeList.length; i++){

               if(main[j]==nodeList[i].value){
                    nodeList[i].checked=true;
               }
          }
}


}



function save(){
     const nodeList = document.querySelectorAll("[name='choice']");

$.ajax({  
           url:"new.php",  
           method:"POST", 
           data:{id:main,name:quesno},
           type:'JSON', 
           success:function(data){  
               window.location.assign("student_home.php");
           }  
            
      })  

}

function complete(){
var exid=<?php echo json_encode( $_SESSION['examid']);?>

$.ajax({  
           url:"complete.php",  
           method:"POST", 
           data:{id:main,name:quesno},
           type:'JSON', 
           success:function(data){  
               window.location.assign("ExamResults.php?exid="+exid);
    
           }  
            
      })  

}
 </script>  
