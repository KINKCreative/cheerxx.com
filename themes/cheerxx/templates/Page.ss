<% include Header %>


<body class="$ClassName">
	
	<% include TopBar %>
		
	<div class="menuwrap">
		<div class="row">
			<div class="large-3 columns">
				<a href="./"><img src="$ThemeDir/images/logo-norm.png" alt="CheerXX" class="logo-norm" /></a>
			</div>
			<div class="large-9 columns">
				<% include Menu %>
			</div>
		</div>
	</div>
	
	$Layout

	<% include Footer %>


	<script type="text/javascript" src="plugins/foundation/js/foundation.min.js"></script>
	<script type="text/javascript">
		  $(document).foundation({$FoundationConfig});
	</script>
	$ExtraJavascript
	<script type="text/javascript" src="$ThemeDir/javascript/script.js"></script>
	<% include GoogleAnalytics %>
</body>
</html>