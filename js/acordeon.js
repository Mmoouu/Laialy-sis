$(".desp").click(function(){		
   var contenido=$(this).next(".tabla_carteles_interior");			
   if(contenido.css("display")=="none"){ //open		
      contenido.slideDown(250);			
      $(this).addClass("active");
   }
   else{ //close		
      contenido.slideUp(250);
      $(this).removeClass("active");	
  }							
});

   