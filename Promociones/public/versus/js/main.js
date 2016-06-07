$(document).ready(function() {
	$("#open2").on('click', function(event) {
		event.preventDefault();
		if (!$(this).hasClass('close')){
			$(this).addClass('close');
			console.log("open");
		}else{
			$(this).removeClass('close');
			console.log("close");
		}
	});
	$( "#open2" ).mouseenter(function() {
			$(this).removeClass('close');
	  })
	  .mouseleave(function() {
	  		$(this).addClass('close');
	  });
	$(document).click(function(event) { 
		if(!$(event.target).closest('#open2').length) {
	    	$('#open2').addClass('close');
		}
	});
});