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
<link rel="stylesheet" href="../assets/css/dashboard.css">
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
                            <div  class="w-50 mr-5 border">
                                <canvas id="myChart"></canvas>
                            </div>
                            <div class="w-50 mr-5 border">
                                <canvas id="myChart1"></canvas>
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
  const labels =  <?php echo json_encode($Exam) ?>;

  const data = {
    labels: labels,
    datasets: [
        {
      label: 'No of attended students',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45],
    },
    {
      label: 'No oF Passed Student',
      backgroundColor: 'rgb(0,0,255)',
      borderColor: 'rgb(0,0,255)',
      data: [10,6 ,7, 2, 15, 50, 90],
    }
]
  };

  const config = {
  type: 'line',
  data: data,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Student Attendace '
      }
    }
  },
};
</script>
<script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
    const myChart1 = new Chart(
      document.getElementById('myChart1'),
      config
    );
  </script>