
$(document).ready(function() {
    $("#botonera_nav div").click(function(){
        if ($(this).hasClass("active")){
            $("#botonera_nav div").removeClass("active");
            $("#botonera_nav ul").removeClass("active");            
        } else {
            $("#botonera_nav div").removeClass("active");
            $("#botonera_nav ul").removeClass("active");
            $(this).toggleClass("active");
            $(this).next("ul").toggleClass("active");    
        }                
    });
});