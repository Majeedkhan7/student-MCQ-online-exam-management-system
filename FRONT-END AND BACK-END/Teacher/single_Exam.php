<?php
session_start();
//include database connection
require '../database_connection.php';
// user auth
if (!isset($_SESSION['teacher_login_id']))
{
  header("Location: ../index.php?error=You Need To Login First");
  exit();
}
//get if already have exam 
  if(isset($_GET['id'])){
    $sql="SELECT * FROM `exams` WHERE id='$_GET[id]'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();   
    } 
  }

  //delete question
  if(isset($_GET['delete'])){

    $id=$_GET['delete'];
    $id1=$_GET['id'];
    $sql1 ="DELETE FROM `question` WHERE id='$id'";
    $sql ="DELETE FROM `options` WHERE questionId='$id'";
    if ($conn->query($sql1) === TRUE && $conn->query($sql) === TRUE) {
      header("Location: single_Exam.php?id=$id1");
    } else {
      echo "Error deleting record: " . $conn->error;
    }
  }


  
$userdata="SELECT * FROM mcqsystem.teachers where user_login_id='$_SESSION[teacher_login_id]'";
$userresult=mysqli_query($conn,$userdata);
$userdetails=mysqli_fetch_assoc($userresult);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Tachers || Single Exam page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/Teacher/single_exam.css">
<link rel="stylesheet" type="text/css" href="../assets/css/jquery.datetimepicker.css" >
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/jquery.datetimepicker.full.min.js"></script>
<body>
<nav class="shadow-sm navbar navbar-expand-lg navbar-light bg-ligh bg-white rounded">
  <a class="navbar-brand" href="#">SCHOOL MCQ ONLINE APPLICATION</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="navbar-nav align-items-center">
        <li class="nav-item ">
          <a class="nav-link" href="dashboard.php">Dashboard </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="student_home.php">Exams<span class="sr-only">(current)</span></a>
        </li>
      </ul>
    <ul class="navbar-nav ml-auto">
    <div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link  dropdown-toggle-nocaret" href="#" role="button" data-toggle="dropdown"  aria-expanded="false">
							<img src="../assets/u.jpg" width="50" class="rounded-circle" alt="user avatar">
							<div class="user-info ps-3 ml-1">
								<p class="user-name mb-0"><?php echo $userdetails['name']; ?></p>
								<p class="designattion mb-0">Teacher</p>
							</div>
						</a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                    <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
             </div>
		  </div>
    </ul>
  </div>
</nav>    
        <div class="side2 border" style="height:631.2px;">
        <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $_GET['error']; ?>
      </div>
      <?php }?>
      <?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $_GET['success']; ?>
      </div>
      <?php }?>
        <form action="saveExam.php" method="POST" name="sample">
          <div class="examname">
            <a href="Teacher_home.php"><i class="fas fa-chevron-left fa-2x"></i></a>
            <?php
              if(isset($row['name'])){
                echo' <input type="text" class="form-control exam" name="exam" value="'.$row['name'].'" required>';
                echo' <input type="hidden" class="form-control exam" name="examid" value="'.$row['id'].'">';
              }
              else{
                echo' <input type="text" class="form-control exam" name="exam"  placeholder="Exam name" required>';
              }
            ?> 
          </div>
            <div class="main">   
                <div class="form-group pull-right control">
                    <label for="Question" id="Question">Question List</label>
                    <button type="button" class="btn btn-danger p-2 ml-auto" data-toggle="modal" data-target="#myModal">Add Question</button>
                </div>   
        	      <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                   <div class="modal-content">
          <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">ADD NEW Question</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
           <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" class="form-control"  id="question" name="question" placeholder="Question Name">
                    <br>
                    <label for="a"> Answers list</label>
                    <div class="d-flex flex-column mb-3">
                      <div class="p-2 group d-flex flex-row"><input name="main" value="1" class="radio1 mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control a" id="answer" name="ans1" placeholder="Answer 1"></div>
                      <div class="p-2 group d-flex flex-row"><input name="main" value="2"  class="radio1 mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control a" id="answer1"  name="ans2" placeholder="Answer 2" ></div>
                      <div class="p-2 group d-flex flex-row"><input name="main" value="3"  class="radio1 mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control a" id="answer2"  name ="ans3"placeholder="Answer 3" ></div>
                      <div class="p-2 group d-flex flex-row"><input name="main" value="4"  class="radio1 mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control a" id="answer3"  name="ans4"placeholder="Answer 4"></div>
                    </div>
                </div>
          <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-success btn-add" data-dismiss="modal" id="btnClosePopup">ADD</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          
          <!-- update model-->
        	      <div class="modal fade" id="myModal1">
                <div class="modal-dialog">
                   <div class="modal-content">
          <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">update Question</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
           <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Question Name">
                    <br>
                    <label for="a"> Answers list</label>
                    <div class="d-flex flex-column mb-3">
                      <div class="p-2 group d-flex flex-row"><input value="1" class=" mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control "  placeholder="Answer 1"></div>
                      <div class="p-2 group d-flex flex-row"><input  value="2"  class=" mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control "  placeholder="Answer 2" ></div>
                      <div class="p-2 group d-flex flex-row"><input  value="3"  class=" mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control "  placeholder="Answer 3" ></div>
                      <div class="p-2 group d-flex flex-row"><input  value="4"  class=" mr-2" type="radio"><span class="Correct">correct</span><input type="text" class="form-control "  placeholder="Answer 4"></div>
                    </div>
                </div>
          <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-success btn-add" data-dismiss="modal" id="btnClosePopup">ADD</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

                <table id="tbl" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Question</th>
                      <th>Answers</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="jar">
                  <?php
                  if(isset($row['name'])){
                    $sql2= "SELECT * FROM `question` WHERE examid='$row[id]'";
                    $result2=mysqli_query($conn,$sql2);
                    if($result2->num_rows > 0)
                    {
                       
                        while ($row1=mysqli_fetch_array($result2))
                        {
                         echo"<tr class='content'>";
                         echo"<td>".$row1['Question']."</td>";
                         echo"<td>";
                         $sql3="SELECT * FROM `options` WHERE questionId='$row1[id]'";
                         $result3=mysqli_query($conn,$sql3);
                         if($result3->num_rows > 0)
                        {
                          $options='';
                          while ($row2=mysqli_fetch_array($result3))
                          {
                            $options.=$row2['optionvalue'].',';
                           
                          }
                          echo  rtrim($options,",");
                        }
                        echo"</td>";
                        echo"<td>".'<a class="btn btn-danger btn-sm" href="single_Exam.php?delete=' . $row1['id']. '& id='.$row['id']. '">Delete</a>'.'<button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal" data-target="#myModal1">Edit</button>'."</td>";
                  
                        echo"</tr>";
                        }
                    }
                  }
                  ?>
                  </tbody>
                </table>

                <div class="container">
                   <div class="row">
                      <div class="col-sm">
                      <?php
                	    if(isset($row['duration'])){
                           echo'<input type="text" class="form-control" name="datetime"  id="datetimepicker" value="'.$row['dateandtime'].'" required>';
                          }
                      else{
                           echo' <input type="text" class="form-control" name="datetime"  id="datetimepicker"  placeholder="Exam Date Time" required>';
                         }
                        ?>
                       
                      </div>
                      <div class="col-sm">
                      <?php
                	    if(isset($row['duration'])){
                           echo'  <input type="number" class="form-control" name="duration"  value="'.$row['duration'].'" min="1" required>';
                          }
                      else{
                           echo'<input type="number" class="form-control" name="duration"  placeholder="Exam Duration" min="1" required>';
                         }
                        ?>
                       
                      </div>
                      <div class="col-sm">
                        <button type="submit" class="btn Publish" name="publish">Publish Paper</button>
                      </div>
                      <div class="col-sm">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                      </div>
                      </form>
                    </div>
                   </div>
                </div>
             
        </div>
    
</body>
</html>
<script src="../assets/js/Teacher/singleexam.js"></script>
