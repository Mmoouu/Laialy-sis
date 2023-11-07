
$(document).ready(function() {
    $(".li_desplegar").click(function(){
        $(this).toggleClass("active");
        $(this).prev("li").toggleClass("active");
    });
});
