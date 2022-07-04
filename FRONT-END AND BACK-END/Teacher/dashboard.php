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
//get this teacher create Exam
$query = $conn->query("SELECT * FROM `exams` WHERE teacherid='$_SESSION[teacher_login_id]' AND status='published' ORDER BY id ASC");
$Exam[]=array();
foreach($query as $data)
{
$Exam[] = $data['name'];
}
//get Totall Students
$query1 = $conn->query("SELECT * FROM `exams` WHERE teacherid='$_SESSION[teacher_login_id]' AND status='published'");

foreach($query1 as $data)
{
//$TotallStudent[] = $data['student'];
}
$a=array();
$b=array();
$c=array();
$d=array();
$e=array();
$totall=0;
$PI="SELECT COUNT(id) as no,GRADE FROM `student_has_exam` GROUP BY GRADE ORDER BY GRADE ASC";
$PIresult=mysqli_query($conn,$PI);
while($value=mysqli_fetch_assoc($PIresult))
{
  array_push($a,$value['no']);
  array_push($c,$value['GRADE']);
  $totall+=$value['no'];
}
foreach ($a as $value) {
  $z=($value/$totall)*100;
  array_push($b,$z);

}


$studentchart="SELECT count(id) ,student_has_exam.Exam_id from mcqsystem.student_has_exam group by Exam_id  order by Exam_id asc";
$studentchartR=mysqli_query($conn,$studentchart);
while($value=mysqli_fetch_assoc($studentchartR))
{
  array_push($d,$value['count(id)']);
}


$examchart="SELECT * FROM mcqsystem.student_has_exam inner join exams on student_has_exam.Exam_id=exams.id group by student_has_exam.Exam_id order by student_has_exam.Exam_id asc";
$examchartR=mysqli_query($conn,$examchart);
while($value=mysqli_fetch_assoc($examchartR))
{
  array_push($e,$value['name']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Tachers || dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<style>
  .chartbox{
    width: 300px;
  }
</style>
<body>
<div style="height:100%;">
            <div class="side"> 
            </div>
            <div class="side2 border" >
                <div class="title-main">
                    <h3 class="title">Dashboard</h3>
                </div>

                <div class=" content d-flex flex-column ">
                    <div class=" d-flex flex-row justify-content-around">
                            <div  class="w-50  mr-5 border">
                            <h4 class="text-center">Attendance Per Exam</h4>
                              <canvas id="myChart1" class="ml-5 mt-3"></canvas>
                            </div>
                            <div class="w-50 mr-5 border"  id="donutchart">
                            <h4 class="text-center">Average Result Grade Percentages(%)</h4>
                            <div class="chartbox ml-5">
                              <canvas id="myChart" height="40vh" width="80vw" class="ml-5 mt-3"></canvas>
                              </div>
                            </div>
                    </div>
                    <div class=" d-flex flex-row justify-content-around">
                        <div  class="w-50 mr-5 mt-3 border">
                            <h4 class="text-center">Average Top Result Student</h4>
                            <table class="table table-responsive-lg border ml-5 w-75 ">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student_Name</th>
                                    <th scope="col">Exam_Name</th>
                                    <th scope="col">Result</th>
                                  </tr>
                                </thead>
                                <tbody id="top" >
                                <?php 
                                require('../database_connection.php');
                                $sql = "SELECT students.name as name, exams.name as exam , student_has_exam.result as result FROM student_has_exam JOIN students ON student_has_exam.student_id = students.user_login_id JOIN exams ON student_has_exam.Exam_id = exams.id WHERE exams.teacherid=$_SESSION[teacher_login_id] ORDER BY student_has_exam.result DESC,student_has_exam.Exam_id ASC;";
                                $result=mysqli_query($conn,$sql);
                                if($result->num_rows > 0)
                                {
                                  $i=1;
                                  while ($row=mysqli_fetch_array($result))
                                  {
                                  echo"<tr class='content'>";
                                  echo"<td>".$i."</td>";
                                  echo"<td>".$row['name']."</td>"; 
                                  echo"<td>".$row['exam']."</td>"; 
                                  echo"<td>".$row['result']."</td>"; 
                                  echo"</tr>";
                                  $i+=1;
                                  }
                                 }
                                ?>
                                </tbody>
                              </table>
                              <nav class="bar">
                                  <ul class="pagination pagination1  justify-content-center pagination-sm">
                                   </ul>
                              </nav>
                        </div>
                        <div  class="w-50 mr-5 mt-3 border">
                            <h4 class="text-center">Average Low Result Student</h4>
                            <table class="table table-responsive-lg border ml-5 w-75 ">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student_Name</th>
                                    <th scope="col">Exam_Name</th>
                                    <th scope="col">Result</th>
                                  </tr>
                                </thead>
                                <tbody id="jar">
                                <?php 
                                require('../database_connection.php');
                                $sql = "SELECT students.name as name, exams.name as exam , student_has_exam.result as result FROM student_has_exam JOIN students ON student_has_exam.student_id = students.user_login_id JOIN exams ON student_has_exam.Exam_id = exams.id WHERE exams.teacherid=$_SESSION[teacher_login_id] ORDER BY student_has_exam.result ASC,student_has_exam.Exam_id ASC;";
                                $result=mysqli_query($conn,$sql);
                                if($result->num_rows > 0)
                                {
                                  $i=1;
                                  while ($row=mysqli_fetch_array($result))
                                  {
                                  echo"<tr class='content'>";
                                  echo"<td>".$i."</td>";
                                  echo"<td>".$row['name']."</td>"; 
                                  echo"<td>".$row['exam']."</td>"; 
                                  echo"<td>".$row['result']."</td>"; 
                                  echo"</tr>";
                                  $i+=1;
                                  }
                                 }
                                ?>
                                </tbody>
                              </table>
                              <nav class="bar">
                                  <ul class="pagination pagination2  justify-content-center pagination-sm">
                                   </ul>
                              </nav>
                        </div>
                   </div>

                </div>  
            </div>
                  
</div>
</body>
</html>
<script src="../assets/js/Teacher/dashboardPagination1.js"></script>
<script src="../assets/js/Teacher/dashboardPagination2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

  const data = {
  labels: <?php echo json_encode($c) ?> ,
  datasets: [{
    label:  <?php echo json_encode($c) ?> ,
    data: <?php echo json_encode($b) ?>,
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(168, 50, 160',
      'rgb(80, 50, 168)',
      'rgb(89, 168, 50)'
    ],
    hoverOffset: 4
  }]
};
const options={
 plugins:{
  legend:{
    display:true,
    position:'right',
    labels:{
      boxWidth:10,
      padding:20
    }
  },
  title:{
    display:false,
    text:'Average Result Grade Percentages(%)'
  }
  
 },


}
const config = {
  type: 'doughnut',
  data: data,
  options
  
};
</script>
<script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
 </script>



<script>
  const labels1 = <?php echo json_encode($e) ?>;
const data1 = {
  labels: labels1,
  datasets: [
    {
      label: 'Students',
      data: <?php echo json_encode($d) ?>,
      backgroundColor:['rgb(255, 99, 132)'],
      stack: 'Stack 0',
    }
   
  ]
};
  const config1 = {
  type: 'bar',
  data: data1,
  options: {
    plugins: {
      title: {
        display: false,
        text: 'Chart.js Bar Chart - Stacked'
      },
    },
    responsive: true,
    interaction: {
      intersect: false,
    },
    scales: {
      x: {
        stacked: true,
      },
      y: {
        stacked: true
      }
    }
  }
};


const myChart1 = new Chart(
      document.getElementById('myChart1'),
      config1
    );
</script>