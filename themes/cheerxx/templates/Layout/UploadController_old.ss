<div class="row">
<div class="large-9 large-centered columns">
	<h1>Upload your video</h1>
	
	<div class="panel uploadwrap">
	
		<div id="uploadstatus" data-alert class="alert-box radius">
		  <h2 class="status"></h2>
		  <p class="message"></p>
		  <p>Click here for <a href="#">support</a>. Or you can send us <a href="#">an e-mail</a>.</p>
		  <a href="#" class="close">&times;</a>
		</div>
	
		<% with VzaarObject %>
		
		<!-- <form enctype="multipart/form-data" method="post" action="https://{$bucket}.s3.amazonaws.com/">
			  <input name="key" value="$key" type="hidden" />
			  <input name="AWSAccessKeyId" value="$accesskeyid" type="hidden" /> 
			  <input name="acl" value="$acl" type="hidden" /> 
			  <input name="policy" value="$policy" type="hidden" />
			  <input name="success_action_redirect" value="http://cheerxx.com/upload?done=1" type="hidden" />
			  <input name="success_action_status" value="201" type="hidden" />
			  <input name="signature" value="$signature" type="hidden" />
		
		      File to upload to S3: 
		      <input name="file" type="file" /> 
		      <br /> 
		      <input value="Upload File to S3" type="submit" /> -->
		
		<form id="uploadform" enctype="multipart/form-data" method="post" data-abide>
		<div class="row">
		  <label for="title">Enter description</label>
		  <textarea rows="4" cols="50" name="description" type="text" required pattern="[a-zA-Z]+"></textarea>
		  <small class="error">Enter your description.</small>
		  <label for="file">Select a File to Upload</label><br />
		  <input type="file" name="file" id="file" required accept="video/*" />
		  <small class="error">Please attach the file. Accepted formats include <strong>asf, avi, mov, mp4, m4v, wmv</strong>.</small>
		</div>
		<div id="fileName"></div>
		<div id="fileSize"></div>
		<div id="fileType"></div>
		<div class="row">
			<button type="submit" value="Upload" class="button radius uploadButton">Submit</button>
		</div>
		</form>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$(".progress").hide();
				$("#uploadstatus").hide();
			});
			
			var guid = "{$guid}",
				file = document.getElementById('file');
			
			file.onchange = function(e){
			    var ext = this.value.match(/\.([^\.]+)$/)[1];
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
			            break;
			        default:
			//	            alert('not allowed');
			            this.value='';
			    }
			};
			
			
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
			
			$('#uploadform').submit(function(e){
				
				e.preventDefault();
				$(this).on('valid', function () {
					
				    $('#uploadmodal').foundation('reveal', 'open');
			    	$(".uploadButton").attr("disabled", "disabled").addClass("disabled");
			    	$(".progress").fadeIn();
			    
			        var file = document.getElementById('file').files[0];
			        var fd = new FormData();
			    
			        fd.append('key', "{$key}");
			        fd.append('AWSAccessKeyId', '{$accesskeyid}');
			        fd.append('acl', '{$acl}'); 
			        fd.append('policy', '{$policy}')
			        fd.append('signature','{$signature}');
			        fd.append('success_action_status', '201');
			    
			        fd.append("file",file);
			    
			        var xhr = new getXmlHttpObject();
			    
			        xhr.upload.addEventListener("progress", uploadProgress, false);
			        xhr.addEventListener("load", uploadComplete, false);
			        xhr.addEventListener("error", uploadFailed, false);
			        xhr.addEventListener("abort", uploadCanceled, false);
			    
			        xhr.open('POST', 'https://{$bucket}.s3.amazonaws.com/', true); //MUST BE LAST LINE BEFORE YOU SEND 
			    
			        xhr.send(fd);
			        
				});
			    
			 });
			
			function uploadProgress(evt) {
			    if (evt.lengthComputable) {
			      var percentComplete = Math.round(evt.loaded * 100 / evt.total);
			      $(".progress .meter").css("width", percentComplete.toString() + '%');
			      $(".percentage").text	(percentComplete.toString() + '%');
			    }
			    else {
			      document.getElementById('progress').innerHTML = 'unable to compute';
			    }
			  }
			
			  function uploadComplete(evt) {
			  	
			    /* This event is raised when the server send back a response */
			    alert("Done - " + evt.target.responseText );
			    //TRIGGER PROCESS ON SEVER
			    
			    $('.uploadwrap').fadeOut();
			    $('#uploadmodal').foundation('reveal', 'close');
			  }
			
			  function uploadFailed(evt) {
			  	$(".uploadButton").attr("disabled", false).removeClass("disabled");
			  	$('#uploadmodal').foundation('reveal', 'close');
			  	$("#uploadstatus").fadeIn();
			  	$("#uploadstatus h2").innerHTML("Upload failed.");
			  	$("#uploadstatus .message").innerHTML("Error: ".evt);
			  }
			
			  function uploadCanceled(evt) {
			  	$(".uploadButton").attr("disabled", false).removeClass("disabled");
			  	$('#uploadmodal').foundation('reveal', 'close');
			  	$("#uploadstatus").fadeIn();
			  	$("#uploadstatus h2").innerHTML("Upload cancelled.");
			  	$("#uploadstatus .message").innerHTML("Please refresh this page and try again.");
	
			//			    alert("The upload has been canceled by the user or the browser dropped the conn\ction.");
			  }
		</script>
		
		<% end_with %>
	</div>

</div>
</div>

<div id="uploadmodal" class="reveal-modal medium" data-reveal>
	<div class="progress round">
	  <span class="meter" style="width:0;"></span>
	</div>	
	<h1 class="percentage">0%</h1>
	<h3>Upload in progress.</h3>
	<p>Do not press refresh or close window.</p>
</div>