<?php 
session_start();

if (!isset($_SESSION['student_login_id']))
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
<title>Student || Exam Results page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/examresult.css">
<body>
  	    <div>
            <div class="side"> 
            </div>
            <div class="side2 border d-flex flex-column">
                <div class="mt-5 ml-3 d-flex flex-row">
                    <a href="student_home.html"><i class="fas fa-chevron-left fa-2x"></i></a>
                    <h3 class="ml-3" >Exam Name</h3>
                </div>
                <div class="mt-3 ">
                    <div class="border mb-1 w-25 align-items-center Result">
                        <label class="ml-4 mt-3"><b>Exam Completed</b></label>
                        <div class="d-flex flex-column text-center">
                            <h1 class="pass display-4">Passed</h2>
                            <label for="">A - 89 Points</label>    
                        </div>
    
                    </div>
                    <div class="border  w-25  align-items-center Result">
                        <label class="ml-4 mt-3"><b> Questions</b> </label>
                        <div class="d-flex flex-column" id="jar">
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 1<span class="Correct">Completed</span><span class="wrong" style="display:none ;">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 2<span class="Correct" style="display:none ;">Completed</span><span class="wrong" >Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 3<span class="Correct">Completed</span><span class="wrong" style="display:none ;">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 4<span class="Correct">Completed</span><span class="wrong" style="display:none ;">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 5<span class="Correct">Completed</span><span class="wrong" style="display:none ;">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 6<span class="Correct"  style="display:none ;">Completed</span><span class="wrong">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 7<span class="Correct">Completed</span><span class="wrong" style="display:none ;">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 8<span class="Correct"  style="display:none ;">Completed</span><span class="wrong">Wrong</span></div>
                                <div class="p-2 group w-75 ml-5 mb-2 mt-2 shadow-sm list content">Question 9<span class="Correct">Completed</span><span class="wrong" style="display:none ;">Wrong</span></div>
                        </div>
                       
                    </div>
                    <nav class="mt-2 ml-4" >
                        <ul class="pagination justify-content-center pagination-sm">
                        </ul>
                        
                    </nav>
                    <div class="closebtn mb-3">
                        <button class="btn btn-secondary">Close</button>
                    </div>
                   
                </div>
               
            </div> 
        </div>
</body>
</html>
<script src="../assets/js/script.js"></script>
