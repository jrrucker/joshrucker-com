$(document).ready(function(){

	$(window).scroll(function(){
	
		var scrolled = $(window).scrollTop();
		$('body').css('background-position','0px ' + (0+(scrolled*.5))+'px');
		
	});
	
});