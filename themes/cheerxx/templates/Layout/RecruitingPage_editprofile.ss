<% include Heading %>

<div class="layout">
	<div class="row">
		<div class="large-12 columns">
				
			<article>
				$Message
				$Form
			</article>
	
		</div>
	</div>
</div>

<link rel="stylesheet" href="/plugins/chosen/chosen.css">
<script src="/plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
  /* var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"} }*/
    $(".chosen-select select").chosen({allow_single_deselect:true});
</script>