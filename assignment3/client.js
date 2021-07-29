var pollServer = function() {
    $.get('chat.php', function(result) {
        
        if(!result.success) {
            console.log("Error polling server for new messages!");
            return;
        }
        
        $.each(result.messages, function(idx) {
            
            var chatBubble;
            if(this.sent_by == 'self') {
				var selfColor = '<div class="row bubble-sent pull-right" style= "background: #' 
                + this.color + '; border-color: #' + this.color + '; --color: #' + this.color + '; color: white">';
                chatBubble = $(selfColor + 
                               'me: ' + this.message + 
                               '</div><div class="clearfix"></div>');
            } else {
				var otherColor = '<div class="row bubble-recv" style="background: #'
                + this.color + '; --color: #' + this.color + '; color: white">';
                chatBubble = $(otherColor + 
                               this.username + ": " + this.message + 
                               '</div><div class="clearfix"></div>');
            }
            
            $('#chatPanel').append(chatBubble);
        });
        
        setTimeout(pollServer, 5000);
    });
}

$(document).on('ready', function() {
    pollServer();
    
    $('button').click(function() {
        $(this).toggleClass('active');
    });
});

$('#sendMessageBtn').on('click', function(event) {
    event.preventDefault(); 
    
    var message = $('#chatMessage').val();
    let URLparams = new URLSearchParams(location.search);
    var username = URLparams.get('username');
	var color = URLparams.get('color');
    
    $.post('chat.php', {
        'message' : message,
        'username': username,
		'color' : color
    }, function(result) {
        
        $('#sendMessageBtn').toggleClass('active');
        
        
        if(!result.success) {
            alert("There was an error sending your message");
        } else {
            console.log("Message sent!");
            $('#chatMessage').val('');
        }
    });
    
});