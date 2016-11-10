// Wait onload - jQuery load and then we use it
window.onload = function () {
	
	// ----------------------------------------------------------------------------
	// Check message input. Disable send button if text is empty and enable it text 
	// it not empty
	// ----------------------------------------------------------------------------

	$('#chats-index-user-message').keyup(function(){
		if($(this).val() === ""){
			$('#chats-index-message-send').prop("disabled",true);
		}
		else{
			$('#chats-index-message-send').prop("disabled",false);
		}
	});

};