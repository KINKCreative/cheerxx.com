<script src="plugins/foundation/js/foundation/foundation.abide.js"></script>
<% if HasPayment %><script type="text/javascript" src="https://js.stripe.com/v2/"></script><% end_if %>

<script type="text/javascript">
	<% if HasPayment %>Stripe.setPublishableKey("{$StripePublishableKey}");<% end_if %>
	var guid = "{$VzaarObject.guid}",
		file = document.getElementById('file'),
		isComplete = false;		
	
	\$("#file").change(function(e){
		console.log("File changed");
	    checkFile();
	});
	
	function checkFile() {
		value = \$("#file").val();
		if(!value) { 
			\$(".file-error").html('Please attach the video file. Accepted formats include <strong>asf, avi, mov, mp4, m4v, wmv</strong>').addClass("alert").addClass("alert-box");
			return false;
		}
		ext = value.match(/\.([^\.]+)\$/)[1];
	    switch(ext.toLowerCase())
	    {
	    	//asf, avi, mov, mp4, m4v, wmv
	        case 'asf':
	        case 'avi':
	        case 'mov':
	        case 'mp4':
	        case 'm4v':
	        case 'wmv':
	//	            alert('allowed');
				\$(".file-error").hide();
				return true;
	            break;
	        default:
				\$(".file-error").html('Accepted formats include <strong>asf, avi, mov, mp4, m4v, wmv</strong>').addClass("alert").addClass("alert-box");
	            \$("#file").val('');
	            return false;
	            break;
	    }
	}
	
	function getXmlHttpObject() {
	    var xmlHttp;
	    try {
	        xmlHttp = new XMLHttpRequest();
	    } catch (e) {
	        try {
	            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	        } catch (e) {
	            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	    }
	    return xmlHttp;
	}
	
	function uploadFile() {
		/* \$("Form_UploadForm").on('valid', function () { */

		    \$('#uploadmodal').foundation('reveal', 'open');
			\$(".uploadButton").attr("disabled", "disabled").addClass("disabled");
			\$(".progress").fadeIn();
		
		    var file = document.getElementById('file').files[0];
		    var fd = new FormData();
		
		    fd.append('key', "{$VzaarObject.key}");
		    fd.append('AWSAccessKeyId', '{$VzaarObject.accesskeyid}');
		    fd.append('acl', '{$VzaarObject.acl}'); 
		    fd.append('policy', '{$VzaarObject.policy}')
		    fd.append('signature','{$VzaarObject.signature}');
		    fd.append('success_action_status', '201');
		
		    fd.append("file",file);
		
		    var xhr = new getXmlHttpObject();
		
		    xhr.upload.addEventListener("progress", uploadProgress, false);
		    xhr.addEventListener("load", uploadComplete, false);
		    xhr.addEventListener("error", uploadFailed, false);
		    xhr.addEventListener("abort", uploadCanceled, false);
		
		    xhr.open('POST', 'https://{$VzaarObject.bucket}.s3.amazonaws.com/', true); //MUST BE LAST LINE BEFORE YOU SEND 
		
		    xhr.send(fd);
		    
		/* }); */
	}
				
	function uploadProgress(evt) {
	    if (evt.lengthComputable) {
	      var percentComplete = Math.round(evt.loaded * 100 / evt.total);
	      \$(".progress .meter").css("width", percentComplete.toString() + '%');
	      \$(".percentage").text	(percentComplete.toString() + '%');
	    }
	    else {
	      document.getElementById('progress').innerHTML = 'unable to compute';
	    }
	  }
	
	  function uploadComplete(evt) {
	  	
	    /* This event is raised when the server send back a response */
	    console.log("Video file upload done: " + evt.target.responseText );
	    isComplete = true;
	    
//	    \$('.uploadwrap').fadeOut();
//	    \$('#uploadmodal').foundation('reveal', 'close');
		\$('#Form_UploadForm').unbind("submit");
	    \$('#Form_UploadForm').submit();
	  }
	
	  function uploadFailed(evt) {
	  	\$(".uploadButton").attr("disabled", false).removeClass("disabled");
	  	\$('#uploadmodal').foundation('reveal', 'close');
	  	\$("#uploadstatus").fadeIn();
	  	\$("#uploadstatus h2").innerHTML("Upload failed.");
	  	\$("#uploadstatus .message").innerHTML("Error: ".evt);
	  	\$('.uploadButton').attr('disabled', false);
	  }
	
	  function uploadCanceled(evt) {
	  	\$(".uploadButton").attr("disabled", false).removeClass("disabled");
	  	\$('#uploadmodal').foundation('reveal', 'close');
	  	\$("#uploadstatus").fadeIn();
	  	\$("#uploadstatus h2").innerHTML("Upload cancelled.");
	  	\$("#uploadstatus .message").innerHTML("Please refresh this page and try again.");
	  	\$('.uploadButton').attr('disabled', false);
	//			    alert("The upload has been canceled by the user or the browser dropped the conn\ction.");
	  }
	  
	  <% if HasPayment %>
	  var stripeResponseHandler = function(status, response) {
	    var form = \$('#Form_UploadForm');
	  
	    if (response.error) {
	      // Show the errors on the form
	      \$('.payment-errors').text(response.error.message).addClass("alert").addClass("alert-box");
	      form.find('button').attr('disabled', false);
	    } else {
	      // token contains id, last4, and card type
	      var token = response.id;
	      // Insert the token into the form so it gets submitted to the server
	      form.append(\$('<input type="hidden" name="stripeToken" />').val(token));
	      // and submit
	      //form.get(0).submit();
	      uploadFile();
	    }
	  };
	  <% end_if %>
	  
	  jQuery(function(\$) {
	  
	  	\$(document).ready(function() {
	  		\$(".progress").hide();
	  		\$("#uploadstatus").hide();
	  	});
	  	
	  	\$('#Form_UploadForm').submit(function(e){
	  		e.preventDefault();
	  		var checkfile = checkFile();
	  		\$(this).find('button').attr('disabled', "disabled");
	  		<% if HasPayment %>
	  			if(!isComplete || !checkfile) {
	  				Stripe.card.createToken(\$(this), stripeResponseHandler);
	  			}
	  		<% else %>
	  			if(!isComplete && checkfile) {
					uploadFile();
				}
			<% end_if %>
	  	 });
	  	
	  });
	  
</script>
