<?php 
session_start();

if (!isset($_SESSION['student_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}

if(isset($_GET['id'])){

}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Student || Single exam page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/Exam.css">
<body>
  	    <div style="height:100%;">
            <div class="side"> 
            </div>
            <div class="side2 border">
              <div class="mt-5 ml-3 d-flex flex-row">
                <a href="student_home.html"><i class="fas fa-chevron-left fa-2x"></i></a>
                <h3 class="ml-3" >Exam Name</h3>
            </div>
                <h5 class="text-center mt-5">Time Left 00:15 mins</h5>
                <div class="d-flex flex-column align-items-center" >
                  <label for="">Q.1) What is the correct HTML tag for playing video files</label>
                  <div class="d-flex flex-column mb-3 border w-25 pl-3 pt-2">
                    <div class="d-flex flex-row"><input name="radio" value="1-Year" class="radio1" type="radio"><label for="">anwser 1</label></div>
                    <div class="d-flex flex-row"><input name="radio" value="1-Year"  class="radio1" type="radio"><label for="">anwser 2</label></div>
                    <div class="d-flex flex-row"><input name="radio" value="1-Year"  class="radio1" type="radio"><label for="">anwser 3</label></div>
                    <div class="d-flex flex-row"><input name="radio" value="1-Year"  class="radio1" type="radio"><label for="">anwser 4</label></div>
                  </div>
                  <div class="d-flex flex-row justify-content-between w-25">
                    <button type="button" class="btn btn-secondary">Pervious</button>
                    <label for="" id="currentquestion"> Question 1</label>
                    <button type="button" class="btn btn-secondary">Next</button>
                  </div>
                </div>
                <div>
                  <nav aria-label="...">
                    <ul class="pagination pagination-sm justify-content-center">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">1</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                  </nav>
                </div>
                
                <div class="mt-5 btncontrol">
                  <button class="btn btn-primary">Save</button>
                  <button class="btn btn-info">Complete</button>
                </div>
            </div> 
        </div>
</body>
</html>

