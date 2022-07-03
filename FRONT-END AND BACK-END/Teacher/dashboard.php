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
            <div class="side2 border">
                <div class="title-main">
                    <h3 class="title">Dashboard</h3>
                </div>
                
                <div class="w-90 d-flex flex-row  main">   
                    <div class="col-sm-5 border shadow bg-white rounded  kh">
                     <h4 class='text-center mt-3'>Attending and Results progress though Time </h4>
                        <div>  
                        <canvas id="myChart"></canvas>
                        </div>
                    </div>
                
                    <div class="col-sm-5 border shadow bg-white rounded ">
                      <h4 class='text-center mt-3'>Average Result Grade Percentages</h4>
                      <div>
                  <!---<canvas id="myChart1"></canvas>--->
                      </div>
                    </div> 
                </div>
                <div class="w-90 d-flex flex-row main1">   
                  <div class="col-sm-5 border kh shadow bg-white rounded ">
                    <h4 class='text-center mt-3'>Average Top Results Students</h4>
                    <table class="table">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Student name</th>
                          <th scope="col">Average Marks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>90</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>70</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Larry</td>
                          <td>65</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="col-sm-5 border shadow bg-white rounded ">
                    <h4 class='text-center mt-3'>Average Low Results Students</h4>
                    <table class="table">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Student name</th>
                          <th scope="col">Average Marks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>20</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>35</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Larry</td>
                          <td>38</td>
                        </tr>
                      </tbody>
                    </table>
                  </div> 
              </div>
            </div> 
</div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/js/chart.js"></script>

