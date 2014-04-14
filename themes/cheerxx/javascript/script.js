(function( $ ) {
$(document).ready(function() {

	$('.action').addClass('button').addClass('radius');
	$(".message").addClass("alert-box").each(function() {
	    if($(this).html() == '') {
	    	$(this).hide();
		}
	});
	$(".warning").addClass("alert-box").addClass("alert");
	
	$window = $(window);
                
	$('section[data-type="background"]').each(function(){
		var $bgobj = $(this); // assigning the object            
		$(window).scroll(function() {
			var yPos = -($window.scrollTop() / $bgobj.data('speed')); 
			var coords = '50% '+ yPos + 'px';
			$bgobj.css({ backgroundPosition: coords });
		});
	});
	
	$(".RecruitingProfile_Profile").append('<script src="plugins/raty/lib/jquery.raty.js"></script>');
	$(".RecruitingProfile_Profile .skillScore").raty({
		score: function() {
		    return $(this).attr('data-score');
		},
		readOnly: true
	});
	
});

})( jQuery );
document.createElement("article");
document.createElement("section");

