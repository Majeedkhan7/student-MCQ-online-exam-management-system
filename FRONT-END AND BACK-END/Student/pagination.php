<?php  
 //pagination.php  
 $connect = mysqli_connect("localhost", "root", "", "mcqsystem");  
 $record_per_page = 1;  
 $page = '';  
 $output = '';  
 if(isset($_POST["page"]))  
 {  
      $page = $_POST["page"];  
 }  
 else  
 {  
      $page = 1;  
 }  
 $start_from = ($page - 1)*$record_per_page;  
 $query = "SELECT * FROM `question` WHERE examid='1'  LIMIT $start_from, $record_per_page";  
 $result = mysqli_query($connect, $query);  

 while($row = mysqli_fetch_array($result))  
 { 
    $output.='<label for="">Q.'.$row['questionNo'].')'.$row['Question'] .'</label>';
    $qustionsoption="SELECT * FROM `options` WHERE questionId='$row[id]'";
    $optionresult =  $connect->query( $qustionsoption);
    if ($optionresult ->num_rows > 0) 
    {
     $output.='<div class="d-flex flex-column mb-3 border w-25 pl-3 pt-2">';
          while($ans =$optionresult ->fetch_assoc()) 
          {
   
           $output.='<div class="d-flex flex-row"><input name="radio"  value="'.$ans['optionvalue']. '" class="radio1" type="radio"><label for="">'.$ans['optionvalue'].'</label></div>';
         
          }
          $output.='</div>';
     }
       
 }  
 $output.='<div class="d-flex flex-row justify-content-between w-25">
 <button type="button" class="btn btn-secondary">Pervious</button>
 <label for="" id="currentquestion"> Question 1</label>
 <button type="button" class="btn btn-secondary">Next</button>
</div>';
 $page_query = "SELECT * FROM `question` WHERE examid='1' ";  
 $page_result = mysqli_query($connect, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  
 $output .= '</div<div><nav aria-label="..."><ul class="pagination pagination-sm justify-content-center">';  
 for($i=1; $i<=$total_pages; $i++)  
 {  
  
      $output.='<li class="page-item"><a class="page-link pagination_link"  id='.$i.' >'.$i.'</a></li>';
 }  
 $output .= '</ul></nav></div>';  
 echo $output;  
 ?>  