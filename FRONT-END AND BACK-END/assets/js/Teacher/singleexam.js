
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


