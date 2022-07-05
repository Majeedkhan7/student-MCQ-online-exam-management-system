
  if (document.querySelector('input[name="main"]')) {
    document.querySelectorAll('input[name="main"]').forEach((elem) => {
      elem.addEventListener("change", function(event) {
        $(".Correct").css("display", "none");
        $(this).next("span").css("display", "block");
      });
    });
  }
  
jQuery('#datetimepicker').datetimepicker({
  minDate: new Date(),
});


$(function () 
{
  $('.btn-add').click(function(){
    var ques=document.sample.question.value;
    var ans1=document.sample.ans1.value;
    var ans2=document.sample.ans2.value;
    var ans3=document.sample.ans3.value;
    var ans4=document.sample.ans4.value;
    var cans=document.sample.main.value;
   

    if(ques==''){
      alert('fill out the question field');
      return false
    }
    if(ans1==''){
      alert('fill out the Answer 1 field');
      return false
    }
    if(ans2==''){
      alert('fill out the Answer 2 field');
      return false
    }
    if(ans3==''){
      alert('fill out the Answer 3 field');
      return false
    }
    if(ans4==''){
      alert('fill out the Answer 4 field');
      return false
    }

    if(cans==''){
      alert('select the correct answer');
      return false
    }
  
    let check=parseInt(cans);
switch (check) {
case 1:
  correctans = ans1;
  break;
case 2:
  correctans = ans2;
  break;
case 3:
  correctans = ans3;
  break;
case 4:
  correctans = ans4;
  break;
}
console.log(correctans);

    var tr=document.createElement('tr');

    var td1 = tr.appendChild(document.createElement('td'));
    var td2 = tr.appendChild(document.createElement('td'));
    var td3 = tr.appendChild(document.createElement('td'));
    const cars = [ans1,ans2,ans3,ans4];


    td1.innerHTML='<input type="hidden" name="question[]" value="'+ques+'">'+ques;
    td2.innerHTML='<input type="hidden" name="ansers[]" value="'+cars+'"><input type="hidden" name="correctans[]" value="'+correctans+'">'+ans1+','+ans2+','+ans3+','+ans4;
    td3.innerHTML='<button class="btn btn-danger btn-sm btnDelete">Delete</button>';

    document.getElementById("tbl").appendChild(tr);
  
    
    document.getElementById('question').value='';
    document.getElementById('answer').value='';
    document.getElementById('answer1').value='';
    document.getElementById('answer2').value='';
    document.getElementById('answer3').value='';
 
    $("[type=radio]").prop("checked",false);
    $(".Correct").css("display", "none");
      
  })

})

$("#tbl").on('click', '.btnDelete', function () {
  $(this).closest('tr').remove();
});