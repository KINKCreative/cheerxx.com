<% include Header %>


<body class="security TempPage">

	<div class="layout">
		<div class="row">
			<div class="medium-6 medium-centered columns">
				<img src="$ThemeDir/images/logo-mini.png" alt="CheerXX" />
				$Content
				$Form
				$CustomHtml.RAW
				<div class="countdown simple"></div>
				
			</div>
		</div>
	</div>
  
  <script type="text/javascript" src="plugins/foundation/js/foundation.min.js"></script>
  <script type="text/javascript" src="plugins/countdown/jquery.countdown.js"></script>
  <script type="text/javascript">
  	   $(function() {
          var endDate = "April 13, 2014 20:00:00";
          $('.countdown.simple').countdown({
          	date: endDate,
          	render: function(data) {
          	  $(this.el).html("<h1><strong>" + this.leadingZeros(data.days, 2) + " </strong> days <strong>" + this.leadingZeros(data.hours, 2) + "</strong> hrs <strong>" + this.leadingZeros(data.min, 2) + "</strong> min </strong>" + this.leadingZeros(data.sec, 2) + "</strong> sec</h1>");
          	}
          });
  	   });
  	  $(document).foundation();
  </script>
  <script type="text/javascript" src="$ThemeDir/javascript/script.js"></script>

  
  </body>
  </html>