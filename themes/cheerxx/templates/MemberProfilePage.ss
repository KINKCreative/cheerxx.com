<% include Header %>


<body class="security">

	<div class="layout">
		<div class="row">
			<div class="large-6 large-centered columns">
				<a href="./" title="CheerXX"><img src="$ThemeDir/images/logo.png" alt="CheerXX" width="300" /></a>
				<h1>$Title</h1>
				$Content
				$CustomHtml.RAW
				$Form
			</div>
		</div>
	</div>
  
 	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 	<script type="text/javascript" src="$ThemeDir/foundation/js/foundation.min.js"></script>
 	<script type="text/javascript">
 		(function( $ ) {
 		   $(document).foundation();
 		})( jQuery );  
 	</script>
 	<script type="text/javascript" src="$ThemeDir/javascript/script.js"></script>
 	<% include GoogleAnalytics %>
 </body>
 </html>