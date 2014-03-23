<form $FormAttributes>
	
	<div class="row">
	    <div class="large-12 columns">
	
		    <% if $Message %>
		        <p id="{$FormName}_error" class="message $MessageType">$Message</p>
		    <% else %>
		        <p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
		    <% end_if %>
		     
		    <fieldset>
		        
		        <% loop Fields %>
			        $FieldHolder
		        <% end_loop %>
		         
		    </fieldset>
		     
		    <% if $Actions %>
		    <div class="Actions">
		        <% loop $Actions %>$Field<% end_loop %>
		    </div>
		    <% end_if %>

	    </div>
	    </div>
</form>