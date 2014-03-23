<link href="plugins/jquery-growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
<script src="plugins/jquery-growl/javascripts/jquery.growl.js" type="text/javascript"></script>
<script type="text/javascript">
\$(document).ready(function() {
	\$.get("/api/v1/Video/{$Item.ID}/playcount", function(data) {
		result = \$.parseJSON(data);
		\$(".playCount").html(result["playCount"]);
	});
	\$(".like").on("click",function(e) { 
		e.preventDefault();
		var \$t = \$(this); 
		id = \$(this).data("id"); 
		if(\$(this).hasClass("likes")) { 
			action = "unlike"; 
		} else {
			action = "like"; 
		} 
   		id = \$(this).data("id"); 
   		\$.get("/api/v1/Video/"+id+"/"+action, function(data) { 
	   	 	result = \$.parseJSON(data);  
	   		if(result[0] == "success") { 
		   		\$t.toggleClass("likes").toggleClass("primary").toggleClass("secondary"); 
		   		\$(".noLikes").html(result[2]);
		   		\$.growl.notice({ title: "Success!", message: result[1] });
	   		} else { 
		   		\$.growl.error({ message: result[1] });
	   		} 
   		}); 
   	});
		\$(".favorite").on("click",function(e) {
		e.preventDefault(); 
		var \$t = \$(this); 
		id = \$(this).data("id"); 
		if(\$(this).hasClass("isfavorite")) { 
			action = "unfavorite"; 
		} else {
			action = "favorite"; 
		} 
   		id = \$(this).data("id"); 
   		\$.get("/api/v1/Video/"+id+"/"+action, function(data) { 
	   	 	result = \$.parseJSON(data);  
	   		if(result[0] == "success") { 
		   		\$t.toggleClass("isfavorite").toggleClass("alert").toggleClass("secondary"); 
		   		\$(".noFavorites").html(result[2]);
		   		\$.growl.notice({ title: "Success!", message: result[1] });
	   		} else { 
		   		\$.growl.error({ message: result[1] });
	   		} 
	   	}); 
   	});
});
</script>