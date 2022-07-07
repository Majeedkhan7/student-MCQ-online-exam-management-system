 <?php
require '../database_connection.php';
$sql="select * from question where question.examid=1"; 
$result=mysqli_query($conn,$sql);
$question = array();
$question1 = array();
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result))
    {
    $question[] = $row['id'];
    $question1[] = $row['Question'];
  
    }
    
}
$arrLength = count($question);
$questionAnwsers=array();

for($i=0;$i<$arrLength;$i++)
{


            $sql="select * from options where questionId='$question[$i]'"; 
            $result=mysqli_query($conn,$sql);
            $option=array();
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result))
                array_push($option,$row['optionvalue']);
            }
            array_push($option,$question[$i]);
            $questionAnwsers[$question[$i]]=$option;
}
$set=array_combine($question1,$questionAnwsers);
echo" <table id='myTable' border='1'>
<tr>
<th> Question </th>
<th> anwsers </th>
<th> Action </th>
</tr>";
foreach($set as $x=>$x_value)
  {
    echo"<tr>" ;
    echo "<td>".$x."</td>";
    echo"<td>" ;
    $options='';
  for($i=0;$i<4;$i++){
       
        $options.=$x_value[$i].',';
  }
  echo rtrim($options,",");
  echo"</td>" ;
  echo'<td><button id="btn" onclick="myFunction()"  data-id="'.$x_value[4].'" class="btn btn-danger btn-sm btnDelete">Edit</button></td>'; 
  echo "</tr>";
  }


?> 
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $("td button").on("click", function(){
        var dataId = $(this).attr("data-id");
        alert("The data-id of clicked item is: " + dataId);
    });
});



</script>




<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
var users = <?php echo json_encode($set); ?>;

    

for (var key of Object.keys(users)) {
        var tr=document.createElement('tr');
        var td1 = tr.appendChild(document.createElement('td'));
        var td2 = tr.appendChild(document.createElement('td'));
        var td3 = tr.appendChild(document.createElement('td'));
  
        td1.innerHTML=key;
        td2.innerHTML=users[key]
        td3.innerHTML='<button id="btn" value='+users[key]+' class="btn btn-danger btn-sm btnDelete">Delete</button>';
        document.getElementById("myTable").appendChild(tr);
    }

    let btn = document.getElementById("btn");
 
// Adding event listener to button
btn.addEventListener("click", () => {
 
    // Fetching Button value
    let btnValue = btn.value;
    console.log(btnValue)
});
x
</script> -->