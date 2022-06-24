//$("i").focus(function() {
 //$(".Correct").css("display", "none");
//$(this).next("span").css("display", "inline");
///});
if (document.querySelector('input[name="radio"]')) {
  document.querySelectorAll('input[name="radio"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
      $(".Correct").css("display", "none");
      $(this).next("span").css("display", "block");
    });
  });
}